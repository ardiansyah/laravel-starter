<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Navigation;
use Permission;
use Setting;
use Schema;
// use NavigationSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPermissions();

        $this->registerNavigation();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['navigation'] = $this->app->share(function($app)
        {
            return new \App\Supports\Navigation\NavigationManager;
        });

        $this->app['registerPermissions'] = $this->app->share(function($app)
        {
            return new \App\Supports\Permission\Permissions;
        });

        // $this->app['navigationSetting'] = $this->app->share(function($app)
        // {
        //     return new \App\Supports\Settings\NavigationSetting;
        // });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Navigation', 'App\Supports\Navigation\NavigationFacade');
            $loader->alias('Permission', 'App\Supports\Permission\PermissionsFacade');
            // $loader->alias('NavigationSetting', 'App\Supports\Settings\SettingFacade');
        });
    }

    public function registerNavigation()
    {
        Navigation::register([
            'dashboard' => [
                'label' => 'Dashboard',
                'icon' => 'fa fa-dashboard',
                'url'   => '/dashboard',
                'order' => 0,
                'permissions' => [
                    'view.dashboard',
                ],
            ],
            'users' => [
                'label' => 'User',
                'icon' => 'fa fa-user',
                'url'   => '/users',
                'order' => 1,
                'permissions' => [
                    'manage.user',
                ],
                'childMenu' => [
                    'user' => [
                        'label' => 'User',
                        'icon' => 'fa fa-user',
                        'url'   => '/users/user',
                        // 'segment' => 1,
                        'permissions' => [
                            'manage.user',
                        ],
                    ],
                    'role' => [
                        'label' => 'Role',
                        'icon' => 'fa fa-users',
                        'url'   => '/users/role',
                        // 'segment' => 1,
                        'permissions' => [
                            'manage.role',
                        ],
                    ]
                ]
            ],
        ]);
    }

    public function registerPermissions()
    {
        Permission::register([
            'Dashboard' => [
                'view.dashboard',
            ],
            'User' => [
                'manage.user',
                'create.user',
                'edit.user',
                'delete.user',
            ],
            'Role' => [
                'manage.role',
                'create.role',
                'edit.role',
                'delete.role',
            ],
            'Setting' => [
                'manage.setting',
                'setting.email',
            ],
        ]);
    }
}
