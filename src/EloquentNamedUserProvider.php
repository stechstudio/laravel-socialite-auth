<?php

namespace Stechstudio\LaravelSocialiteAuth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\AuthenticationException;

class EloquentNamedUserProvider extends EloquentUserProvider implements NamedUserProvider
{
    /**
     * Retrieve a user by the given username.
     *
     * @param  string  $username
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws \Illuminate\Auth\AuthenticationException if the provided username is not unique.
     */
    public function retrieveByUsername($username)
    {
        if (!$username) {
            return null;
        }

        $model = $this->createModel();
        $results = $model->newQuery()->where(getSocialiteUsername(), $username)->get();

        if ($results.count > 1) {
            throw new AuthenticationException("Username specified is not unique");
        } else {
            return $results->first();
        }
    }
}