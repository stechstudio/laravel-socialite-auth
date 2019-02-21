<?php

namespace STS\SocialiteAuth\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use STS\SocialiteAuth\Contracts\SocialiteAuthenticatable;

class User extends Authenticatable implements SocialiteAuthenticatable
{
    private static $socialiteFieldName = 'email';

    /*-------------------------------------------------------------------------
    * Attributes
    *------------------------------------------------------------------------*/

    public function getSocialiteIdentifierName()
    {
        return self::$socialiteFieldName;
    }

    public static function setSocialiteIdentifierName($name)
    {
        self::$socialiteFieldName = $name;
    }

    public function getSocialiteIdentifier() {
        return $this->{self::$socialiteFieldName};
    }

    protected $guarded = [];
}
