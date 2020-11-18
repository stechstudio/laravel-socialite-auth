<?php

namespace STS\SocialiteAuth\Tests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Two\User as SocialiteUser;

class FieldConfigTest extends BaseTest
{
    private $existingSocialiteUser = null;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('socialite-auth.field', 'name');

        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
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

        User::setSocialiteIdentifierName('name');
    }

    /** @test */
    public function model_socialite_field_is_configurable()
    {
        $this->assertSame('name', User::first()->getSocialiteIdentifierName());
    }

    public function authentication_with_configured_fields_succeeds()
    {
        $this->assertTrue(
            Auth::guard('socialite')->attemptFromSocialite($this->existingSocialiteUser, config('socialite-auth.field'))
        );
    }
}
