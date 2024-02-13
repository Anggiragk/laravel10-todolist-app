<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Todo::create([
            'id'=> '1',
            'todo' => 'walking'
        ]);

        Todo::create([
            'id'=> '2',
            'todo' => 'speaking'
        ]);
    }
}
