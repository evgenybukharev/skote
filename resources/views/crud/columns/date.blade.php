{{-- localized date using nesbot carbon --}}
@php
    use Carbon\Carbon;$value = data_get($entry, $column['name']);

    $column['escaped'] = $column['escaped'] ?? true;
    $column['text'] = empty($value) ? '' : Carbon::parse($value)
                    ->locale(App::getLocale())
                    ->isoFormat($column['format'] ?? config('skote.base.default_date_format'))
@endphp

<span data-order="{{ $value ?? '' }}">
	@includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_end')
</span>
