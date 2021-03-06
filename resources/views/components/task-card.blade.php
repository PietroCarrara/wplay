<div class="my-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $task->name }}</h5>
            <p class="card-text">{!! nl2br(e($task->description)) !!}</p>

            <a href="{{ route('project.task', [$task->project_id, $task->id]) }}" class="card-link">Ver Tarefa</a>
            @if (!$task->trashed() && $task->project()->withTrashed()->get()->first()->users->contains(Auth::user()))
                {{-- Se o projeto ainda está ativo... --}}
                @if ($task->project)
                    @if (!$task->users->contains(Auth::user()))
                        <a href="{{ route('project.task.join', [$task->project_id, $task->id]) }}" class="card-link btn btn-success">Juntar-se</a>
                    @else
                        <a href="{{ route('project.task.quit', [$task->project_id, $task->id]) }}" class="card-link btn btn-danger">Sair</a>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
