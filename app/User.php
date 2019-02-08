<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes, ObservableRelationModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role'
    ];

    public function tasks() {
        return $this->observableBelongsToMany('App\Task', 'task_user')->using('App\TaskUser');
    }

    public function projects() {
        return $this->observableBelongsToMany('App\Project')->using('App\ProjectUser');
    }

    public function votes() {
        return $this->observableBelongsToMany('App\Task', 'task_user_vote')->using('App\TaskUserVote');
    }

    public function controls() {
        return $this->hasMany('App\UserControl');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function logs() {
        return $this->belongsToMany('App\Log');
    }
}
