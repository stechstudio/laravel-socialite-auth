<?php

namespace STS\SocialiteAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void beforeLogin(\Closure $beforeLogin)
 * @method static bool verifyBeforeLogin(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @see \STS\SocialiteAuth\SocialiteAuth
 */
class SocialiteAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'socialite-auth';
    }
}
