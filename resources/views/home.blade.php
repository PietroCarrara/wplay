@extends('layouts.main')

@section('content')
<div class="title m-b-md">
    @guest
        Olá visitante!
    @else
        Olá {{ Auth::user()->name }}!
    @endguest
</div>
@endsection