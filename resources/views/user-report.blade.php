@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Relatório de: {{ $user->name }}
            </div>
            <div class="card-body">
                {{-- Filtros de data --}}
                <h3>Filtrar Período</h3>
                <form>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            @include('components.errors')
                        </div>
                        <div class="form-row mx-3">
                            <div class="form-group col-md-6">
                                <label for="startDate">Início</label>
                                <input type="date" id="startDate" name="start" class="form-control"
                                @if ($start)
                                    value="{{ $start->format('Y-m-d') }}"
                                @endif>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="endDate">Fim</label>
                                <input type="date" id="endDate" name="end" class="form-control"
                                @if ($end)
                                    value="{{ $end->format('Y-m-d') }}"
                                @endif>
                            </div>
                            <div class="form-group col-md-12">
                                <small>Ambos os filtros são opcionais. Informe somente um para visualisar dados a partir de/até certa data.</small><br/>
                            </div>
                            <button class="btn btn-primary" type="submit">Filtrar</button>
                        </div>
                    </div>
                </form>
                {{-- Infos do usuário --}}
                <h3>Informações</h3>
                <div class="row mb-4">
                    <div class="col-md-6 my-2">
                        <strong>Conta criada em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Pontos batidos:</strong> <a href="#" data-toggle="modal" data-target="#controlModal">{{
                            count($controls) }}</a>
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de comentários:</strong> <a href="#" data-toggle="modal" data-target="#commentModal">{{ $comments->count() }}</a>
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de tarefas completadas:</strong> {{ $tasks->count()
                        }}
                    </div>
                </div>

                {{-- Logs do usuário --}}
                <h3>Atividades</h3>
                <div class="row">
                    @php($tmpDate = '')
                    @foreach($logs->orderBy('created_at')->get() as $log)
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
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comentários</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                @foreach($comments as $comm)
                <div class="col-md-7 my-2">
                    <strong>{{ $comm->user->name }}</strong>: {{ $comm->contents }}<br/>
                </div>
                <div class="col-md-5 my-2 text-right">
                    Na tarefa @include('components.task-link', ['task' => $comm->task()->withTrashed()->get()->first()]), em {{ $comm->created_at->format('d/m/y') }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="controlModal" tabindex="-1" role="dialog" aria-labelledby="controlModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="controlModalLabel">Dias de Ponto Batido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @foreach($controls as $control)
                    {{ $control }}<br/>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection