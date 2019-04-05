<?php

namespace STS\SocialiteAuth;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;

class SocialiteAuth
{
    /**
     * @var \Closure
     */
    private $verifyUser = null;

    /**
     * @var \Closure
     */
    private $handleNewUser = null;

    /**
     * Provide custom logic for verifying a user before login.
     *
     * @param \Closure
     */
    public function beforeLogin( Closure $beforeLogin )
    {
        $this->verifyUser = $beforeLogin;
    }

    /**
     * Provide custom handler for setting up a new user.
     *
     * @param Closure $handleNewUser
     */
    public function newUser( Closure $handleNewUser )
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
    public function verifyBeforeLogin( Authenticatable $user ): bool
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
    public function handleNewUser( $user )
    {
        return $this->handleNewUser
            ? call_user_func($this->handleNewUser, $user)
            : null;
    }
}
