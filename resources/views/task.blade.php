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

        @if ($task->trashed())
            <strong>Esta tarefa foi concluída em {{ $task->deleted_at->format('d/m/Y H:i') }}</strong>
        @else
            <strong>Votos para completar:</strong> {{ $task->votes()->count() }} / {{ ceil($task->users()->count() / 2) }}<br/>
        @endif

        @if (!$task->trashed() && $task->project->users->contains(Auth::user()))
            @if (!$task->users->contains(Auth::user()))
                <a href="{{ route('project.task.join', [$task->project->id, $task->id]) }}" class="btn btn-success">Juntar-se</a>
            @else
                @if ($task->votes->contains(Auth::user()))
                    <a href="{{ route('project.task.vote', [$task->project->id, $task->id]) }}" class="btn btn-warning">Revogar voto</a>
                @else
                    <a href="{{ route('project.task.vote', [$task->project->id, $task->id]) }}" class="btn btn-success">Votar para completar</a>
                @endif
                <a href="{{ route('project.task.quit', [$task->project->id, $task->id]) }}" class="btn btn-danger">Sair</a>
            @endif
        @endif

    </div>
</div>

<div class="card my-4">
    <div class="card-header">
        Discussão
    </div>
    <div class="card-body">
        <div id="comment-container">
            @forelse ($task->comments as $comment)
                @include('components.comment')
            @empty
                <div id="noComments">
                    Não há comentários.
                </div>
            @endforelse
        </div>

        @if (Gate::allows('comment-task', $task))
            <div class="mt-4">
                <form onSubmit="postComment(event)">
                    @csrf
                    <div class="row">
                        <div class="col-md-11">
                            <input id="comment-input" type="text" class="form-control" name="comment" placeholder="Comente algo...">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">Postar</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function postComment(event) {

    event.preventDefault();

    var formData = new FormData();
    for (var input of event.target) {
        formData.append(input.name, input.value);
    }

    document.querySelector('#comment-input').value = '';

    console.log(formData.entries());

    fetch('{{ route("project.task.comment.create.post", [$task->project->id, $task->id]) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(res => {
        if (res.ok) return res.text();
    })
    .then(comment => {

        if (typeof comment === 'undefined') {
            return;
        }

        document.querySelector('#comment-container').innerHTML += comment;

        var noComm = document.querySelector('#noComments')
        if (noComm != null) {
            noComm.parentElement.removeChild(noComm);
        }
    });
}
</script>
@endsection