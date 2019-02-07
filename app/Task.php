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

    public function votes() {
        $rel = new ObservableBelongsToMany(
            \App\User::query(),
            $this,
            'task_user_vote',
            'task_id',
            'user_id',
            'id',
            'id',
            'votes'
        );

        $rel->using('App\TaskUserVote');

        return $rel;
    }
}
