<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;
use \App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function search(Request $req) {

        if (Gate::denies('manage-users')) {
            return redirect(route('home'))->withErrors('Você não tem permissão pra vir aqui');
        }

        if (strlen($req->input('q')) > 0) {
            $users = User::where('name', 'like', '%' . $req->input('q') . '%')->orderBy('role')->orderBy('name')->get();
        } else {
            $users = [];
        }

        if ($req->ajax()) {
            return response()->json($users);
        } else {
            return view('search-users', [
                'users' => $users,
            ]);
        }
    }

    public function makeAdmin($id) {

        if (Gate::denies('manage-users')) {
            return redirect()->back()->withErrors('Você não tem permissão para isso');
        }

        $user = User::find($id);

        if ($user == null || $user->role == 'admin') {
            return redirect()->back()->withErrors('Ação inválida');
        }

        $user->role = 'admin';
        $user->save();

        return redirect()->back();
    }

    public function removeAdmin($id) {

        if (Gate::denies('manage-users')) {
            return redirect()->back()->withErrors('Você não tem permissão para isso');
        }

        $user = User::find($id);

        if ($user == null || $user->role != 'admin') {
            return redirect()->back()->withErrors('Ação inválida');
        }

        if ($user == Auth::user()) {
            return redirect()->back()->withErrors('Você não pode remover os próprios privilégios');
        }

        $user->role = 'user';
        $user->save();

        return redirect()->back();
    }

    public function report($id) {

        $user = User::find($id);

        if ($user == null) {
            return redirect()->back()->withErrors('Ação inválida');
        }

        if (Gate::denies('check-user-report', $user)) {
            return redirect()->back()->withErrors('Você não tem permissão para isso');
        }

        $completedTasks = $user->tasks()->onlyTrashed()->get()->count();

        return view('user-report', [
            'user' => $user,
            'completed' => $completedTasks,
        ]);
    }
}
