<?php

namespace Stechstudio\LaravelSocialiteAuth;

interface SocialiteAuthenticatable
{
    /**
     * Get the name of the column to be matched for Socialite authentication.
     *
     * @return string
     */
    public function getSocialiteUsername();
}
