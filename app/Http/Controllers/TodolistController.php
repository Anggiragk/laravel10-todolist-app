<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService) {
        $this->todolistService = $todolistService;
    }

    public function todolist(Request $request){
        return response()->view('todolist.todolist', [
            'title' => 'Todolist Page',
            'todolist' => $this->todolistService->getTodo()
        ]);
    }

    public function addTodo(Request $request){
        $todo = $request->input('todo');

        if(!$todo){
            return response()->view('todolist.todolist',[
                'title' => 'Todolist',
                'todolist' => $this->todolistService->getTodo(),
                'error' => "todo is required"
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todolist']);
    }

    public function removeTodo(string $id, Request $request){
        $this->todolistService->removeTodo($id);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
