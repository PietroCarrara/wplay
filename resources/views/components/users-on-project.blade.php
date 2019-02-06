<div class="form-group">
    <div class="form-row">
        {{-- Nessa div ficam os inputs hidden dos id's de usuário --}}
        <div id="usersInputs">

        </div>
        <div class="form-group col-md-4">
            <label for="Usuários No Projeto">Usuários</label>
            <input type="text" class="form-control" id="searchInput" onInput="search(this.value)" aria-describedby="searchHelp"
                placeholder="Procure por usuários">
            <small id="searchHelp" class="form-text text-muted">Procure por um usuário e adicione-o no projeto (não se preocupe, você poderá adicionar/remover mais usuários depois).</small>
        </div>        <div class="form-group col-md-4">
            <label>Resultado da Busca</label><br />
            <small id="search-empty">Nenhum usuário encontrado.</small>
            <div class="list-group" id="search-box">
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>Usuários No Projeto</label><br />
            <small id="selected-empty">Nenhum usuário selecionado ainda.</small>
            <div class="list-group" id="selected-box">
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/user-box.js') }}"></script>
<script>
var selectedUsers = new UserBox('#selected-box',
                                '#selected-empty',
                                (user) => {
                                    selectedUsers.remove(user);
                                    var input = document.querySelector(`#user-hidden-input-${user.id}`);
                                    input.parentElement.removeChild(input);
                                });

var searchUsers = new UserBox('#search-box',
                              '#search-empty',
                              (user) => {
                                  selectedUsers.add(user);
                                  document.querySelector('#usersInputs').innerHTML +=
                                    `<input type="hidden" name="projectUsers[]" id="user-hidden-input-${user.id}" value="${user.id}">`;
                                  searchUsers.remove(user);
                              });
</script>

@if(isset($project))
{{-- Preencher os usuários que já estão no projeto --}}
<script async defer>
document.addEventListener("DOMContentLoaded", function(event) { 
    var users = @json($project->users);
    for (var user of users) {
        searchUsers.onclick(user);
    }
});
</script>
@endif

<script>
var searchTask;

function search(text) {
    // Cancelar a última busca
    clearTimeout(searchTask);

    // Limpar os resultados
    searchUsers.clear();

    // Se não buscaram nada, não faça nada
    if (text.length <= 0) {
        return;
    }

    // Impedir usuários já selecionados de aparecer novamente
    searchUsers.list.push(...selectedUsers.list);

    // Dar algum feedback de que a busca está sendo feita
    document.querySelector('#search-empty').innerText = 'searching...';

    // Buscar os usuários
    searchTask = setTimeout(() => {
        fetch(`{{ route('api.user.search') }}?q=${encodeURIComponent(text)}`,{
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(res => res.json())
        .then((users) => {
            document.querySelector('#search-empty').innerText = 'Nenhum usuário encontrado.';
            if (users.length > 0) {
                searchUsers.add(...users);
            }
        });
    }, 500);
}
</script>