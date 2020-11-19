<?php

namespace STS\SocialiteAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use STS\SocialiteAuth\Facades\SocialiteAuth;

class NullUserProvider implements UserProvider
{
    public function __construct()
    {
    }

    public function retrieveById($identifier)
    {
        return session()->get(SocialiteAuth::sessionKeyFor($identifier));
    }

    public function retrieveByToken($identifier, $token)
    {
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    public function retrieveByCredentials(array $credentials)
    {
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return false;
    }
}
