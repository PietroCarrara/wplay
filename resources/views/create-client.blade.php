@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Criar um cliente
            </div>
            <div class="card-content">
                <div class="card-body">
                    @include('components.errors')
                    @include('components.client-form')
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-primary" onclick="document.querySelector('#createClientForm').submit()">Criar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection