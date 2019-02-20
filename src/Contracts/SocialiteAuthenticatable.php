<?php

namespace STS\SocialiteAuth\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface SocialiteAuthenticatable extends Authenticatable
{
    /**
     * Get the name of the column to be matched for Socialite authentication.
     *
     * @return string
     */
    public function getSocialiteIdentifierName();

    /**
     * Get the value of the column to be matched for Socialite authentication.
     *
     * @return string
     */
    public function getSocialiteIdentifier();
}
