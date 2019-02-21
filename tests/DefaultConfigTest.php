<?php

namespace STS\SocialiteAuth\Tests;

use Orchestra\Testbench\TestCase;
use STS\SocialiteAuth\SocialiteAuthServiceProvider;

class DefaultConfigTest extends TestCase
{
    protected function getPackageAliases($app)
    {
        return [
            'SocialiteAuth' => \STS\SocialiteAuth\Facades\SocialiteAuth::class
        ];
    }

    protected function getPackageProviders($app)
    {
        return [SocialiteAuthServiceProvider::class];
    }

    /** @test */
    public function auth_config_has_socialite_guard()
    {
        $this->assertArrayHasKey('socialite', config('auth.guards'));
        $this->assertSame('socialite', config('auth.guards.socialite.driver'));
        $this->assertSame('users', config('auth.guards.socialite.provider'));
    }
}
