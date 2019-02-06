<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $fillable = [
        'user_id', 'project_id', 'task_id', 'message'
    ];
}
