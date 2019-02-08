<div class="card d-flex my-2">
    <div class="card-body">
        <h5 class="card-title"><strong>{{ $project->name }}</strong></h5>
        <p class="card-text">{!! nl2br(e($project->description)) !!}</p>
    </div>
    @auth
    <div class="card-footer text-muted">
        <a href="{{ route('project', [ 'id' => $project->id ]) }}" class="card-link">Ver Projeto</a>

        @if(Gate::allows('check-project-report', $project))
            <a href="{{ route('project.report', $project->id) }}" style="color: white;" class="btn btn-primary">Relatório</a>
        @endif
    </div>
    @endauth
</div>