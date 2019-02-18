<?php

use Stechstudio\LaravelSocialiteAuth\SocialiteController;
use Illuminate\Support\Facades\App;
Route::get('_oauth', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('oauth.login');
Route::get('login', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('login');
Route::get('_oauthcallback', SocialiteController::class . '@handleProviderCallback')->middleware(config('socialite-auth.middleware'))->name('oauth.callback');

// Give Nova is present and it's using the default app guard,
// and Given Socialite is that default guard, put a login route up.
if ((config('nova') && !config('nova.guard'))
    && config('auth.defaults.guard') == 'socialite') {
    Route::get('/nova2', function () {
        return redirect()->route('welcome');
    })->name('nova.login');
}