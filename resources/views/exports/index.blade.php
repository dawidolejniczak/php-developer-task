@foreach($exports as $export)
    <a href="{{ route('exports.show', $export->id) }}">{{ $export->uniqid }}</a> <br/>
@endforeach