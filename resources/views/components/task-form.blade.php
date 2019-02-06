<div class="form-group">
    <label for="taskName">Nome</label>
    <input type="text" class="form-control" id="taskNake" name="name" placeholder="Nome Da Tarefa"
        @if (isset($task))
            value="{{ $task->name }}"
        @endif
    >
</div>
<div class="form-group">
    <label for="projectDesc">Descrição</label>
    <textarea class="form-control" id="projectDesc" name="description" placeholder="Descrição da Tarefa">
@if (isset($task))
{{ $task->description }}
@endif
    </textarea>
</div>