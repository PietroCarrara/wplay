<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Client;

class ClientController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Request $req) {
        
        $req->validate([
            'name' => 'required',
            'contact1' => 'required',
        ]);

        $cli = Client::create([
            'name' => $req->input('name'),
            'contact1' => $req->input('contact1'),
            'contact2' => $req->input('contact2'),
        ]);

        if ($req->ajax()) {
            // Se foi na api, devolve o JSON
            return response()->json($cli);
        } else {
            // Senão, redireciona
            // TODO: Redirecionar para a página do cliente novo
        }
    }
}