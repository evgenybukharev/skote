<!-- password -->

@php
    // autocomplete off, if not otherwise specified
    if (!isset($field['attributes']['autocomplete'])) {
        $field['attributes']['autocomplete'] = "off";
    }
@endphp

@include('skote::crud.fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('skote::crud.fields.inc.translatable_icon')
    <input
    	type="password"
    	name="{{ $field['name'] }}"
        @include('skote::crud.fields.inc.attributes')
    	>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('skote::crud.fields.inc.wrapper_end')
