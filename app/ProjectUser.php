<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    public $fillable = [
        'user_id', 'project_id',
    ];

    public function create()
    {
        event('eloquent.creating: ' . __CLASS__, $this);

        parent::create();

        event('eloquent.created: ' . __CLASS__, $this);
    }

    public function delete()
    {
        event('eloquent.deleting: ' . __CLASS__, $this);

        parent::delete();

        event('eloquent.deleted: ' . __CLASS__, $this);
    }
}
