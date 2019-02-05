@extends('layouts.main')

@section('content')
<div>
    <h2>{{ $project->name }}</h2>
    <p>{{ $project->description }}</p>
    <ul>
        @foreach($project->users()->orderBy('name')->get() as $user)
            <li>
                {{ $user->name }}
            </li>
        @endforeach
    </ul>
</div>
@endsection