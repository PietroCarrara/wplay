<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $fillable = [
       'comment_id', 'project_id', 'task_id', 'message'
    ];

    public function users() {
        return $this->belongsToMany('App\User');
    }
    
    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function comment() {
        return $this->belongsTo('App\Comment');
    }

    public function render() {
        $msg = htmlspecialchars($this->message);
        
        if ($this->project) {
            $msg = str_replace(':project:', view('components.project-link', [
                'project' => $this->project
            ]), $msg);
        }

        if ($this->task()->withTrashed()->count() > 0) {
            $msg = str_replace(':task:', view('components.task-link', [ 
                'task' => $this->task()->withTrashed()->get()->first()
            ]), $msg);
        }

        if ($this->comment) {
            $msg = str_replace(':comment:', htmlspecialchars($this->comment->contents), $msg);
        }

        if ($this->users) {
            $names = [];
            foreach($this->users as $user) {
                $names[] = htmlspecialchars($user->name);
            }
            $names = join(', ', $names);

            $msg = str_replace(':users:', $names, $msg);
        }
        
        return $msg;
    }
}
