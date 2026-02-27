<?php

namespace App\Providers;

use App\Contracts\Repositories\AfiliadoRepositoryInterface;
use App\Contracts\Repositories\BeneficiarioRepositoryInterface;
use App\Contracts\Repositories\InventarioRepositoryInterface;
use App\Contracts\Repositories\ObituarioRepositoryInterface;
use App\Contracts\Repositories\PlanExequialRepositoryInterface;
use App\Contracts\Repositories\ReservaRepositoryInterface;
use App\Contracts\Repositories\SalaVelacionRepositoryInterface;
use App\Contracts\Repositories\ServicioFunerarioRepositoryInterface;
use App\Contracts\Repositories\VehiculoRepositoryInterface;
use App\Repositories\AfiliadoRepository;
use App\Repositories\BeneficiarioRepository;
use App\Repositories\InventarioRepository;
use App\Repositories\ObituarioRepository;
use App\Repositories\PlanExequialRepository;
use App\Repositories\ReservaRepository;
use App\Repositories\SalaVelacionRepository;
use App\Repositories\ServicioFunerarioRepository;
use App\Repositories\VehiculoRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlanExequialRepositoryInterface::class,
            PlanExequialRepository::class
        );
        $this->app->bind(
            AfiliadoRepositoryInterface::class,
            AfiliadoRepository::class
        );
        $this->app->bind(
            BeneficiarioRepositoryInterface::class,
            BeneficiarioRepository::class
        );
        $this->app->bind(
            ServicioFunerarioRepositoryInterface::class,
            ServicioFunerarioRepository::class
        );
        $this->app->bind(
            InventarioRepositoryInterface::class,
            InventarioRepository::class
        );
        $this->app->bind(
            SalaVelacionRepositoryInterface::class,
            SalaVelacionRepository::class
        );
        $this->app->bind(
            ReservaRepositoryInterface::class,
            ReservaRepository::class
        );
        $this->app->bind(
            VehiculoRepositoryInterface::class,
            VehiculoRepository::class
        );
        $this->app->bind(
            ObituarioRepositoryInterface::class,
            ObituarioRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Definir rate limiters para Fortify
        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('two-factor', function ($request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Usar formulario de perfil propio para redirigir clientes a cliente.perfil
        Livewire::component(
            'profile.update-profile-information-form',
            \App\Http\Livewire\Profile\UpdateProfileInformationForm::class
        );
    }
}
