<?php

use STS\SocialiteAuth\Http\Controllers\SocialiteController;

Route::get('socialite-auth/start', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('oauth.start');
Route::get('socialite-auth/login', SocialiteController::class . '@redirectToProvider')->middleware(config('socialite-auth.middleware'))->name('login');
Route::get('socialite-auth/callback', SocialiteController::class . '@handleProviderCallback')->middleware(config('socialite-auth.middleware'))->name('oauth.callback');