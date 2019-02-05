<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $fillable = [
        'name', 'contact1', 'contact2'
    ];

    public function projects() {
        return $this->hasMany('\App\Project');
    }
}
