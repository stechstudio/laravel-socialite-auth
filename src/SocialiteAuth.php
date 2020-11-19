<?php

namespace STS\SocialiteAuth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuth
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Closure
     */
    protected $prepareDriver = null;

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

    public function getDriver()
    {
        $driver = Socialite::driver($this->config['driver']);

        if($this->prepareDriver) {
            call_user_func($this->prepareDriver, $driver);
        }

        return $driver;
    }

    public function prepareDriver(Closure $prepareDriver)
    {
        $this->prepareDriver = $prepareDriver;
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
            $user = Identity::fromSocialite($user);
            session()->put($this->sessionKeyFor($user->getAuthIdentifier()), $user->toArray());

            return $user;
        }
    }

    public function sessionKeyFor($identifier)
    {
        return 'socialite-auth.' . str_replace('.','-',$identifier);
    }
}
