@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        {{ $project->name }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <strong>Projeto encomendado por: </strong> @include('components.client-link', ['client' => $project->client])
                <h5 class="mt-4">Descrição:</h5>
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
            <div class="row mx-1">
                <div class="col-md-12">
                    @if (Gate::allows('manage-projects'))
                        @if(!$project->trashed())
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#terminateProjModal">
                                Encerrar Projeto
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProjModal">
                                Editar
                            </button>
                        @else
                            <strong>Este projeto foi encerrado em {{ $project->deleted_at->format('d/m/Y') }}</strong>
                        @endif
                    @endif
                    @if (Gate::allows('check-project-report', $project))
                        <a class="btn btn-primary" href="{{ route('project.report', $project->id) }}">
                            Relatório
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de encerramento do projeto --}}
<div class="modal fade" id="terminateProjModal" tabindex="-1" role="dialog" aria-labelledby="terminateProjModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="terminateProjModalLabel">Encerrar o Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1>Tem certeza que deseja <strong>encerrar</strong> o projeto?</h1>
            </div>
            <div class="modal-footer">
                <a href="{{ route('project.terminate', $project->id) }}" class="btn btn-danger">Encerrar</a>
            </div>
        </div>
    </div>
</div>

{{-- Modal de edição do projeto --}}
<div class="modal fade" id="editProjModal" tabindex="-1" role="dialog" aria-labelledby="editProjModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjModalLabel">Editar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('components.project-form')
            </div>
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
        <h1>Tarefas
        @if ($project->trashed())
            que estavam
        @endif
        em andamento</h1>

        <div class="row my-4">
            @forelse($project->tasks as $task)
                <div class="col-md-4">
                    @include('components.task-card')
                </div>
            @empty
                Não há tarefas completadas
            @endforelse
        </div>

        @if(Gate::allows('manage-tasks', $project))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">Criar Tarefa</button>
        @endif
    </div>
</div>

<div class="row my-4">
    <div class="col-md-12">
        <h1>Tarefas
        @if ($project->trashed())
            que estavam
        @endif
        completas</h1>

        <div class="row my-4">
            @forelse($project->tasks()->onlyTrashed()->get() as $task)
                <div class="col-md-4">
                    @include('components.task-card')
                </div>
            @empty
                Não há tarefas completadas
            @endforelse
        </div>
    </div>
</div>

@endsection