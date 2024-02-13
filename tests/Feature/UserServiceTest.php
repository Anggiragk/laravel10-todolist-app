<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $login = $this->userService->login("foo", "foo");
        self::assertTrue($login);
    }

    public function testLoginFailed()
    {
        $loginWithoutUsername = $this->userService->login("", "password123");
        $loginWithoutPassword = $this->userService->login("foo", "");
        self::assertFalse($loginWithoutUsername);
        self::assertFalse($loginWithoutPassword);
    }
}
