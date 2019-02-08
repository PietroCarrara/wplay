<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Project;
use Gate;

class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show($id) {
        return view('project', [
            'project' => Project::withTrashed()->find($id),
        ]);
    }

    public function create() {
        if (Gate::allows('manage-projects')) {
            return view('create-project');
        } else {
            return redirect(route('home'));
        }
    }

    public function createPost(Request $req) {

        if (Gate::denies('manage-projects')) {
            return response('Unauthorized.', 403);
        }

        $req->validate([
            'name' => 'required',
            'description' => 'required',
            'client' => 'required|exists:clients,id',
            'projectUsers.*' => 'distinct|exists:users,id',
        ]);

        $proj = Project::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'client_id' => $req->input('client'),
        ]);

        $proj->users()->saveMany(\App\User::findMany($req->input('projectUsers')));

        return redirect(route('project', [ 'id' => $proj->id ]));
    }

    public function editPost(Request $req, $id) {

        if (Gate::denies('manage-projects')) {
            return redirect()->back()->withErrors('Invalid action');
        }

        $proj = Project::find($id);
        if (!$proj) {
            return redirect()->back()->withErrors('Invalid action');
        }

        $req->validate([
            'name' => 'required',
            'description' => 'required',
            'client' => 'required|exists:clients,id',
            'projectUsers.*' => 'distinct|exists:users,id',
        ]);

        $proj->name = $req->input('name');
        $proj->description = $req->input('description');
        $proj->client_id = $req->input('client');

        // Adicionar usuários novos
        foreach($req->input('projectUsers') as $userId) {
            $user = \App\User::find($userId);

            if (!$proj->users->contains($user)) {
                $proj->users()->save($user);
            }
        }

        $informedUsers = collect($req->input('projectUsers'));
        // Remover usuários
        foreach($proj->users as $user) {
            if(!$informedUsers->contains($user->id)) {
                $proj->users()->detach($user);
            }
        }

        $proj->save();

        return redirect(route('project', [ 'id' => $proj->id ]));
    }

    public function showAll() {
        return view('all-projects',[
            'projects' => Project::All(),
            'terminated' => Project::onlyTrashed()->get(),
        ]);
    }

    public function terminate($id) {
        if (Gate::denies('manage-projects')) {
            return redirect()->back()->withErrors('Você não tem permissão para fazer isso.');
        }

        $proj = Project::find($id);

        if (!$proj) {
            return redirect()->back()->withErrors('Ação inválida.');
        }

        $proj->delete();

        return redirect(route('project', $proj->id));
    }

    public function report(Request $req, $id) {
        $proj = Project::withTrashed()->find($id);

        if ($proj == null) {
            return redirect()->back()->withErrors('Ação inválida');
        }

        if (Gate::denies('check-project-report', $proj)) {
            return redirect()->back()->withErrors('Você não tem permissão para isso');
        }

        $req->validate([
            'start' => 'date|nullable',
            'end' => 'date|nullable'
        ]);

        $start = null;
        $end = null;
        if ($req->input('start') != '') {
            $start = new Carbon($req->input('start'));
        }
        if ($req->input('end') != '') {
            $end = new Carbon($req->input('end'));

            // O final é o FIM do dia informado
            $end->hour = 23;
            $end->minute = 59;
            $end->second = 59;
        }

        if ($start && $end && $end < $start) {
            return redirect()->back()->withErrors('Invalid dates informed');
        }

        // Filtrando os logs
        $logs = $proj->logs();
        if ($start) {
            $logs = $logs->where('created_at', '>=', $start);
        }
        if ($end) {
            $logs = $logs->where('created_at', '<=', $end);
        }

        // Filtrando as tarefas completadas
        $tasks = $proj->tasks()->onlyTrashed();
        if ($start) {
            $tasks = $tasks->where('deleted_at', '>=', $start);
        }
        if ($end) {
            $tasks = $tasks->where('deleted_at', '<=', $end);
        }

        return view('project-report', [
            'proj' => $proj,
            'logs' => $logs,
            'tasks' => $tasks,
            'start' => $start,
            'end' => $end,
        ]);
    }
}
