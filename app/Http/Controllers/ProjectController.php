<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Project;

class ProjectController extends Controller
{
    public function show($id) {
        return view('project', [
            'project' => Project::find($id),
        ]);
    }
}
