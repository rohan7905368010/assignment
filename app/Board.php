<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function tasks() 
    {
        return $this->hasMany('App\Task');
    }
}
