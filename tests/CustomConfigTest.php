<?php

namespace STS\SocialiteAuth\Tests;

use Orchestra\Testbench\TestCase;
use STS\SocialiteAuth\SocialiteAuthServiceProvider;

class CustomConfigTest extends TestCase
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

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.guards.socialite', [
            'driver' => 'fooDriver',
            'provider' => 'barProvider'
        ]);
    }

    /** @test */
    public function auth_config_not_overwritten()
    {
        $this->assertSame('fooDriver', config('auth.guards.socialite.driver'));
        $this->assertSame('barProvider', config('auth.guards.socialite.provider'));
    }
}
