<!-- text input -->

<?php

// the field should work whether or not Laravel attribute casting is used
if (isset($field['value']) && (is_array($field['value']) || is_object($field['value']))) {
    $field['value'] = json_encode($field['value']);
}

?>

@include('skote::crud.fields.inc.wrapper_start')
<label class="control-label">{!! $field['label'] !!}</label>
@include('skote::crud.fields.inc.translatable_icon')
<input type="hidden"
       value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
       name="{{ $field['name'] }}">

@if(isset($field['prefix']) || isset($field['suffix']))
    <div class="input-group"> @endif
        @if(isset($field['prefix']))
            <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        @if(isset($field['store_as_json']) && $field['store_as_json'])
            <input
                    type="text"
                    data-dadata-address="{&quot;field&quot;: &quot;{{$field['name']}}&quot;, &quot;full&quot;: {{isset($field['store_as_json']) && $field['store_as_json'] ? 'true' : 'false'}} }"
                    data-init-function="bpFieldInitAddressDadataElement"
                    @include('skote::crud.fields.inc.attributes')
            >
        @else
            <input
                    type="text"
                    data-dadata-address="{&quot;field&quot;: &quot;{{$field['name']}}&quot;, &quot;full&quot;: {{isset($field['store_as_json']) && $field['store_as_json'] ? 'true' : 'false'}} }"
                    data-init-function="bpFieldInitAddressDadataElement"
                    name="{{ $field['name'] }}"
                    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
                    @include('skote::crud.fields.inc.attributes')
            >
        @endif
        @if(isset($field['suffix']))
            <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('skote::crud.fields.inc.wrapper_end')

{{-- Note: you can use  to only load some CSS/JS once, even though there are multiple instances of it --}}

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <style>
            .ap-input-icon.ap-icon-pin {
                right: 5px !important;
            }

            .ap-input-icon.ap-icon-clear {
                right: 10px !important;
            }
        </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>
        <script>

            function bpFieldInitAddressDadataElement(element) {
                var $addressConfig = element.data('dadata-address');
                var $field = $('[name="' + $addressConfig.field + '"]');

                if ($field.val().length) {
                    var existingData = JSON.parse($field.val());
                    element.val(existingData.value);
                }

                $(element[0]).suggestions({
                    token: '{{ $field['api_key'] ?? config('services.dadata.key') }}',
                    type: "ADDRESS",
                    /* Вызывается, когда пользователь выбирает одну из подсказок */
                    onSelect: function(suggestion) {
                        $field.val(JSON.stringify(suggestion));
                    },
                    onSelectNothing:function (){
                        $field.val("");
                        element.val("");
                    }
                });

                element.change(function(){
                    console.info(element.val());
                    if (!element.val().length) {
                        $field.val("");
                    }
                });
            }

            function initDadataAddressAutocomplete() {
                $('[data-dadate-address]').each(function () {
                    var element = $(this);
                    var functionName = element.data('init-function');

                    if (typeof window[functionName] === "function") {
                        window[functionName](element);
                    }
                });
            }

            initDadataAddressAutocomplete();
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
