<!-- textarea -->
@include('skote::crud.fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('skote::crud.fields.inc.translatable_icon')
    <textarea
    	name="{{ $field['name'] }}"
        @include('skote::crud.fields.inc.attributes')

    	>{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('skote::crud.fields.inc.wrapper_end')
