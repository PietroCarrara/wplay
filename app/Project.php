<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, ObservableRelationModel;

    protected $fillable = [
        'name', 'description', 'client_id'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function tasks() {
        return $this->hasMany('App\Task');
    }

    public function logs() {
        return $this->hasMany('App\Log');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function users() {
        return $this->observableBelongsToMany('App\user')->using('App\ProjectUser');
    }
}
