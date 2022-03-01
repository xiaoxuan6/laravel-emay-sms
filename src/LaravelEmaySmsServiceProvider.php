<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms;

use Illuminate\Support\ServiceProvider;

class LaravelEmaySmsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('laravel-emay-sms.php')
        ], 'laravel-emay-sms');
    }

    /**
     * Register any application services.
     *
     * @return void
     *
     * @see \Illuminate\Container\Container
     */
    public function register()
    {
        $this->app->singleton('laravel-emay-sms', function ($app) {
            return new LaravelEmaySmsManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'laravel-emay-sms'
        ];
    }
}
