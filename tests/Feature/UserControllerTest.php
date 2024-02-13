<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/login', [
            "username" => 'foo',
            'password' => 'foo'
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHas('username', 'foo');
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
