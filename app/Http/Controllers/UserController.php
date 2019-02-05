<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class UserController extends Controller
{
    public function search(Request $req) {

        $users = User::where('name', 'like', '%' . $req->input('q') . '%')->get();

        if ($req->ajax()) {
            return response()->json($users);
        } else {
            // return view(...);
        }
    }
}
