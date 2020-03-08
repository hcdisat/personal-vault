<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    protected array $userData = [
        'first_name' => 'Hector',
        'last_name' => 'Caraballo',
        'username' => 'hcdisat',
        'email' => 'hcdisat@gmail.com',
        'password' => 'Secret..66!',
        'password_confirmation' => 'Secret..66!'
    ];

    /**
     * @test
     */
    public function should_register_a_new_user(): void
    {
        $response = $this->postJson(
            self::REGISTER_URI, $this->userData);

        $this->assertAuthSuccess($response);
    }

    /**
    * @test
    */
    public function should_login_a_user(): void
    {
        $response = $this->loginUser();
        $this->assertAuthSuccess($response);
    }

    /**
    * @test
    */
    public function it_should_not_login_a_user(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'username' => 'john',
            'password' => 'Secret66!'
        ]);

        $response->assertUnauthorized();
    }

    /**
    * @test
    */
    public function should_refresh_the_token(): void
    {
        $loginResponse = $this->loginUser();
        $this->assertAuthSuccess($loginResponse);

        $token = $loginResponse->getOriginalContent()['data'];
        $response = $this->postJson(self::REFRESH_TOKEN, [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $this->assertAuthSuccess($response);
    }

    /**
     * @param TestResponse $response
     */
    protected function assertAuthSuccess(TestResponse $response): void
    {
        $response->assertOk();
        $response->assertSeeText('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9');
    }

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
