<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        //Altera o nome do sistema
        /*config([
            'adminlte.title' => optional(\App\Models\Empresa::first())->nome ?? 'Gestor EASE',
            'adminlte.logo' => optional(\App\Models\Empresa::first())->nome ?? 'Gestor EASE',
        ]);*/

        try {
            DB::connection()->getPdo();
            if (Schema::hasTable('empresa')) {
                config([
                    'adminlte.title' => optional(\App\Models\Empresa::first())->nome ?? 'Gestor EASE',
                    'adminlte.logo' => optional(\App\Models\Empresa::first())->nome ?? 'Gestor EASE',
                ]);
            }
        } catch (\Exception $e) {
            // Banco de dados não está disponível ou tabela não existe
            config([
                'adminlte.title' => 'Gestor EASE',
                'adminlte.logo' => 'Gestor EASE',
            ]);
        }

        //Adiciona a permissão
        Gate::define('gerenciar_usuarios', function ($user) {
            return $user->temRole('admin'); // método personalizado que você cria
        });

        Gate::define('gerenciar_produtos', function ($user) {
            return $user->temRole('gerente');
        });

        //Add menu Mesas
        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->addAfter('caixa',[
                'key' => 'pedido',
                'text' => 'Pedidos',
                'url'  => '/pedidos',
                'icon' => 'fa fa-fw fa-file-powerpoint',
                'label'       => \App\Models\Comanda::query()->where('status', 'aberta')->count(),
                'label_color' => 'success',
            ]);

            $event->menu->addAfter('pedido', [
                'text' => 'Mesas',
                'url' => '/mesas',
                'icon' => 'fa fa-fw fa-table',
                'label' => \App\Models\Mesa::count(),
                'label_color' => 'info'
            ]);
        });
    }
}
