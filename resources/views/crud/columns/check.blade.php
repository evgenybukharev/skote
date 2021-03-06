{{-- checkbox with loose false/null/0 checking --}}
@php
    $checkValue = data_get($entry, $column['name']);

    $checkedIcon = data_get($column, 'icons.checked', 'la-check-circle');
    $uncheckedIcon = data_get($column, 'icons.unchecked', 'la-circle');

    $exportCheckedText = data_get($column, 'labels.checked', trans('skote::crud.yes'));
    $exportUncheckedText = data_get($column, 'labels.unchecked', trans('skote::crud.no'));

    $icon = $checkValue == false ? $uncheckedIcon : $checkedIcon;

    $column['text'] = $checkValue == false ? $exportUncheckedText : $exportCheckedText;
    $column['escaped'] = $column['escaped'] ?? true;
@endphp

<span>
    <i class="la {{ $icon }}"></i>
</span>

<span class="sr-only">
    @includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_end')
</span>
