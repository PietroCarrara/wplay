@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                Registrar
            </div>
            <div class="card-body">
                @include('components.errors')
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="usuario">Email</label>
                        <input type="email" id="usuario" class="form-control" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="senha">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="password" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="senha">Confirme a Senha</label>
                        <input type="password" class="form-control" id="senha" name="password_confirmation" placeholder="Confirme a Senha">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
                <small>Já possui uma conta? <a href="{{ route('login') }}">Entre</a> agora.</small>
            </div>
        </div>
    </div>
</div>
@endsection