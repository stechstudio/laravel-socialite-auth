<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\UserProvider;

interface NamedUserProvider extends UserProvider
{
    /**
     * Retrieve a user by the given username.
     *
     * @param  string  $username
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws \Illuminate\Auth\AuthenticationException if the provided username is not unique.
     */
    public function retrieveByUsername($username);
}