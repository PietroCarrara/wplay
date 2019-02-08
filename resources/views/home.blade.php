@extends('layouts.main')

@section('content')
<div class="title m-b-md">
    <h3>Projetos que você participa</h3>
    <div class="row my-4">
        @forelse (Auth::user()->projects as $project)
            <div class="col-md-4">
                @include('components.project-card')
            </div>
        @empty
            Você não está em nenhum projeto! Peça para que algum administrador o cadastre em algum dos&nbsp;<a href="{{ route('project.all') }}">projetos</a>.
        @endforelse
    </div>
    
    <h3>Tarefas em que você trabalha</h3>
    <div class="row my-4">
        @forelse (Auth::user()->tasks as $task)
            <div class="col-md-4">
                @include('components.task-card')
            </div>
        @empty
            Você não está trabalhando em nenhuma tarefa!
        @endforelse
    </div>

    @if (Gate::allows('manage-projects'))
        <p class="text-center">
            Notamos que você é um administrador.<br/>
            Por que não <a href="{{ route('project.create') }}">cria</a> um projeto?
        </p>
    @endif
</div>
@endsection