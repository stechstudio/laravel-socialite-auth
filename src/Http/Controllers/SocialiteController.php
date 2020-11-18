<?php

namespace STS\SocialiteAuth\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController
{
    /**
     * Redirect the user to the OAuth Provider.
     */
    public function redirectToProvider()
    {
        return Socialite::driver(config('socialite-auth.driver'))->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver(config('socialite-auth.driver'))->user();

        if (Auth::guard('socialite')->attemptFromSocialite($user, config('socialite-auth.field'))) {
            return redirect()->intended();
        }

        abort(401);
    }
}
