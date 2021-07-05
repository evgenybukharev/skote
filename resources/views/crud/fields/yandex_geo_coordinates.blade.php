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
@if(isset($field['prefix']) || isset($field['suffix']))
    <div class="input-group"> @endif
        @if(isset($field['prefix']))
            <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
            id="yandex-map-coordinates-{{$field['name']}}"
            type="text"
            data-init-function="bpFieldInitAddressGoogleElement"
            name="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('skote::crud.fields.inc.attributes')
        >
        @if(isset($field['suffix']))
            <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
<div id="yandex-map-{{$field['name']}}" style="margin-top:30px;width: 100%; height: 400px;"></div>
@include('skote::crud.fields.inc.wrapper_end')

{{-- Note: you can use  to only load some CSS/JS once, even though there are multiple instances of it --}}

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field)
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <style>

        </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="https://api-maps.yandex.ru/2.1/?apikey={{$field['token']}}&lang=ru_RU" type="text/javascript"></script>
        <script>

            function bpFieldInitAddressGoogleElement(element) {
                ymaps.ready(init);

                function init() {
                    var coord = [55.76, 37.64];
                    var myMap = new ymaps.Map("yandex-map-{{$field['name']}}", {
                        center: coord,
                        zoom: 10
                    }, {
                        searchControlProvider: 'yandex#search'
                    });


                    var myPlacemark = new ymaps.Placemark(coord, null, {
                        preset: 'islands#blueDotIcon',
                        draggable: true
                    });

                    let geoCoordInput = $('#yandex-map-coordinates-{{$field['name']}}');
                    if(geoCoordInput.val()){
                        coord=geoCoordInput.val().split(',');
                        myPlacemark.geometry.setCoordinates(coord);
                    }

                    /* Событие dragend - получение нового адреса */
                    myPlacemark.events.add('dragend', function (e) {
                        var cord = e.get('target').geometry.getCoordinates();
                        geoCoordInput.val(cord);
                    });

                    myMap.events.add("click", function (e) {
                        var cord = e.get('coords');
                        myPlacemark.geometry.setCoordinates(cord);
                        geoCoordInput.val(cord);
                    });

                    myMap.geoObjects.add(myPlacemark);
                    myMap.setCenter(coord, 7);

                }

            }

        </script>

    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
