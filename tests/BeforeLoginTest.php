<?php

namespace STS\SocialiteAuth\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Support\Facades\Auth;
use STS\SocialiteAuth\Facades\SocialiteAuth;

class BeforeLoginTest extends BaseTest
{
    private $existingSocialiteUser = null;
    private $missingSocialiteUser = null;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'user1@example.com',
            'password' => Hash::make('Password*1'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->existingSocialiteUser = (new SocialiteUser)->setRaw([
            'id' => '456',
            'nickname' => '',
            'name' => 'User1',
            'email' => 'user1@example.com',
            'avatar' => '',
            'avatar_original' => ''
        ]);

        $this->missingSocialiteUser = (new SocialiteUser)->setRaw([
            'id' => '789',
            'nickname' => '',
            'name' => 'User2',
            'email' => 'user2@example.com',
            'avatar' => '',
            'avatar_original' => ''
        ]);
    }


    /** @test */
    public function existing_user_no_closure_login_succeeds()
    {
        $this->assertTrue(
            Auth::guard('socialite')->attemptFromSocialite($this->existingSocialiteUser, config('socialite-auth.field'))
        );
    }

    /** @test */
    public function missing_user_no_closure_login_fails()
    {
        $this->assertFalse(
            Auth::guard('socialite')->attemptFromSocialite($this->missingSocialiteUser, config('socialite-auth.field'))
        );
    }

    /** @test */
    public function existing_user_failed_closure_login_fails()
    {
        SocialiteAuth::beforeLogin(function($existingSocialiteUser) {
           return false;
        });

        $this->assertFalse(
            Auth::guard('socialite')->attemptFromSocialite($this->existingSocialiteUser, config('socialite-auth.field'))
        );
    }

    /** @test */
    public function missing_user_failed_closure_login_fails()
    {
        SocialiteAuth::beforeLogin(function($missingSocialiteUser) {
            return false;
        });

        $this->assertFalse(
            Auth::guard('socialite')->attemptFromSocialite($this->existingSocialiteUser, config('socialite-auth.field'))
        );
    }

    /** @test */
    public function existing_user_passed_closure_login_succeeds()
    {
        SocialiteAuth::beforeLogin(function($existingSocialiteUser) {
            return true;
        });

        $this->assertTrue(
            Auth::guard('socialite')->attemptFromSocialite($this->existingSocialiteUser, config('socialite-auth.field'))
        );
    }

    /** @test */
    public function missing_user_passed_closure_login_fails()
    {
        SocialiteAuth::beforeLogin(function($missingSocialiteUser) {
            return true;
        });

        $this->assertFalse(
            Auth::guard('socialite')->attemptFromSocialite($this->missingSocialiteUser, config('socialite-auth.field'))
        );
    }
}
