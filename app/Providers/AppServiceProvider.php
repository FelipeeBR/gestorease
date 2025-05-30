<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Event;

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

        /*$this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'text' => 'Mesas',
                'url'  => '/mesas',
                'icon' => 'fa fa-fw fa-table',
                'label'       => \App\Models\Mesa::count(),
                'label_color' => 'info',
                'order' => 1,
            ]);
            foreach($event->menu as $key => $item) {
                if(isset($item['text']) && $item['text'] === 'Mesas') {
                    $event->menu[$key]['label'] = \App\Models\Mesa::count();
                    $event->menu[$key]['label_color'] = 'info';
                }
            }
        });*/

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
