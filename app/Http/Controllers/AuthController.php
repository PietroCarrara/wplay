<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use \App\User;
use App\UserControl;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
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
            UserControl::create([
                'ip' => $req->ip(),
                'type' => 'login',
                'user_id' => Auth::user()->id,
            ]);

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

        UserControl::create([
            'ip' => $req->ip(),
            'type' => 'login',
            'user_id' => Auth::user()->id,
        ]);

        return redirect(route('home'));
    }

    public function logout(Request $req) {
        UserControl::create([
            'ip' => $req->ip(),
            'type' => 'logout',
            'user_id' => Auth::user()->id,
        ]);
        
        Auth::logout();

        return redirect(route('home'));
    }
}
