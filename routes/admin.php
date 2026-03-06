<?php

use Illuminate\Support\Facades\Route;
use App\Constants\Roles;

/*
|--------------------------------------------------------------------------
| Rutas del Panel Administrativo
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas del panel administrativo.
| Todas estas rutas requieren autenticación y rol de administrador.
|
*/

Route::middleware(['auth', 'role:' . Roles::ADMIN])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

    // Mi Perfil (foto, 2FA por correo, contraseña con código)
    Route::get('/perfil', function () {
        return view('admin.perfil');
    })->name('perfil');

    // Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', function () {
            return view('admin.usuarios.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('admin.usuarios.create');
        })->name('create');
        
        Route::get('/{user}/edit', function (\App\Models\User $user) {
            return view('admin.usuarios.edit', compact('user'));
        })->name('edit');
    });

    // Solicitudes de afiliación
    Route::prefix('solicitudes-afiliacion')->name('solicitudes-afiliacion.')->group(function () {
        Route::get('/', function () {
            $pendientes = \App\Models\SolicitudAfiliacion::with(['user', 'planExequial'])->pendientes()->orderByDesc('created_at')->get();
            $aprobadas = \App\Models\SolicitudAfiliacion::with(['user', 'planExequial', 'respondedBy'])->where('estado', 'aprobada')->orderByDesc('responded_at')->limit(20)->get();
            $rechazadas = \App\Models\SolicitudAfiliacion::with(['user', 'planExequial', 'respondedBy'])->where('estado', 'rechazada')->orderByDesc('responded_at')->limit(20)->get();
            return view('admin.solicitudes-afiliacion.index', compact('pendientes', 'aprobadas', 'rechazadas'));
        })->name('index');
        Route::post('/{solicitud}/aprobar', function (\App\Models\SolicitudAfiliacion $solicitud) {
            if ($solicitud->estado !== 'pendiente') {
                return redirect()->route('admin.solicitudes-afiliacion.index')->with('error', 'La solicitud ya fue procesada.');
            }
            if ($solicitud->user->afiliado) {
                $solicitud->update(['estado' => 'rechazada', 'observaciones' => 'Usuario ya afiliado.', 'responded_at' => now(), 'responded_by' => auth()->id()]);
                return redirect()->route('admin.solicitudes-afiliacion.index')->with('error', 'El usuario ya está afiliado.');
            }
            try {
                app(\App\Services\AfiliadoService::class)->create([
                    'user_id' => $solicitud->user_id,
                    'plan_exequial_id' => $solicitud->plan_exequial_id,
                    'fecha_afiliacion' => now()->toDateString(),
                    'estado' => 'activo',
                ]);
            } catch (\Throwable $e) {
                return redirect()->route('admin.solicitudes-afiliacion.index')->with('error', $e->getMessage());
            }
            $solicitud->update(['estado' => 'aprobada', 'responded_at' => now(), 'responded_by' => auth()->id()]);
            return redirect()->route('admin.solicitudes-afiliacion.index')->with('success', 'Solicitud aprobada y usuario afiliado correctamente.');
        })->name('aprobar');
        Route::post('/{solicitud}/rechazar', function (\App\Models\SolicitudAfiliacion $solicitud) {
            if ($solicitud->estado !== 'pendiente') {
                return redirect()->route('admin.solicitudes-afiliacion.index')->with('error', 'La solicitud ya fue procesada.');
            }
            $obs = request('observaciones', '');
            $solicitud->update(['estado' => 'rechazada', 'observaciones' => $obs, 'responded_at' => now(), 'responded_by' => auth()->id()]);
            return redirect()->route('admin.solicitudes-afiliacion.index')->with('success', 'Solicitud rechazada.');
        })->name('rechazar');
    });

    // Afiliados
    Route::prefix('afiliados')->name('afiliados.')->group(function () {
        Route::get('/', function () {
            return view('admin.afiliados.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.afiliados.create');
        })->name('create');
        Route::get('/{afiliado}/edit', function (\App\Models\Afiliado $afiliado) {
            return view('admin.afiliados.edit', compact('afiliado'));
        })->name('edit');
    });

    // Beneficiarios
    Route::prefix('beneficiarios')->name('beneficiarios.')->group(function () {
        Route::get('/', function () {
            return view('admin.beneficiarios.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.beneficiarios.create');
        })->name('create');
        Route::get('/{beneficiario}/edit', function (\App\Models\Beneficiario $beneficiario) {
            return view('admin.beneficiarios.edit', compact('beneficiario'));
        })->name('edit');
    });

    // Planes Exequiales
    Route::prefix('planes')->name('planes.')->group(function () {
        Route::get('/', function () {
            return view('admin.planes.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('admin.planes.create');
        })->name('create');
        
        Route::get('/{plan}', function (\App\Models\PlanExequial $plan) {
            return view('admin.planes.show', compact('plan'));
        })->name('show');
        
        Route::get('/{plan}/edit', function (\App\Models\PlanExequial $plan) {
            return view('admin.planes.edit', compact('plan'));
        })->name('edit');
    });

    // Servicios Funerarios
    Route::prefix('servicios')->name('servicios.')->group(function () {
        Route::get('/', function () {
            return view('admin.servicios.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.servicios.create');
        })->name('create');
        Route::get('/{servicio}/edit', function (\App\Models\ServicioFunerario $servicio) {
            return view('admin.servicios.edit', compact('servicio'));
        })->name('edit');
    });

    // Pagos
    Route::prefix('pagos')->name('pagos.')->group(function () {
        Route::get('/', function () {
            return view('admin.pagos.index');
        })->name('index');
        // Aquí irán más rutas de pagos
    });

    // Inventario
    Route::prefix('inventario')->name('inventario.')->group(function () {
        Route::get('/', function () {
            return view('admin.inventario.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.inventario.create');
        })->name('create');
        Route::get('/{inventario}/edit', function (\App\Models\Inventario $inventario) {
            return view('admin.inventario.edit', compact('inventario'));
        })->name('edit');
    });

    // Vehículos
    Route::prefix('vehiculos')->name('vehiculos.')->group(function () {
        Route::get('/', function () {
            return view('admin.vehiculos.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.vehiculos.create');
        })->name('create');
        Route::get('/{vehiculo}/edit', function (\App\Models\Vehiculo $vehiculo) {
            return view('admin.vehiculos.edit', compact('vehiculo'));
        })->name('edit');
    });

    // Salas de Velación
    Route::prefix('salas')->name('salas.')->group(function () {
        Route::get('/', function () {
            return view('admin.salas.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.salas.create');
        })->name('create');
        Route::get('/{sala}/edit', function (\App\Models\SalaVelacion $sala) {
            return view('admin.salas.edit', compact('sala'));
        })->name('edit');
    });

    // Reservas
    Route::prefix('reservas')->name('reservas.')->group(function () {
        Route::get('/', function () {
            return view('admin.reservas.index');
        })->name('index');
        // Aquí irán más rutas de reservas
    });

    // Obituarios
    Route::prefix('obituarios')->name('obituarios.')->group(function () {
        Route::get('/', function () {
            return view('admin.obituarios.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.obituarios.create');
        })->name('create');
        Route::get('/{obituario}/edit', function (\App\Models\Obituario $obituario) {
            return view('admin.obituarios.edit', compact('obituario'));
        })->name('edit');
    });

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', function () {
            return view('admin.reportes.index');
        })->name('index');
    });

    // Contabilidad (entradas/salidas, reportes mensual/anual)
    Route::prefix('contabilidad')->name('contabilidad.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ContabilidadController::class, 'index'])->name('index');
        Route::get('/reporte-mensual', [App\Http\Controllers\Admin\ContabilidadController::class, 'reporteMensual'])->name('reporte-mensual');
        Route::get('/reporte-anual', [App\Http\Controllers\Admin\ContabilidadController::class, 'reporteAnual'])->name('reporte-anual');
    });

    // Configuración
    Route::prefix('configuracion')->name('configuracion.')->group(function () {
        Route::get('/', function () {
            return view('admin.configuracion.index');
        })->name('index');
        // Aquí irán más rutas de configuración
    });
});

