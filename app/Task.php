<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, ObservableRelationModel;

    public $fillable = [
        'name', 'description', 'project_id'
    ];

    public $dates = [
        'deleted_at',
    ];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function users() {
        return $this->observableBelongsToMany('App\User', 'task_user')->using('App\TaskUser');
    }

    public function votes() {
        return $this->observableBelongsToMany('App\User', 'task_user_vote')->using('App\TaskUserVote');
    }
}
