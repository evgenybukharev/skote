<!-- select multiple -->
@php
    if (!isset($field['options'])) {
        $options = $field['model']::all();
    } else {
        $options = call_user_func($field['options'], $field['model']::query());
    }
@endphp

@include('skote::crud.fields.inc.wrapper_start')

    <label class="control-label">{!! $field['label'] !!}</label>
    @include('skote::crud.fields.inc.translatable_icon')

    <select
    	class="form-control"
        name="{{ $field['name'] }}[]"
        @include('skote::crud.fields.inc.attributes')
    	multiple>

		@if (!isset($field['allows_null']) || $field['allows_null'])
			<option value="">-</option>
		@endif

    	@if (count($options))
    		@foreach ($options as $option)
				@if( (old(square_brackets_to_dots($field["name"])) && in_array($option->getKey(), old(square_brackets_to_dots($field["name"])))) || (is_null(old(square_brackets_to_dots($field["name"]))) && isset($field['value']) && in_array($option->getKey(), $field['value']->pluck($option->getKeyName(), $option->getKeyName())->toArray())))
					<option value="{{ $option->getKey() }}" selected>{{ $option->{$field['attribute']} }}</option>
				@else
					<option value="{{ $option->getKey() }}">{{ $option->{$field['attribute']} }}</option>
				@endif
    		@endforeach
    	@endif

	</select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

@include('skote::crud.fields.inc.wrapper_end')
