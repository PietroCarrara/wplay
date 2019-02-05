<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name', 'contact1', 'contact2'
    ];

    public function projects() {
        return $this->hasMany('\App\Project');
    }
}
