<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Contracts\Auth\Authenticatable;

interface SocialiteAuthenticatable extends Authenticatable
{
    /**
     * Get the name of the column to be matched for Socialite authentication.
     *
     * @return string
     */
    public function getSocialiteCredentialField();
}
