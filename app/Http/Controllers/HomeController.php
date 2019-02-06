<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;
use \App\Project;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
}
