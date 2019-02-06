<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Project;
use App\Task;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
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
}
