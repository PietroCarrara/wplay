@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Relatório de: {{ $user->name }}
            </div>
            <div class="card-body">
                {{-- Infos do usuário --}}
                <h3>Informações</h3>
                <div class="row mb-4">
                    <div class="col-md-6 my-2">
                        <strong>Conta criada em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Projetos em que participa:</strong> {{ $user->projects()->get()->count() }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de comentários:</strong> {{ $user->comments()->get()->count() }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de tarefas completadas:</strong> {{ $user->tasks()->onlyTrashed()->get()->count() }}
                    </div>
                </div>

                {{-- Logs do usuário --}}
                <h3>Atividades</h3>
                <div class="row">
                    @php($tmpDate = '')
                    @foreach($user->logs()->orderBy('created_at')->get() as $log)
                        @if ($tmpDate != $log->created_at->format('d/m'))
                            @php($tmpDate = $log->created_at->format('d/m'))    
                            <div class="col-md-12 text-center">
                                <h4>{{ $tmpDate }}</h4>
                            </div>
                        @endif
                        <div class="col-md-10 my-1">
                            {!! $log->render() !!}
                        </div>
                        <div class="col-md-2 my-1 text-right">
                            {{ $log->created_at->format('H:i') }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection