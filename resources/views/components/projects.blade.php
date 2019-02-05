@auth

    <div class="row">
        @foreach (Auth::user()->projects as $project)
            {{ $project->name }}
        @endforeach
    </div>

@endauth