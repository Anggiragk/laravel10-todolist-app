<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{

    public function testGuestAccessHome()
    {
        $response = $this->get('/')
        ->assertRedirect('/login');
    }

    public function testMemberAccessHome()
    {
        $response = $this->withSession(['username'=>'foo'])->get('/')
        ->assertRedirect('/todolist');
    }
}
