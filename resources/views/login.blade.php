@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                Entrar
            </div>
            <div class="card-body">

                @foreach ($errors->all() as $error)
                    @if ($loop->first)
                        <div class="alert alert-danger">
                    @endif
                        {{ $error }}<br>
                    @if ($loop->last)
                        </div>
                    @endif
                @endforeach

                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="usuario">Email</label>
                        <input type="email" id="usuario" class="form-control" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="password" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
                <small>Ainda não possui uma conta? <a href="{{ route('register') }}">Registre-se</a> agora.</small>
            </div>
        </div>
    </div>
</div>
@endsection