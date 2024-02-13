<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodolistServiceTest extends TestCase
{

    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function test_todolistService_not_null()
    {
        self::assertNotNull($this->todolistService);
    }

    public function test_save_todolist_success(){
        $this->todolistService->saveTodo("1", "walking");

        $todolist = Session::get('todolist');

        foreach ($todolist as $value) {
            self::assertEquals($value['id'], "1");
            self::assertEquals($value['todo'], "walking");
        }
    }

    public function test_save_todolist_without_data(){
        $this->todolistService->saveTodo("1", "walking");

        $todolist = Session::get('todolist');

        self::assertNotNull($todolist);
    }

    public function test_get_empty_todolist(){
        assertEquals([], $this->todolistService->getTodo());
    }

    public function test_get_todolist_with_data(){
        $expected = [
            [
                'id'=>'1',
                'todo'=>'walking',
            ],
            [
                'id'=>'2',
                'todo'=>'speaking',
            ],
        ];
        $this->todolistService->saveTodo("1", "walking");
        $this->todolistService->saveTodo("2", "speaking");

        self::assertEquals($expected, $this->todolistService->getTodo());
    }

    public function test_remove_todolist(){
        $this->todolistService->saveTodo("1", "walking");
        $this->todolistService->saveTodo("2", "speaking");
        $this->todolistService->saveTodo("3", "testing");
        $this->todolistService->removeTodo("1");

        self::assertEquals(2, sizeof($this->todolistService->getTodo()));
        $this->todolistService->removeTodo("2");
        self::assertEquals(1, sizeof($this->todolistService->getTodo()));

    }
}
