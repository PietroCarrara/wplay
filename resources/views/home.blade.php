@extends('layouts.main')

@section('content')
<div class="title m-b-md">
    @guest
        Olá visitante!
    @else
        Olá {{ Auth::user()->name }}!

        @include('components.projects')

        @if (Gate::allows('create-projects'))
            <p class="text-center">
                Notamos que você é um administrador.<br/>
                Por que não <a href="{{ route('project.create') }}">cria</a> um projeto?
            </p>
        @endif
    @endguest
</div>
@endsection