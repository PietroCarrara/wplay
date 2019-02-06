@include('components.errors')
<form method="POST">
    @csrf
    <div class="form-group">
        <label for="projectName">Nome</label>
        <input type="text" class="form-control" id="projectName" name="name" placeholder="Nome Do Projeto"
            @if (isset($project))
                value="{{ $project->name }}"
            @endif
        >
    </div>
    <div class="form-group">
        <label for="projectDesc">Descrição</label>
        <textarea class="form-control" id="projectDesc" name="description" placeholder="Descrição do Projeto">
@if (isset($project))
{{ $project->description }}
@endif
        </textarea>
    </div>
    <div class="form-group">
        <label for="projectClient">Projeto encomendado por:</label>
        <div class="row">
            <div class="col-md-10">
                <select id="clientSelect" id="projectClient" class="form-control" name="client">
                    <option value="">Selecione um cliente</option>
                    @foreach(\App\Client::get()->sortBy('name') as $client)
                        <option value="{{ $client->id }}"
                            @if(isset($project) && $project->client_id == $client->id)
                                selected="true"
                            @endif
                        >{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createClientModal">Criar Cliente</button>
        </div>
    </div>
    @include('components.users-on-project')
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

{{-- Modal para criar um novo cliente --}}
<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModal">Criar novo cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div id="createClientErrors"></div>
                    <form id="createClientForm">
                        @csrf
                        <div class="form-group">
                            <label for="clientName">Nome</label>
                            <input type="text" class="form-control" id="clientName" name="name" placeholder="Nome Do Cliente">
                        </div>
                        <div class="form-group">
                            <label for="clientName">Contato 1</label>
                            <input type="text" class="form-control" id="clientContact1" name="contact1" placeholder="Opção de contato 1">
                        </div>
                        <div class="form-group">
                            <label for="clientName">Contato 2</label>
                            <input type="text" class="form-control" id="clientContact2" name="contact2" placeholder="Opção de contato 2">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendClient()">Create</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/sender.js') }}"></script>
<script src="{{ asset('js/error-box.js') }}"></script>
<script>
    var clientErrors = new ErrorBox('#createClientErrors');

    function sendClient() {
        sender.sendForm('#createClientForm', "{{ route('api.client.create') }}")
        .then(res => res.json())
        .then(res => {
            clientErrors.clear();
            
            if (typeof res.message !== 'undefined') { // É um erro
                if (typeof res.errors !== 'undefined') {
                    for (var err in res.errors) {
                        clientErrors.add(...res.errors[err]);
                    }
                }
            } else { // Não há erro
                // Adicionar o novo cliente na lista e selecioná-lo
                var select = document.querySelector('#clientSelect');
                select.innerHTML += `<option value=${res.id}>${res.name}</option>`;
                select.value = res.id;

                // Fechar a modal
                $('#createClientModal').modal('hide');

                clientErrors.clear();
            }
        });
    }
</script>