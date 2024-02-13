<?php

namespace Tests\Feature;

use App\Models\Todo;
use Tests\TestCase;
use App\Services\TodolistService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\assertEquals;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert;

class TodolistServiceTest extends TestCase
{

    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from todos');
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function test_todolistService_not_null()
    {
        self::assertNotNull($this->todolistService);
    }

    public function test_save_todolist_success(){
        $this->todolistService->saveTodo("1", "walking");

        $todolist = Todo::query()->find(1)->first();

        self::assertEquals($todolist->id, "1");
        self::assertEquals($todolist->todo, "walking");
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

        Assert::assertArraySubset($expected, $this->todolistService->getTodo());
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
