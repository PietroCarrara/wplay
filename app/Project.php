<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function users() {
        return $this->belongsToMany('\App\User');
    }
}
