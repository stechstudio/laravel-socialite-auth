<?php

use STS\SocialiteAuth\Http\Controllers\SocialiteController;

Route::get('_oauth', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('oauth.login');
Route::get('_login', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('login');
Route::get('_oauthcallback', SocialiteController::class . '@handleProviderCallback')->middleware(config('socialite-auth.middleware'))->name('oauth.callback');