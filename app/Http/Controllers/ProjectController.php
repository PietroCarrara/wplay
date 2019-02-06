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
            return response('Unauthorized.', 403);
        }

        $proj = Project::find($id);
        if (!$proj) {
            return respose('Not Found.', 404);
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
}
