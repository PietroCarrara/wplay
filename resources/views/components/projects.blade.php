@auth

    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-4">
                @include('components.project-card', [ 'project' => $project ])
            </div>
        @endforeach
    </div>

@endauth