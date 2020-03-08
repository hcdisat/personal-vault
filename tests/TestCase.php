<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected const ROOT_URI = '/api/v1';
    protected const BASE_URI = self::ROOT_URI . '/auth';
    protected const REGISTER_URI = self::BASE_URI . '/register';
    protected const LOGIN_URI = self::BASE_URI . '/login';
    protected const LOGOUT_URI = self::BASE_URI . '/logout';
    protected const REFRESH_TOKEN = self::BASE_URI . '/refresh';

    /**
     * @return TestResponse
     */
    protected function loginUser(): TestResponse
    {
        $user = factory(User::class)->create();
        return $this->postJson(self::LOGIN_URI, [
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'Secret66!'
        ]);
    }
}
