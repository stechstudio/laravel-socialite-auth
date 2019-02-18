<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class LaravelSocialiteAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @param \Illuminate\Http\Request $request
     */
    public function boot(Request $request)
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishAssetsIfConsole();

        $this->registerSocialiteGuardMacro();
        $this->registerSocialiteAuthDriver();
        $this->addGuardToConfig();
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
    }

    private function publishAssetsIfConsole()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('socialite-auth.php'),
            ], 'config');
        }
    }

    public function registerSocialiteGuardMacro()
    {
        SessionGuard::macro('attemptFromSocialite', function(AuthenticatableSocialiteUser $user) {
            $modelField = 'email';

            if (method_exists($this->provider, 'createModel')) {
                $new = $this->provider->createModel();
                if ($new instanceof SocialiteAuthenticatable) {
                    $modelField = $new->getSocialiteCredentialField();
                }
            }

            $user = $this->provider->retrieveByCredentials([
                $modelField => $user->getSocialiteCredential()
            ]);

            if ($user && LaravelSocialiteAuthFacade::verifyBeforeLogin($user)) {
                $this->login($user);
                return true;
            }

            return false;
        });
    }

    public function registerSocialiteAuthDriver()
    {
        Auth::extend('socialite', function ($app, $name, array $config) {
            return Auth::createSessionDriver($name, $config);
        });
    }

    private function addGuardToConfig()
    {
        if (!config::has('auth.guards.socialite')) {
            config::set('auth.guards.socialite', [
                'driver' => 'socialite',
                'provider' => 'users'
            ]);
        }
    }
}