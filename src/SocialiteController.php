<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Socialite\Facades\Socialite;

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
     **_ Redirect the user to the OAuth Provider.
     * _**
     **_ @return \Illuminate\Http\Response
     * _**/
    public function redirectToProvider()
    {
        return Socialite::driver(config('socialite-auth.driver'))->redirect();
    }

    /**
     * _ Obtain the user information from provider.  Check if the user already exists in our
     * _ database by looking up their provider_id in the database.
     * _ If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * _ redirect them to the authenticated users homepage.
     * _
     * _ @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver(config('socialite-auth.driver'))->user();

        if (Auth::guard('socialite')->attemptWithSocialite($user)) {
            return redirect()->intended();
        }

        abort(401);
    }
}