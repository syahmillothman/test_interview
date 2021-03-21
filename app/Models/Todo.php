<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{

    protected $table = 'todo_list';

    protected $fillable = [
        'body',
        'is_complete',
        'users_id'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    /**
     * @param Builder  $query
     * @param $users
     */
    public function scopeByUsers(Builder $query, $users = [])
    {
        return $query->whereIn('users_id', $users);
    }
}