@extends('layouts.main')

@section('content')
<div class="card my-4">
    <div class="card-header">
        <a href="{{ route('project', $task->project->id) }}">{{ $task->project->name }}</a> / {{ $task->name }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h5>Descrição:</h5>
                <p>{!! nl2br(e($task->description)) !!}</p>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Participantes
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($task->users()->orderBy('name')->get() as $user)
                        <li class="list-group-item">
                            {{ $user->name }}
                        </li>
                        @empty
                        <li class="list-group-item">
                            Não há participantes
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card my-4">
    <div class="card-header">
        Discussão
    </div>
    <div class="card-body">
    </div>
</div>
@endsection