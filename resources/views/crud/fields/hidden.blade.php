@php
	// if not otherwise specified, the hidden input should take up no space in the form
  $field['wrapper']['class'] = $field['wrapper']['class'] ?? $field['wrapperAttributes']['class'] ?? "hidden";
@endphp

<!-- hidden input -->
@include('skote::crud.fields.inc.wrapper_start')
  <input
  	type="hidden"
    name="{{ $field['name'] }}"
    value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
    @include('skote::crud.fields.inc.attributes')
  	>
@include('skote::crud.fields.inc.wrapper_end')
