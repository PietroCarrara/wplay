<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
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

    public function report(Request $req, $id) {

        $user = User::find($id);

        if ($user == null) {
            return redirect()->back()->withErrors('Ação inválida');
        }

        if (Gate::denies('check-user-report', $user)) {
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

        // Filtrando pontos batidos do usuário
        $userControls = $user->controls();
        if ($start) {
            $userControls = $userControls->where('created_at', '>=', $start);
        }
        if ($end) {
            $userControls = $userControls->where('created_at', '<=', $end);
        }
        $controls = [];
        foreach($userControls->where('type', 'login')->get() as $control) {
            // Vamos supor que um login antes das 10:00 da manhã seja um ponto batido
            if ($control->created_at->hour < 10) {
                // Vamos contar esse dia nos pontos batidos
                $controls[] = $control->created_at->format('d/m/Y');
            }
        }
        // Múltiplos logins no mesmo dia são só um ponto batido
        $controls = array_unique($controls);

        // Filtrando comentários
        $comms = $user->comments();
        if ($start) {
            $comms = $comms->where('created_at', '>=', $start);
        }
        if ($end) {
            $comms = $comms->where('created_at', '<=', $end);
        }
        $comms = $comms->get();


        // Filtrando os logs
        $logs = $user->logs();
        if ($start) {
            $logs = $logs->where('created_at', '>=', $start);
        }
        if ($end) {
            $logs = $logs->where('created_at', '<=', $end);
        }

        // Filtrando as tarefas completadas
        $tasks = $user->tasks()->onlyTrashed();
        if ($start) {
            $tasks = $tasks->where('deleted_at', '>=', $start);
        }
        if ($end) {
            $tasks = $tasks->where('deleted_at', '<=', $end);
        }

        return view('user-report', [
            'user' => $user,
            'controls' => $controls,
            'logs' => $logs,
            'comments' => $comms,
            'tasks' => $tasks,
            'start' => $start,
            'end' => $end,
        ]);
    }
}
