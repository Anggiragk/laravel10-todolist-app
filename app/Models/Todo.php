<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{

    protected $table;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id','todo'
    ];

}
