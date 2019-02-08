<form id="createClientForm" method="POST">
    @csrf
    <div class="form-group">
        <label for="clientName">Nome</label>
        <input type="text" class="form-control" id="clientName" name="name" placeholder="Nome Do Cliente"
        @if (isset($client))
            value="{{ $client->name }}"
        @endif
        >
    </div>
    <div class="form-group">
        <label for="clientName">Contato 1</label>
        <input type="text" class="form-control" id="clientContact1" name="contact1" placeholder="Opção de contato 1"
        @if (isset($client))
            value="{{ $client->contact1 }}"
        @endif
        >
    </div>
    <div class="form-group">
        <label for="clientName">Contato 2</label>
        <input type="text" class="form-control" id="clientContact2" name="contact2" placeholder="Opção de contato 2"
        @if (isset($client) && $client->contact2)
            value="{{ $client->contact2 }}"
        @endif
        >
    </div>
</form>
