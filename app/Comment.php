<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
        'contents', 'user_id', 'task_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function task() {
        return $this->belongsTo('App\Task');
    }
}
