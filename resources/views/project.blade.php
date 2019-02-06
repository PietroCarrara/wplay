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

<div class="row my-4">
    <div class="col-md-12">
        <h1>Tarefas</h1>
        @if(Gate::allows('manage-tasks', $project))
        Você pode gerenciar tarefas!
        @else
        Você não pode gerenciar tarefas!
        @endif
    </div>

</div>


@endsection