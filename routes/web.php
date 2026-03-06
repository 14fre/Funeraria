<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Aquí se definen las rutas públicas del sistema.
|
*/

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas públicas
Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/planes', function () {
    return view('planes');
})->name('planes');

Route::get('/obituarios', function (\Illuminate\Http\Request $request) {
    $cedula = trim($request->query('cedula', ''));
    $nombre = trim($request->query('nombre', ''));
    $obituarios = \App\Models\Obituario::query()->publicados()->orderByDesc('fecha_fallecimiento');
    if ($cedula !== '') {
        $obituarios->where('numero_documento', 'like', '%' . $cedula . '%');
    }
    if ($nombre !== '') {
        $obituarios->where('nombre_completo', 'like', '%' . $nombre . '%');
    }
    $obituarios = $obituarios->paginate(12)->withQueryString();
    $busqueda = ['cedula' => $cedula, 'nombre' => $nombre];
    return view('obituarios-publicos', compact('obituarios', 'busqueda'));
})->name('obituarios');

Route::get('/obituarios/{obituario}', function (\App\Models\Obituario $obituario) {
    if (!$obituario->publicado) {
        abort(404);
    }
    return view('obituario-show', compact('obituario'));
})->name('obituario.show');

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');

Route::get('/contacto', [App\Http\Controllers\ContactoController::class, 'index'])->name('contacto');
Route::post('/contacto', [App\Http\Controllers\ContactoController::class, 'store'])->name('contacto.store');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| Las rutas de autenticación son manejadas por Laravel Fortify.
| Se redirige automáticamente según el rol después del login.
|
*/

// 2FA por correo y cambio de contraseña con código
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/user/two-factor-email/enable', [App\Http\Controllers\TwoFactorEmailController::class, 'enable'])->name('two-factor-email.enable');
    Route::post('/user/two-factor-email/disable', [App\Http\Controllers\TwoFactorEmailController::class, 'disable'])->name('two-factor-email.disable');
    Route::post('/user/password-change/send-code', [App\Http\Controllers\PasswordChangeController::class, 'sendCode'])->name('password-change.send-code');
    Route::post('/user/password-change/with-code', [App\Http\Controllers\PasswordChangeController::class, 'changeWithCode'])->name('password-change.with-code');
});

// Ruta genérica de dashboard (redirige según rol)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Cargar la relación role si no está cargada
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // Redirigir según el rol
        return redirect($user->getDashboardRoute());
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Rutas del Panel Administrativo
|--------------------------------------------------------------------------
*/
require __DIR__.'/admin.php';

/*
|--------------------------------------------------------------------------
| Rutas del Portal del Cliente
|--------------------------------------------------------------------------
*/
require __DIR__.'/cliente.php';
