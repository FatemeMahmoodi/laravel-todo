<?php

namespace FatemeMahmoodi\LaravelToDo\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['title'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
