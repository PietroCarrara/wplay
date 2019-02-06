@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        {{ $project->name }}
    </div>
    <div class="card-body">
        <div class="row">
            @if(Gate::allows('manage-projects'))
            <div class="col-md-12">
                @include('components.project-form')
            </div>
            @else
            <div class="col-md-8">
                <h5>Descrição:</h5>
                <p>{!! nl2br(e($project->description)) !!}</p>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Integrantes
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($project->users()->orderBy('name')->get() as $user)
                        <li class="list-group-item">
                            {{ $user->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal pra criar uma tarefa --}}
<div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Criar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('project.tasks.create.post', $project->id) }}">
                    @include('components.errors')
                    @csrf
                    @include('components.task-form')
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-md-12">
        <h1>Tarefas</h1>

        <div class="row my-4">
            @foreach($project->tasks as $task)
                <div class="col-md-4">
                    @include('components.task-card')
                </div>
            @endforeach
        </div>

        @if(Gate::allows('manage-tasks', $project))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">Criar Tarefa</button>
        @endif
    </div>

</div>


@endsection