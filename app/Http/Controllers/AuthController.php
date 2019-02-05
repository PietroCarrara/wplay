<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use \App\User;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login() {
        return view('login');
    }

    public function register() {
        return view('register');
    }

    public function loginPost(Request $req) {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $info = $req->only('email', 'password');

        if (Auth::attempt($info)) {
            return redirect(route('home'));
        } else {
            return redirect(route('login'))->withErrors('Usuário e/ou senha incorretos!');
        }
    }

    public function registerPost(Request $req) {
        $req->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'confirmed|required|min:6|max:16',
            'name' => 'required',
        ]);
        
        $usr = User::create([
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'name' => $req->input('name'),
        ]);

        Auth::login($usr);

        return redirect(route('home'));
    }

    public function logout() {
        Auth::logout();

        return redirect(route('home'));
    }
}
