<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stechstudio\LaravelSocialiteAuth\Skeleton\SkeletonClass
 */
class LaravelSocialiteAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-socialite-auth';
    }
}
