<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolist()
    {
        $this->withSession([
            'username'=>'foo',
            'todolist' => [
                [
                    'id' => "1",
                    'todo' => 'walking'
                ],
                [
                    'id' => "2",
                    'todo' => 'speaking'
                ],
            ]
        ])->get('/todolist')
        ->assertSeeText("walking");
    }

    public function testAddtodoSuccess(){
        $response = $this->withSession([
            'username' => 'foo'
        ])->post('/todolist', [
            'todo' => 'testing'
        ]);

        $response->assertRedirect('/todolist');
    }

    public function testAddtodoFailed(){
        $response = $this->withSession([
            'username' => 'foo'
        ])->post('/todolist',[]);

        $response->assertSeeText('todo is required');
    }

    public function testRemoveTodoListSuccess(){
        $this->withSession([
            'username' => 'foo',
            'todolist' => [
                [
                    'id' => "1",
                    'todo' => 'testing 1'
                ],
                [
                    'id' => "2",
                    'todo' => 'testing 2'
                ],
            ]
        ])
        ->post('/todolist/1/delete')
        ->assertRedirect('/todolist');
    }
}
