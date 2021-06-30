<!-- CKeditor -->
@php
    $field['extra_plugins'] = isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : "embed,widget";

    $defaultOptions = [
          'language'=> 'ru',
'toolbar'=>[
    'items'=>[
         'heading',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'fontBackgroundColor',
                            'fontColor',
                            'fontFamily',
                            'fontSize',
                            'highlight',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'undo',
                            'redo',
                            '|',
                            'alignment',
                            'indent',
                            'outdent',
                            'removeFormat',
                            'strikethrough',
                            'subscript',
                            'superscript',
                            '-',
                            'imageInsert',
                            'pageBreak',
                            'htmlEmbed',
                            'insertTable',
                            'mediaEmbed',
                            'imageUpload',
                            'blockQuote',
                            'CKFinder',
                            'code',
                            'codeBlock',
                            'horizontalLine'
],
    'shouldNotGroupWhenFull'=> true,
]
    ];

    $field['options'] = array_merge($defaultOptions, $field['options'] ?? [])
@endphp

@include('skote::crud.fields.inc.wrapper_start')
<label class="control-label">{!! $field['label'] !!}</label>
@include('skote::crud.fields.inc.translatable_icon')
<textarea
        id="editor-{{ $field['name'] }}"
        name="{{ $field['name'] }}"
        data-init-function="bpFieldInitCKEditorElement"
        data-options="{{ trim(json_encode($field['options'])) }}"
        @include('skote::crud.fields.inc.attributes', ['default_class' => 'form-control'])
    	>{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('skote::crud.fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field)
    @endphp

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('assets/vendor/skote/libs/ckeditor5/build/ckeditor.js') }}"></script>
        <script>
            function bpFieldInitCKEditorElement(element) {
                const watchdog = new CKSource.EditorWatchdog();

                window.watchdog = watchdog;

                watchdog.setCreator((element, config) => {
                    return CKSource.Editor
                        .create(element, config)
                        .then(editor => {
                            return editor;
                        })
                });

                watchdog.setDestructor(editor => {
                    return editor.destroy();
                });

                watchdog.on('error', handleError);

                watchdog.create(document.querySelector('#editor-{{ $field['name'] }}'), element.data('options'))
                    .catch(handleError);

                function handleError(error) {
                    console.error('Oops, something went wrong!');
                    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                    console.warn('Build id: vf6qk9b3gx0k-dxy5x592ijkv');
                    console.error(error);
                }
            }
        </script>
    @endpush

@endif

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
