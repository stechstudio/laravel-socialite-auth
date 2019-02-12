<?php

use Stechstudio\LaravelSocialiteAuth\SocialiteController;

Route::get('_oauth', SocialiteController::class . '@redirectToProvider')->name('oauth.start')->middleware(config('socialite-auth.middleware'));
Route::get('_oauthcallback', SocialiteController::class . '@handleProviderCallback')->name('oauth.callback')->middleware(config('socialite-auth.middleware'));
