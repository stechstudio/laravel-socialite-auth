<?php

namespace STS\SocialiteAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User;

class Identity implements Authenticatable
{
    public $socialite;

    public $name;
    public $email;
    public $avatar;

    public function __construct(User $user)
    {
        $this->socialite = $user;
        $this->name = $user->getName();
        $this->email = $user->getEmail();
        $this->avatar = $user->getAvatar();
    }

    public function getAuthIdentifier()
    {
        return $this->email;
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthPassword()
    {
    }

    public function getRememberToken()
    {
    }

    public function getRememberTokenName()
    {
    }

    public function setRememberToken($value)
    {
    }
}
