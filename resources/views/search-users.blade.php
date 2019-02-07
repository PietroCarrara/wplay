@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Procurar usuários
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
                            <tr>
                                @forelse($users as $user)
                                <td>{{ $user->name }}</td>
                                <td class="text-right">
                                    @if ($user->role != 'admin')
                                    <a href="{{ route('user.makeadmin', $user->id) }}" class="btn btn-success">Tornar
                                        admin</a>
                                    @else
                                    <a href="{{ route('user.removeadmin', $user->id) }}" class="btn btn-danger">Remover
                                        admin</a>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('user.report', $user->id) }}" class="btn btn-primary">Ver
                                        relatórios</a>
                                </td>
                            </tr>
                            @empty
                            Não há resultados.
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection