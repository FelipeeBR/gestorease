<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('gerenciar_usuarios', function ($user) {
            return $user->temRole('admin'); // método personalizado que você cria
        });

        Gate::define('gerenciar_produtos', function ($user) {
            return $user->temRole('gerente');
        });
    }
}
