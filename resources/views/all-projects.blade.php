@extends('layouts.main')

@section('content')
    <div class="row">
    @forelse($projects as $project)
        <div class="col-md-4">
            @include('components.project-card')
        </div>
    @empty
        Não há projetos cadastrados.
    @endforelse
    </div>

    @if (Gate::allows('manage-projects'))
        <p class="text-center">
            Notamos que você é um administrador.<br/>
            Por que não <a href="{{ route('project.create') }}">cria</a> um projeto?
        </p>
    @endif
@endsection