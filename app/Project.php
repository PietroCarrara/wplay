<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Relations\ObservableBelongsToMany;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'client_id'
    ];

    public function users() {
        $rel = new ObservableBelongsToMany(
            \App\User::query(),
            $this,
            'project_user',
            'project_id',
            'user_id',
            'id',
            'id',
            'ProjectUser'
        );

        $rel->using('App\ProjectUser');

        return $rel;
    }
}
