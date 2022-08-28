<?php

namespace App\Services\Fonky;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class FonkyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerCommands();

        $this->bootAuthenticationRoutes();

        $this->bootApiRoutes();
    }

    protected function registerCommands(): void
    {
        $this->app->bind('command.fonky:install', \App\Services\Fonky\Commands\InstallCommand::class);

        $this->commands([
            'command.fonky:install',
        ]);
    }

    protected function bootAuthenticationRoutes(): void
    {
        $this->app->router->group([
            'prefix' => 'auth',
        ], function ($router) {
            $router->post('register', [
                'uses' => \App\Services\Fonky\Actions\Auth\Register::class
            ]);
            $router->post('login', [
                'uses' => \App\Services\Fonky\Actions\Auth\Login::class,
            ]);
        });

        $this->app->router->group([
            'prefix' => 'auth',
            'middleware' => ['auth:api']
        ], function ($router) {
            $router->post('logout', [
                'uses' => \App\Services\Fonky\Actions\Auth\Logout::class
            ]);
        });
    }

    protected function bootApiRoutes(): void
    {
        $this->app->router->group([
            'prefix' => 'user',
            'middleware' => ['api', 'auth:api']
        ], function ($router) {
            $router->get('me', [
                'uses' => \App\Services\Fonky\Actions\User\Me::class
            ]);
        });

        $this->app->router->group([
            'prefix' => 'orders',
            'middleware' => ['api', 'auth:api']
        ], function ($router) {
            $router->get('/table-header', [
                'uses' => \App\Services\Fonky\Actions\Order\TableHeader::class
            ]);
            $router->get('/table-rows', [
                'uses' => \App\Services\Fonky\Actions\Order\TableRows::class
            ]);
        });
    }
}