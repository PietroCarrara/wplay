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
        $proj = Project::find($projId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed project does not exist.');
        }

        $task = $proj->tasks()->where('id', $taskId)->first();

        if (!$task) {
            return redirect()->back()->withErrors('The informed task does not exist.');
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
        $proj = Project::find($projId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed project does not exist.');
        }

        $task = $proj->tasks()->where('id', $taskId)->first();

        if (!$task) {
            return redirect()->back()->withErrors('The informed task does not exist.');
        }

        if ($task->users->contains(Auth::user())) {
            $task->users()->detach(Auth::user());
        }

        return redirect(route('project', [
            $proj->id,
        ]));
    }

    public function createPost(Request $req, $projectId) {

        $proj = Project::find($projectId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed project does not exist.');
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
            'project_id' => $projectId,
        ]);

        return redirect(route('project.task', [$projectId, $task->id]));
    }

    public function show($projId, $taskId) {
        $proj = Project::find($projId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed project does not exist.');
        }

        $task = $proj->tasks()->where('id', $taskId)->first();

        if (!$task) {
            return redirect()->back()->withErrors('The informed task does not exist.');
        }

        return view('task', [
            'task' => $task,
        ]);
    }

    public function commentPost(Request $req, $projId, $taskId) {
        $proj = Project::find($projId);

        if (!$proj) {
            return redirect()->back()->withErrors('The informed project does not exist.');
        }

        $task = $proj->tasks()->where('id', $taskId)->first();

        if (!$task) {
            return redirect()->back()->withErrors('The informed task does not exist.');
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
}
