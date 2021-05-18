<?php

namespace STS\SocialiteAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User;
use STS\SocialiteAuth\Contracts\SocialiteAuthenticatable;
use STS\SocialiteAuth\Facades\SocialiteAuth;

class GuardHelpers
{
    protected function attemptFromSocialite()
    {
        return function(User $user, $socialiteField) {

            $modelSocialiteField = $this->resolveSocialiteIdentifierName();

            // First try to find a match
            $userModel = $this->provider->retrieveByCredentials([
                $modelSocialiteField => $user[$socialiteField]
            ]);

            // No match? See if we have a custom handler for new users
            if(!$userModel) {
                $userModel = SocialiteAuth::handleNewUser($user);
            }

            if ($userModel && SocialiteAuth::verifyBeforeLogin($userModel)) {
                $this->login($userModel);
                return true;
            }

            return false;
        };
    }

    protected function resolveSocialiteIdentifierName()
    {
        return function() {
            $modelField = 'email';
            if (method_exists($this->provider, 'createModel')) {
                $new = $this->provider->createModel();
                if ($new instanceof SocialiteAuthenticatable) {
                    $modelField = $new->getSocialiteIdentifierName();
                }
            }

            return $modelField;
        };
    }
}
