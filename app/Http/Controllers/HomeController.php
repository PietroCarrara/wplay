<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;
use \App\Project;

class HomeController extends Controller
{
    public function index() {

        $projects = [];

        if (Auth::check()) {
            if (Gate::allows('manage-projects')) {
                $projects = Project::All();
            } else {
                $projects = Auth::user()->projects;
            }
        }

        return view('home', [
            'projects' => $projects,
        ]);
    }
}
