<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Socialite\Facades\Socialite;
use Stechstudio\LaravelSocialiteAuth\AuthenticatableSocialiteUser;

class SocialiteController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/proposals';

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver(config('socialite-auth.driver'))->user();
        $user = new AuthenticatableSocialiteUser($user, config('socialite-auth.column'));
        if (Auth::guard('socialite')->attemptFromSocialite($user)) {
            return redirect()->intended();
        }

        abort(401);
    }
}