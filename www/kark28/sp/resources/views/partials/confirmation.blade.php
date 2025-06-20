<h2>{{ $title ?? 'Potvrzení' }}</h2>
<p>{{ $message ?? 'Opravdu chcete pokračovat?' }}</p>

@isset($details)
    <hr>
    {!! $details !!}
@endisset

<form action="{{ $action }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    @isset($hidden)
        @foreach ($hidden as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    @endisset

    <button type="submit" class="btn btn-primary">{{ $confirmText ?? 'Potvrdit' }}</button>
    <button type="button" class="btn btn-secondary" onclick="closeOverlay()">Zrušit</button>
</form>
