@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Relatório de: @include('components.project-link', ['project' => $proj])
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
                        <strong>Projeto criado em:</strong> {{ $proj->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Encomendado por:</strong> @include('components.client-link', ['client' => $proj->client])
                    </div>
                    @if (!($end || $start))
                    <div class="col-md-6 my-2">
                        @if ($proj->trashed())
                            <strong>Membros que trabalhavam até o encerramento:</strong>
                        @else
                            <strong>Membros trabalhando atualmente:</strong>
                        @endif
                        
                        {{ $proj->users()->count() }}
                    </div>
                    @endif
                    <div class="col-md-6 my-2">
                        <strong>Total de tarefas completadas:</strong> {{ $tasks->count()
                        }}
                    </div>
                </div>

                {{-- Logs do usuário --}}
                <h3>Atividades</h3>
                <div class="row">
                    @php($tmpDate = '')
                    @forelse($logs->orderBy('created_at')->get() as $log)
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
                    @empty
                        <div class="col-md-10 my-1">
                            Nada encontrado.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection