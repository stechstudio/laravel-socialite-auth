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
     * Provide Custom logic for verifying a user before login.
     *
     * @param \Closure
     */
    public function beforeLogin(Closure $beforeLogin) {
        $this->verifyUser = $beforeLogin;
    }

    /**
     * Verify that the user meets login requirements
     * according to the custom logic provided.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable
     * @return bool
     */
    public function verifyBeforeLogin(Authenticatable $user): bool
    {
        if (is_null($this->verifyUser)) { return true; }
        return call_user_func($this->verifyUser, $user);
    }
}
