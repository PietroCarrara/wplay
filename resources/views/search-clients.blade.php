@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Procurar clientes
            </div>
            <div class="card-body">
                @include('components.errors')
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" name="q">
                    </div>
                    <div class="form-group">
                        <button class="form-control btn btn-primary">Buscar</button>
                    </div>
                </form>
                <div class="my-4">
                    <table class="table table-hover">
                        <tbody>
                            @forelse($clients as $client)
                            <tr>
                                <td>@include('components.client-link')</td>
                            </tr>
                            @empty
                                Não há resultados.
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="text-center">
                    Notamos que você é um administrador.<br/>
                    Por que não <a href="{{ route('client.create') }}">cadastra</a> um cliente?
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
