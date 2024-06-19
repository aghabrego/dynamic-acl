<?php

namespace DynamicAcl\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use DynamicAcl\Macros\HasPermission;
use DynamicAcl\Macros\IsOwner;
use DynamicAcl\Models\Role;
use Illuminate\Support\ServiceProvider;
use DynamicAcl\Http\Middleware\{Admin, Authorize};
use DynamicAcl\Console\Commands\MakeAdmin;
use DynamicAcl\Separators\Separator;
use Javoscript\MacroableModels\Facades\MacroableModels;

class DynamicAclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if(!config('dynamicACL.enable', true)) {
            return;
        }

        $this->setSeparatorDriver();

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'dynamicACL');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'dynamicACL');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->publishes([
            __DIR__ . '/../../config/dynamicACL.php' => config_path('dynamicACL.php'),

            __DIR__ . '/../../database/migrations/2019_10_03_999999_create_roles_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_999999_create_roles_table.php'),
        ]);

        $this->registerMacros();

        $this->registerMiddlewares();

        $this->registerCommands();

        $this->registerViewComposers();
    }

    protected function setSeparatorDriver()
    {
        $this->app->bind('acl_handler', Separator::class);
    }

    private function registerMacros()
    {
        $authModel = config('auth.providers.users.model');

        throw_if(!class_exists($authModel), new \Exception("The class \"$authModel\" does not exists"));

        /* MacroableModels::addMacro($authModel, 'roles', function () {
             return $this->belongsToMany(Role::class);
        }); */

        $authModel::resolveRelationUsing('roles', function ($userModel) {
            return $userModel->belongsToMany(Role::class);
        });

        MacroableModels::addMacro($authModel, 'isOwner', IsOwner::GetMacro());

        MacroableModels::addMacro($authModel, 'hasPermission', HasPermission::GetMacro());
    }

    private function registerMiddlewares()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('dynamicAcl', Admin::class);
        $router->aliasMiddleware('authorize', Authorize::class);
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAdmin::class,
            ]);
        }
    }

    protected function registerViewComposers()
    {
        View::composer('dynamicACL::layout', function ($view) {
            $view->with([
                'alignment' => config('dynamicACL.alignment', 'ltr')
            ]);
        });
    }
}
