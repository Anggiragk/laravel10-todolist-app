<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from users');
    }

    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', [
            "username" => 'alphatest@gmail.com',
            'password' => 'password123'
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHas('username', 'alphatest@gmail.com');
    }

    public function testMemberToLoginPage(){
        $this->withSession(['username'=>'foo'])
        ->get('/login')
        ->assertRedirect('/');
    }

    public function testLoginFailed()
    {
        $response = $this->post('/login', [
            "username" => 'fo',
            'password' => 'fo'
        ]);
        $response->assertSeeText('failed login');
    }

    public function testGuestTryLogout() {
        $response = $this->post('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testLogoutSuccess()
    {
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $response->assertSessionMissing('username');
    }

}
