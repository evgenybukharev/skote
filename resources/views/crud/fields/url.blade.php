<!-- html5 url input -->
@include('skote::crud.fields.inc.wrapper_start')
    <label class="control-label">{!! $field['label'] !!}</label>
    @include('skote::crud.fields.inc.translatable_icon')
    <input
    	type="url"
    	name="{{ $field['name'] }}"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
        @include('skote::crud.fields.inc.attributes')
    	>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('skote::crud.fields.inc.wrapper_end')
