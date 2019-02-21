<?php

namespace STS\SocialiteAuth\Tests;

class DefaultConfigTest extends BaseTest
{
    /** @test */
    public function auth_config_has_socialite_guard()
    {
        $this->assertArrayHasKey('socialite', config('auth.guards'));
        $this->assertSame('socialite', config('auth.guards.socialite.driver'));
        $this->assertSame('users', config('auth.guards.socialite.provider'));
    }
}
