<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'driver' => env('SOCIALITE_AUTH_DRIVER', 'google'),
    'provider' => env('SOCIALITE_AUTH_PROVIDER', 'eloquent'),
    'middleware' => env('SOCIALITE_AUTH_MIDDLEWARE', 'web')
];