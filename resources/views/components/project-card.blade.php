<div class="card">
  <div class="card-body">
    <h5 class="card-title"><strong>{{ $project->name }}</strong></h5>
    <p class="card-text">{{ $project->description }}</p>
    <a href="{{ route('project', [ 'id' => $project->id ]) }}" class="card-link">Ver Projeto</a>
  </div>
</div>