<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LaravelSocialiteAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-socialite-auth');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-socialite-auth');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');





        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('socialite-auth.php'),
            ], 'config');


            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-socialite-auth'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-socialite-auth'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-socialite-auth'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'socialite-auth');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-socialite-auth', function () {
            return new LaravelSocialiteAuth;
        });

        SessionGuard::macro('attemptWithSocialite', function($user) {
           $model = $this->provider->retrieveByCredentials([
               'email' => $user->email
           ]);

           if ($model && SocialiteAuth::allowsLogin($model)) {
               $this->login($model);
               return true;
           }

           return false;
        });

        Auth::extend('socialite', function ($app, $name, array $config) {
            return Auth::createSessionDriver($name, $config);
            //return new SocialiteGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
