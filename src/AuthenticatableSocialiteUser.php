<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Auth\Authenticatable;

class AuthenticatableSocialiteUser implements SocialiteUser, SocialiteAuthenticatable
{
    /**
     * @var SocialiteUser $socialiteUser
     */
    private $socialiteUser;

    /**
     * @var string $socialiteCredentialField
     */
    private $socialiteCredentialField;

    use Authenticatable;

    function __construct(SocialiteUser $user, $socialiteCredentialField)
    {
        $this->socialiteUser = $user;
        $this->socialiteCredentialField = $socialiteCredentialField;
    }

    /*-------------------------------------------------------------------------
    * SocialiteUser
    *------------------------------------------------------------------------*/

    public function getId() { return $this->socialiteUser->getId(); }
    public function getNickname() { return $this->socialiteUser->getNickname(); }
    public function getName() { return $this->socialiteUser->getName(); }
    public function getEmail() { return $this->socialiteUser->getEmail(); }
    public function getAvatar() { return $this->socialiteUser->getAvatar(); }


    /*-------------------------------------------------------------------------
    * Authenticatable
    *------------------------------------------------------------------------*/

    public function getAuthIdentifierName()
    {
        return $this->getSocialiteCredentialField();
    }

    public function getRememberTokenName()
    {
        return '';
    }

    /*-------------------------------------------------------------------------
    * SocialiteAuthenticatable
    *------------------------------------------------------------------------*/

    public function  getSocialiteCredentialField()
    {
        return $this->socialiteCredentialField;
    }

    /*-------------------------------------------------------------------------
    * Convenience
    *------------------------------------------------------------------------*/


    public function getSocialiteCredential()
    {
        return $this->socialiteUser[$this->getSocialiteCredentialField()];
    }
}
