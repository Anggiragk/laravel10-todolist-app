<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from users');
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $login = $this->userService->login("alphatest@gmail.com", "password123");
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
