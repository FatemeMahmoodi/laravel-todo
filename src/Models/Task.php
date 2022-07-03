<?php

namespace FatemeMahmoodi\LaravelToDo\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $fillable = ['title', 'description' ,'status','user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCreator($query , $user)
    {
        return $query->where("user_id", $user->id);
    }


}
