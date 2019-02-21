<?php

namespace STS\SocialiteAuth\Tests;

use Orchestra\Testbench\TestCase;
use STS\SocialiteAuth\Facades\SocialiteAuth;
use STS\SocialiteAuth\SocialiteAuthServiceProvider;

abstract class BaseTest extends TestCase
{
    protected function getPackageAliases($app)
    {
        return ['SocialiteAuth' => SocialiteAuth::class];
    }

    protected function getPackageProviders($app)
    {
        return [SocialiteAuthServiceProvider::class];
    }
}
