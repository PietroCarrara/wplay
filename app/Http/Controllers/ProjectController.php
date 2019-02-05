<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Project;

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
}
