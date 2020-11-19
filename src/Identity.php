<?php

namespace STS\SocialiteAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Laravel\Socialite\Contracts\User;

class Identity implements Authenticatable, Arrayable
{
    public $name;
    public $email;
    public $avatar;

    public static function fromSocialite(User $user)
    {
        $instance = new static;

        $instance->name = $user->getName();
        $instance->email = $user->getEmail();
        $instance->avatar = $user->getAvatar();

        return $instance;
    }

    public static function restore(array $details)
    {
        $instance = new static;

        $instance->name = $details['name'];
        $instance->email = $details['email'];
        $instance->avatar = $details['avatar'];

        return $instance;
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

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar
        ];
    }
}
