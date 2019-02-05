@auth

    <div class="row">
        @foreach (Auth::user()->projects as $project)
            @include('components.project-card', [ 'project' => $project ])
        @endforeach
    </div>

@endauth