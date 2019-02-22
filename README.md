# Quickly integrate Laravel Socialite into a Laravel app 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stechstudio/laravel-socialite-auth.svg?style=flat-square)](https://packagist.org/packages/stechstudio/laravel-socialite-auth)
[![Build Status](https://img.shields.io/travis/stechstudio/laravel-socialite-auth/master.svg?style=flat-square)](https://travis-ci.org/stechstudio/laravel-socialite-auth)
[![Quality Score](https://img.shields.io/scrutinizer/g/stechstudio/laravel-socialite-auth.svg?style=flat-square)](https://scrutinizer-ci.com/g/stechstudio/laravel-socialite-auth)
<!--- [![Total Downloads](https://img.shields.io/packagist/dt/stechstudio/laravel-socialite-auth.svg?style=flat-square)](https://packagist.org/packages/stechstudio/laravel-socialite-auth) -->

This package provides quick wiring and simple configuration for the most common ways in which you may wish to integrate [Laravel Socialite](https://github.com/laravel/socialite) into your application. 
In addition it extends that authentication flow, enabling further logic to verify that a user meets your unique requirements before logging in.

### Currently supports:
- Use as the primary and only authentication for your application.
- Route-specific authentication alongside Laravel's own Auth scaffolding or other authentication drivers.
- Use for authentication into Laravel Nova in addition to or separate from front-end app authentication.

### Not yet provided
- OAuth-only authentication with Socialite, not requiring users to be present in a Laravel user provider.
- Use with multiple Socialite providers (eg. Google and Facebook).
- Use of different providers for different routes (eg. Facebook for frontend, Google for Nova).

## Getting started

1. Install the composer package
    ```bash
    composer require stechstudio/laravel-socialite-auth
    ```
2. [Configure the Socialite provider](https://laravel.com/docs/5.7/socialite#configuration) you wish to use in
   `config/services.php`, specifying the redirect path as either the named route of `socialite-auth.callback` or
   the relative path `/socialite-auth/callback`. For example:
    ```php
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => route('socialite-auth.callback')
    ],
    ```
3. Implement this package's `SocialiteAuthenticatable` Interface on each user class in
   your application that corresponds to a Socialite user. These two methods return the 
   field and value which will be compared to the user returned by Socialite.
   
   ```php
   public function getSocialiteIdentifierName()
   {
       return 'email';
   }
    
   public function getSocialiteIdentifier()
   {
       return $this->email;
   }
   ```
   
   By default these values will be compared to the `email` attribute returned from socialite.
   Below you may configure this and other options.
4. Beyond matching a Socialite user to one in your database, you may optionally provide a closure to 
   ensure any additional requirements are met. Provide whatever logic you require by using this package's
   facade within your AppServiceProvider's `boot()` method as follows:
   ```php
   SocialiteAuth::beforeLogin(function($user) {
       return str_contains($user->email, ['example.com']);
   });
   ```  
   
## Configuration

After publishing this package's configration, the following options will be available to you in `config/socialite-auth.php`.

| Field      | Description |
| ---------- | ----------- |
| driver     | The OAuth service to be used by Socialite. The corresponding credentials must be provided in your services config. The default is `google`.  |
| provider   | The user provider which contains the users you are authenticating with Socialite. Default is `users` |
| middleware | Additional middleware to apply to the OAuth routes. Default is `web`. |
| field      | The socialite field which will be compared to the value returned by the `SocialiteAuthenticatable` interface. Default is `email`. |


## Usage

### Use as primary authentication
 
Remove any existing authentication routes, such as those added by Auth::routes(). Then in `config/auth.php`, set the default guard to `socialite`
```php
'defaults' => [
    'guard' => 'socialite',
    ...
],
```

### Mixed authentication

1. This package includes its own Authenticate middleware which can be applied to perform
   the correct redirect in a mixed authentication environment. First add it to your route
   middleware in `app/Http/Kernel.php`.
   ```php
   protected $routeMiddleware = [
       ...
       'socialite' => \STS\SocialiteAuth\Authenticate::class,
       ...
   ];
   ``` 

2. Further down, add it above the default Authenticate middleware in the
   priority array to ensure it takes priority over the default when applied.
   ```php
   protected $middlewarePriority = [
       ...
       \STS\SocialiteAuth\Authenticate::class,
       \App\Http\Middleware\Authenticate::class,
       ...
   ];
   ```

Now you may freely specify Socialite authentication on some routes...
```php
Route::get(...)->middleware(['auth:socialite', 'socialite']);
```
...and in-app authentication on others.
```php
Route::get(...)->middleware('auth');
```
 
### Laravel Nova authentication

Finally, it's quick to set up socialite authentication with Laravel Nova.

1. In the NovaServiceProvider added within your Providers directory, disable the
   authentication related routes which are generated by default.
   ```php
   protected function routes()
   {
       Nova::routes();
           // ->withAuthenticationRoutes()
           // ->withPasswordResetRoutes()
           // ->register();
   }
   ```
2. If Socialite is configured as your default guard as above, you're all set.
   Otherwise add a `NOVA_GUARD` value to your .env file indicating that `socialite` 
   is your desired guard.
   ```
   NOVA_GUARD=socialite
   ```