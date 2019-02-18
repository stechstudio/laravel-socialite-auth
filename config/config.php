<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'driver' => env('SOCIALITE_AUTH_DRIVER', 'google'),
    'provider' => env('SOCIALITE_AUTH_PROVIDER', 'users'),
    'middleware' => env('SOCIALITE_AUTH_MIDDLEWARE', 'web'),
    'column' => env('SOCIALITE_AUTH_COLUMN', 'email')
];