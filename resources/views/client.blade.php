@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                Cliente: {{ $client->name }}
            </div>
            <div class="card-body">
                @include('components.errors')
                {{-- Infos do usuário --}}
                <h3>Informações</h3>
                <div class="row mb-4">
                    <div class="col-md-6 my-2">
                        <strong>Cliente registrado em:</strong> {{ $client->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de projetos encomendados:</strong> {{ $client->projects()->count() }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Total de projetos encerrados:</strong> {{ $client->projects()->onlyTrashed()->count() }}
                    </div>
                    <div class="col-md-6 my-2">
                        <strong>Contato 1:</strong> {{ $client->contact1 }}
                    </div>
                    @if ($client->contact2)
                    <div class="col-md-6 my-2">
                        <strong>Contato 2:</strong> {{ $client->contact2 }}
                    </div>
                    @endif
                    @if (Gate::allows('manage-clients'))
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCliModal">
                            Editar
                        </button>
                    </div>
                    @endif
                </div>

                {{-- Logs do usuário --}}
                <h3>Projetos encomendados</h3>
                <div class="row">
                    @forelse($client->projects as $project)
                    <div class="col-md-6">
                        @include('components.project-card')
                    </div>
                    @empty
                    <div class="col-md-12 text-center">
                        Nenhum projeto encomendado.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de edição do cliente --}}
<div class="modal fade" id="editCliModal" tabindex="-1" role="dialog" aria-labelledby="editCliModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCliModalLabel">Editar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('components.client-form')
            </div>
            <div class="modal-footer">
                    <button type="button" onclick="document.querySelector('#createClientForm').submit()" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection