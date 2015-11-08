<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Navigation;
use Permission;
use Setting;
use Schema;
use NavigationSetting;

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
        $this->registerMailer();
        $this->registerSettings();
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
        
        $this->app['navigationSetting'] = $this->app->share(function($app)
        {
            return new \App\Supports\Settings\NavigationSetting;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Navigation', 'App\Supports\Navigation\NavigationFacade');
            $loader->alias('Permission', 'App\Supports\Permission\PermissionsFacade');
            $loader->alias('NavigationSetting', 'App\Supports\Settings\SettingFacade');
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
    
    public function registerSettings()
    {
        NavigationSetting::register([
            'email' => [
                'label' => 'Email',
                'icon' => 'fa fa-mail',
                'url'   => '/settings/email',
                'order' => 0,
                'segment' => 2,
                'permissions' => [
                    'setting.email'
                ],
            ],
        ]);
    }

    public function registerMailer()
    {
        if (Schema::hasTable('settings'))
        {
            if(Setting::has('system_mail')){
                $config = $this->app->make('config');
                $settings = Setting::get('system_mail');
                $config->set('mail.driver', $settings->mail_method);
                $config->set('mail.from.name', $settings->sender_name);
                $config->set('mail.from.address', $settings->sender_email);

                switch ($settings->mail_method) {

                    case 'smtp':
                    $config->set('mail.host', $settings->smtp_address);
                    $config->set('mail.port', $settings->smtp_port);
                    if (isset($settings->smtp_authorization)) {
                        $config->set('mail.username', $settings->smtp_username);
                        $config->set('mail.password', $settings->smtp_password);
                    }
                    else {
                        $config->set('mail.username', null);
                        $config->set('mail.password', null);
                    }
                    break;

                    case 'sendmail':
                    $config->set('mail.sendmail', $settings->sendmail_path);
                    break;

                    case 'mailgun':
                    $config->set('services.mailgun.domain', $settings->mailgun_domain);
                    $config->set('services.mailgun.secret', $settings->mailgun_secret);
                    break;

                    case 'mandrill':
                    $config->set('services.mandrill.secret', $settings->mandrill_secret);
                    break;
                }
            }
        }
    }
}
