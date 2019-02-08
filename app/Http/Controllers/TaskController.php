<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Auth;
use App\Project;
use App\Task;
use App\Comment;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function joinTask($projId, $taskId) {
        [$proj, $task] = $this->validateIds($projId, $taskId);

        if ($proj == null || $task == null) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        if ($proj->users->contains(Auth::user()) && !$task->users->contains(Auth::user())) {
            $task->users()->save(Auth::user());
        }

        return redirect(route('project.task', [
            $proj->id,
            $task->id,
        ]));
    }

    public function quitTask($projId, $taskId) {
        [$proj, $task] = $this->validateIds($projId, $taskId);

        if ($proj == null || $task == null) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        if ($task->users->contains(Auth::user())) {
            $task->users()->detach(Auth::user());
        }

        return redirect(route('project', [
            $proj->id,
        ]));
    }

    public function createPost(Request $req, $projId) {

        [$proj] = $this->validateIds($projId);

        if ($proj == null) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        if (Gate::denies('manage-tasks', $proj)) {
            return redirect()->back()->withErrors('You can\'t create tasks in this project.');
        }

        $req->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        
        $task = Task::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'project_id' => $projId,
        ]);

        if ($proj->users->contains(Auth::user())) {
            $task->users()->save(Auth::user());
        }

        return redirect(route('project.task', [$projId, $task->id]));
    }

    public function show($projId, $taskId) {
        $proj = Project::withTrashed()->find($projId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        $task = $proj->tasks()->withTrashed()->where('id', $taskId)->first();

        if (!$task) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        return view('task', [
            'task' => $task,
            'project' => $task->project()->withTrashed()->get()->first(),
        ]);
    }

    public function toggleVoteTask(Request $req, $projId, $taskId) {
        [$proj, $task] = $this->validateIds($projId, $taskId);

        if ($task == null || $proj == null) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        if (!$task->users->contains(Auth::user())) {
            return redirect()->back()->withErrors('You cant\'t complete tasks you do not work in.');
        }

        if ($task->trashed()) {
            return redirect()->back()->withErrors('Task is already completed');
        }

        if ($task->votes->contains(Auth::user())) {
            $task->votes()->detach(Auth::user());
        } else {
            $task->votes()->save(Auth::user());
        }
        
        return redirect(route('project.task', [
            $proj->id,
            $task->id,
        ]));
    }

    public function commentPost(Request $req, $projId, $taskId) {

        [$proj, $task] = $this->validateIds($projId, $taskId);

        if ($task == null || $proj == null) {
            return redirect()->back()->withErrors('The informed data is not valid.');
        }

        if (Gate::denies('comment-task', $task)) {
            return redirect()->back()->withErrors('You can\'t comment on this task');
        }

        $req->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'task_id' => $task->id,
            'contents' => $req->input('comment')
        ]);

        return view('components.comment', [
            'comment' => $comment,
        ]);
    }

    private function validateIds($projId = null, $taskId = null) {
        $proj = null;
        $task = null;

        if ($projId) {
            $proj = Project::find($projId);
        }

        if ($proj && $taskId) {
            $task = $proj->tasks()->where('id', $taskId)->first();
        }

        return [$proj, $task];
    }
}
