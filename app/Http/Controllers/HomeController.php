<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Project;

class HomeController extends Controller
{
    public function index() {

        $projects = [];

        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
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
