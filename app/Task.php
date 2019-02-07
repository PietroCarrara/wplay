<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Relations\ObservableBelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name', 'description', 'project_id'
    ];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function users() {
        $rel = new ObservableBelongsToMany(
            \App\User::query(),
            $this,
            'task_user',
            'task_id',
            'user_id',
            'id',
            'id',
            'TaskUser'
        );

        $rel->using('App\TaskUser');

        return $rel;
    }
}
