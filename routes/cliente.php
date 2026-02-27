<?php

use Illuminate\Support\Facades\Route;
use App\Constants\Roles;

/*
|--------------------------------------------------------------------------
| Rutas del Portal del Cliente
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas del portal del cliente.
| Todas estas rutas requieren autenticación y rol de cliente.
|
*/

Route::middleware(['auth', 'role:' . Roles::CLIENTE])->prefix('cliente')->name('cliente.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $afiliado = $user->afiliado;
        $totalBeneficiarios = $afiliado ? $afiliado->beneficiarios()->count() : 0;
        $proximoPago = 'No programado';
        if ($afiliado) {
            $pago = $afiliado->pagos()->where('estado', 'pendiente')->where('fecha_pago', '>=', now()->toDateString())->orderBy('fecha_pago')->first();
            if ($pago) {
                $proximoPago = $pago->fecha_pago?->format('d/m/Y') ?? 'No programado';
            }
        }
        return view('cliente.dashboard', compact('afiliado', 'totalBeneficiarios', 'proximoPago'));
    })->name('dashboard');

    // Solicitar afiliación (solo si no está afiliado)
    Route::get('/solicitar-afiliacion', function () {
        $user = auth()->user();
        if ($user->afiliado) {
            return redirect()->route('cliente.plan.index')->with('info', 'Ya estás afiliado a un plan.');
        }
        $solicitudPendiente = \App\Models\SolicitudAfiliacion::where('user_id', $user->id)->pendientes()->first();
        if ($solicitudPendiente) {
            return redirect()->route('cliente.plan.index')->with('info', 'Ya tienes una solicitud de afiliación en proceso. Te notificaremos cuando sea revisada.');
        }
        $planes = app(\App\Services\PlanExequialService::class)->getActivos();
        return view('cliente.solicitar-afiliacion', compact('planes'));
    })->name('solicitar-afiliacion');
    Route::post('/solicitar-afiliacion', function () {
        $user = auth()->user();
        if ($user->afiliado) {
            return redirect()->route('cliente.plan.index')->with('error', 'Ya estás afiliado. No puedes solicitar afiliación.');
        }
        $solicitudPendiente = \App\Models\SolicitudAfiliacion::where('user_id', $user->id)->pendientes()->first();
        if ($solicitudPendiente) {
            return redirect()->route('cliente.plan.index')->with('error', 'Ya tienes una solicitud en proceso. Espera la respuesta del administrador.');
        }
        $data = request()->validate([
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
        ]);
        \App\Models\SolicitudAfiliacion::create([
            'user_id' => $user->id,
            'plan_exequial_id' => $data['plan_exequial_id'],
            'estado' => 'pendiente',
            'mensaje' => $data['mensaje'] ?? null,
        ]);
        return redirect()->route('cliente.plan.index')->with('success', 'Solicitud enviada. Revisaremos tu solicitud y te notificaremos cuando sea aprobada.');
    })->name('solicitar-afiliacion.store');

    // Mi Plan
    Route::prefix('plan')->name('plan.')->group(function () {
        Route::get('/', function () {
            $user = auth()->user();
            $afiliado = $user->afiliado;
            $plan = $afiliado?->planExequial;
            $solicitudPendiente = $afiliado ? null : \App\Models\SolicitudAfiliacion::where('user_id', $user->id)->pendientes()->with('planExequial')->first();
            return view('cliente.plan.index', compact('afiliado', 'plan', 'solicitudPendiente'));
        })->name('index');
    });

    // Beneficiarios
    Route::prefix('beneficiarios')->name('beneficiarios.')->group(function () {
        Route::get('/', function () {
            $afiliado = auth()->user()->afiliado;
            $beneficiarios = $afiliado ? app(\App\Services\BeneficiarioService::class)->getByAfiliado($afiliado->id) : collect();
            return view('cliente.beneficiarios.index', compact('afiliado', 'beneficiarios'));
        })->name('index');
        Route::get('/create', function () {
            $afiliado = auth()->user()->afiliado;
            if (!$afiliado) {
                return redirect()->route('cliente.dashboard')->with('error', 'Debes tener un plan asignado para agregar beneficiarios.');
            }
            return view('cliente.beneficiarios.create', compact('afiliado'));
        })->name('create');
        Route::post('/', function () {
            $afiliado = auth()->user()->afiliado;
            if (!$afiliado) {
                return redirect()->route('cliente.dashboard')->with('error', 'Debes tener un plan asignado.');
            }
            $data = request()->validate([
                'afiliado_id' => ['required', 'in:' . $afiliado->id],
                'tipo_documento' => ['required', 'in:CC,CE,TI,PASAPORTE'],
                'numero_documento' => ['required', 'string', 'max:20'],
                'nombres' => ['required', 'string', 'max:255'],
                'apellidos' => ['required', 'string', 'max:255'],
                'fecha_nacimiento' => ['required', 'date'],
                'genero' => ['nullable', 'in:M,F,Otro'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'email' => ['nullable', 'email', 'max:255'],
                'parentesco' => ['required', 'string', 'max:50'],
                'direccion' => ['nullable', 'string', 'max:500'],
                'ciudad' => ['nullable', 'string', 'max:100'],
                'departamento' => ['nullable', 'string', 'max:100'],
            ]);
            $data['activo'] = true;
            try {
                app(\App\Services\BeneficiarioService::class)->create($data);
                return redirect()->route('cliente.beneficiarios.index')->with('success', 'Beneficiario agregado correctamente.');
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()->withErrors($e->validator)->withInput();
            }
        })->name('store');
    });

    // Servicios
    Route::prefix('servicios')->name('servicios.')->group(function () {
        Route::get('/', function () {
            $afiliado = auth()->user()->afiliado;
            $servicios = $afiliado ? app(\App\Services\ServicioFunerarioService::class)->getByAfiliado($afiliado->id) : collect();
            return view('cliente.servicios.index', compact('afiliado', 'servicios'));
        })->name('index');
        Route::get('/create', function () {
            $afiliado = auth()->user()->afiliado;
            if (!$afiliado) {
                return redirect()->route('cliente.dashboard')->with('error', 'Debes tener un plan asignado para solicitar servicios.');
            }
            $afiliado->load('beneficiarios');
            return view('cliente.servicios.create', compact('afiliado'));
        })->name('create');
        Route::post('/', function () {
            $afiliado = auth()->user()->afiliado;
            if (!$afiliado) {
                return redirect()->route('cliente.dashboard')->with('error', 'Debes tener un plan asignado.');
            }
            $data = request()->validate([
                'afiliado_id' => ['required', 'in:' . $afiliado->id],
                'tipo' => ['required', 'in:velacion,velacion_virtual,cremacion,traslado_nacional,traslado_internacional'],
                'beneficiario_id' => ['nullable', 'exists:beneficiarios,id'],
                'observaciones' => ['nullable', 'string', 'max:2000'],
            ]);
            $data['estado'] = 'solicitado';
            $data['fecha_solicitud'] = now()->toDateString();
            app(\App\Services\ServicioFunerarioService::class)->create($data);
            return redirect()->route('cliente.servicios.index')->with('success', 'Solicitud enviada. Te contactaremos pronto.');
        })->name('store');
    });

    // Pagos
    Route::prefix('pagos')->name('pagos.')->group(function () {
        Route::get('/', function () {
            $afiliado = auth()->user()->afiliado;
            $pagos = $afiliado
                ? $afiliado->pagos()->orderByDesc('created_at')->paginate(10)
                : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            return view('cliente.pagos.index', compact('afiliado', 'pagos'));
        })->name('index');
        Route::get('/create', function () {
            $afiliado = auth()->user()->afiliado;
            if (!$afiliado) {
                return redirect()->route('cliente.dashboard')->with('error', 'Debes tener un plan asignado para realizar pagos.');
            }
            return view('cliente.pagos.create', compact('afiliado'));
        })->name('create');
    });

    // Obituarios (solo lectura)
    Route::prefix('obituarios')->name('obituarios.')->group(function () {
        Route::get('/', function () {
            return view('cliente.obituarios.index');
        })->name('index');
        Route::get('/{id}', function ($id) {
            return view('cliente.obituarios.show', compact('id'));
        })->name('show');
    });

    // Sala Virtual
    Route::prefix('sala-virtual')->name('sala-virtual.')->group(function () {
        Route::get('/', function () {
            return view('cliente.sala-virtual.index');
        })->name('index');
        // Aquí irán más rutas de sala virtual
    });

    // Mi Perfil (vista elegante con foto de perfil)
    Route::get('/perfil', function () {
        return view('cliente.perfil');
    })->name('perfil');
});

