<?php
namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService{
    public function saveTodo(string $id, string $todo):void{
        $todolist = new Todo();
        $todolist->id= $id;
        $todolist->todo= $todo;
        $todolist->save();
    }

    public function getTodo():array{
        $todolist = Todo::all()->toArray();
        return $todolist;
    }

    public function removeTodo(string $id){
        $todolist = Todo::query()->find($id);
        $todolist->delete();
    }

}
