<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Project;
use Gate;

class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show($id) {
        return view('project', [
            'project' => Project::find($id),
        ]);
    }

    public function create() {
        return view('create-project');
    }

    public function createPost(Request $req) {

        if (Gate::denies('create-projects')) {
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
}
