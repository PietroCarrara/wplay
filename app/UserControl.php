<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserControl extends Model
{
    protected $fillable = [
        'ip', 'type', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
