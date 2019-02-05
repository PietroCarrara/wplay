<div class="card d-flex my-2" style="height: 200px;">
    <div class="card-body">
        <h5 class="card-title"><strong>{{ $project->name }}</strong></h5>
        <p class="card-text" style="height: 50px;">{{ $project->description }}</p>
    </div>
    @auth
    <div class="card-footer text-muted">
        <a href="{{ route('project', [ 'id' => $project->id ]) }}" class="card-link">Ver Projeto</a>
        @if (Auth::user()->role == 'admin')
        <a class="card-link" style="color: red;">Deletar Projeto</a>
        @endif
    </div>
    @endauth
</div>