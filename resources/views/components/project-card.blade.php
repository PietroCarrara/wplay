<div class="card d-flex my-2">
    <div class="card-body">
        <h5 class="card-title"><strong>{{ $project->name }}</strong></h5>
        <p class="card-text">{!! nl2br(e($project->description)) !!}</p>
    </div>
    @auth
    <div class="card-footer text-muted">
        <a href="{{ route('project', [ 'id' => $project->id ]) }}" class="card-link">Ver Projeto</a>

        @if (Gate::allows('manage-projects'))
        <a class="card-link" style="color: red;">Deletar Projeto</a>
        @endif
    </div>
    @endauth
</div>