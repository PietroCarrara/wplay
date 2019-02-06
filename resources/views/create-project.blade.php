@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Criar Projeto
            </div>
            <div class="card-body">
                @include('components.project-form')
            </div>
        </div>
    </div>
</div>
@endsection