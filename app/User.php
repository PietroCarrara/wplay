<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Relations\ObservableBelongsToMany;

class User extends Authenticatable
{
    use SoftDeletes;

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

    public function projects() {
        $rel = new ObservableBelongsToMany(
            Project::query(),
            $this,
            'project_user',
            'user_id',
            'project_id',
            'id',
            'id',
            'ProjectUser'
        );
        $rel->using('App\ProjectUser');

        return $rel;
    }
}
