@extends('layouts.main')

@section('content')
    <h1>Projetos Ativos</h1>
    <div class="row">
    @forelse($projects as $project)
        <div class="col-md-4">
            @include('components.project-card')
        </div>
    @empty
        Não há projetos ativos.
    @endforelse
    </div>

    <h1 class="mt-4">Projetos Encerrados</h1>
    <div class="row">
    @forelse($terminated as $project)
        <div class="col-md-4">
            @include('components.project-card')
        </div>
    @empty
        Não há projetos encerrados.
    @endforelse
    </div>

    @if (Gate::allows('manage-projects'))
        <p class="text-center">
            Notamos que você é um administrador.<br/>
            Por que não <a href="{{ route('project.create') }}">cria</a> um projeto?
        </p>
    @endif
@endsection