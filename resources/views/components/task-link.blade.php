<a href="{{ route('project.task', [
    $task->project()->withTrashed()->get()->first()->id,
    $task->id]) }}">{{ $task->name }}</a>