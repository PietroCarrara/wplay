@foreach ($errors->all() as $error)
    @if ($loop->first)
        <div class="alert alert-danger">
    @endif
        {{ $error }}<br>
    @if ($loop->last)
        </div>
    @endif
@endforeach
