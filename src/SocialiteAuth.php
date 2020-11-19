<?php

namespace STS\SocialiteAuth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User;

class SocialiteAuth
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Closure
     */
    protected $verifyUser = null;

    /**
     * @var \Closure
     */
    protected $handleNewUser = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Provide custom logic for verifying a user before login.
     *
     * @param \Closure
     */
    public function beforeLogin(Closure $beforeLogin)
    {
        $this->verifyUser = $beforeLogin;
    }

    /**
     * Provide custom handler for setting up a new user.
     *
     * @param Closure $handleNewUser
     */
    public function newUser(Closure $handleNewUser)
    {
        $this->handleNewUser = $handleNewUser;
    }

    /**
     * Verify that the user meets login requirements
     * according to the custom logic provided.
     *
     * @param Authenticatable
     *
     * @return bool
     */
    public function verifyBeforeLogin(Authenticatable $user): bool
    {
        return $this->verifyUser
            ? call_user_func($this->verifyUser, $user)
            : true;
    }

    /**
     * @param $user
     *
     * @return bool|Authenticatable
     */
    public function handleNewUser(User $user)
    {
        if ($this->handleNewUser) {
            return call_user_func($this->handleNewUser, $user);
        }

        if ($this->config['match'] == false) {
            $user = new Identity($user);
            session()->put($this->sessionKeyFor($user->getAuthIdentifier()), $user);

            return $user;
        }
    }

    public function sessionKeyFor($identifier)
    {
        return 'socialite-auth.' . str_replace('.','-',$identifier);
    }
}
