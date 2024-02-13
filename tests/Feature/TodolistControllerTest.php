<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\TodolistService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodolistControllerTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from todos');

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolist()
    {
        $this->todolistService->saveTodo("1", "walking");
        $this->withSession([
            'username'=>'foo'
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
        $this->todolistService->saveTodo("1", "walking");
        $this->todolistService->saveTodo("2", "speaking");
        $this->withSession([
            'username' => 'foo'
        ])
        ->post('/todolist/1/delete')
        ->assertRedirect('/todolist');
    }
}
