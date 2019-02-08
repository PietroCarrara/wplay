<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use \App\Client;

class ClientController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {

        if (Gate::denies('manage-clients')) {
            return redirect()->back()->withErrors('You can\'t do that.');
        }

        return view('create-client');
    }

    public function createPost(Request $req) {
        
        if (Gate::denies('manage-clients')) {
            return redirect()->back()->withErrors('You can\'t do that.');
        }

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
            return response()->json($cli);
        } else {
            return redirect(route('client.show', $cli->id));
        }
    }

    public function edit(Request $req, $id) {

        if (Gate::denies('manage-clients')) {
            return redirect()->back()->withErrors('You can\'t do that.');
        }

        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withErrors('Cliente não encontrado');
        }

        $req->validate([
            'name' => 'required',
            'contact1' => 'required',
        ]);

        $client->name = $req->input('name');
        $client->contact1 = $req->input('contact1');
        $client->contact2 = $req->input('contact2');
        $client->save();

        return redirect(route('client.show', $client->id));
    }

    public function search(Request $req) {
        if (Gate::denies('manage-clients')) {
            return redirect(route('home'))->withErrors('Você não tem permissão pra vir aqui');
        }

        if (strlen($req->input('q')) > 0) {
            $clis = Client::where('name', 'like', '%' . $req->input('q') . '%')->orderBy('name')->get();
        } else {
            $clis = [];
        }

        if ($req->ajax()) {
            return response()->json($clis);
        } else {
            return view('search-clients', [
                'clients' => $clis,
            ]);
        }
    }

    public function show($id) {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withErrors('Cliente não encontrado');
        }

        return view('client', [
            'client' => $client,
        ]);
    }
}