
<input type="hidden" name="http_referrer" value={{url($crud->route) }}>

<!-- Tab panes -->
{{-- See if we're using tabs --}}
@if ($crud->tabsEnabled() && count($crud->getTabs()))
    @include('skote::crud.inc.show_tabbed_fields')
    <input type="hidden" name="current_tab" value="{{ Str::slug($crud->getTabs()[0]) }}" />
@else
  <div class="card">
    <div class="card-body row">
      @include('skote::crud.inc.show_fields', ['fields' => $crud->fields()])
    </div>
  </div>
@endif


{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}

@section('head-styles-after')
    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/'.$action.'.css') }}">

    <!-- CRUD FORM CONTENT - crud_fields_styles stack -->
    @stack('crud_fields_styles')
@endsection

@push('script-bottom')
    <script src="{{ asset('assets/vendor/skote/crud/js/crud.js') }}"></script>
    <script src="{{ asset('assets/vendor/skote/crud/js/form.js') }}"></script>
    <script src="{{ asset('assets/vendor/skote/crud/js/'.$action.'.js') }}"></script>

    <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
    @stack('crud_fields_scripts')

    <script>
    function initializeFieldsWithJavascript(container) {
      var selector;
      if (container instanceof jQuery) {
        selector = container;
      } else {
        selector = $(container);
      }
      selector.find("[data-init-function]").not("[data-initialized=true]").each(function () {
        var element = $(this);
        var functionName = element.data('init-function');

        if (typeof window[functionName] === "function") {
          window[functionName](element);

          // mark the element as initialized, so that its function is never called again
          element.attr('data-initialized', 'true');
        }
      });
    }

    jQuery('document').ready(function($){

      // trigger the javascript for all fields that have their js defined in a separate method
      initializeFieldsWithJavascript('form');


      // Save button has multiple actions: save and exit, save and edit, save and new
      var saveActions = $('#saveActions'),
      crudForm        = saveActions.parents('form'),
      saveActionField = $('[name="save_action"]');

      saveActions.on('click', '.dropdown-menu a', function(){
          var saveAction = $(this).data('value');
          saveActionField.val( saveAction );
          crudForm.submit();
      });

      // Ctrl+S and Cmd+S trigger Save button click
      $(document).keydown(function(e) {
          if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
          {
              e.preventDefault();
              $("button[type=submit]").trigger('click');
              return false;
          }
          return true;
      });

      // prevent duplicate entries on double-clicking the submit form
      crudForm.submit(function (event) {
        $("button[type=submit]").prop('disabled', true);
      });

      // Place the focus on the first element in the form
      @if( $crud->getAutoFocusOnFirstField() )
        @php
          $focusField = Arr::first($fields, function($field) {
              return isset($field['auto_focus']) && $field['auto_focus'] == true;
          });
        @endphp

        @if ($focusField)
          @php
            $focusFieldName = isset($focusField['value']) && is_iterable($focusField['value']) ? $focusField['name'] . '[]' : $focusField['name'];
          @endphp
          window.focusField = $('[name="{{ $focusFieldName }}"]').eq(0),
        @else
          var focusField = $('form').find('input, textarea, select').not('[type="hidden"]').eq(0),
        @endif

        fieldOffset = focusField.offset().top,
        scrollTolerance = $(window).height() / 2;

        focusField.trigger('focus');

        if( fieldOffset > scrollTolerance ){
            $('html, body').animate({scrollTop: (fieldOffset - 30)});
        }
      @endif

      // Add inline errors to the DOM
      @if ($crud->inlineErrorsEnabled() && $errors->any())

        window.errors = {!! json_encode($errors->messages()) !!};
        // console.error(window.errors);

        $.each(errors, function(property, messages){

            var normalizedProperty = property.split('.').map(function(item, index){
                    return index === 0 ? item : '['+item+']';
                }).join('');

            var field = $('[name="' + normalizedProperty + '[]"]').length ?
                        $('[name="' + normalizedProperty + '[]"]') :
                        $('[name="' + normalizedProperty + '"]'),
                        container = field.parents('.form-group');

            container.addClass('text-danger');
            container.children('input, textarea, select').addClass('is-invalid');

            $.each(messages, function(key, msg){
                // highlight the input that errored
                var row = $('<div class="invalid-feedback">' + msg + '</div>');
                row.appendTo(container);

                // highlight its parent tab
                @if ($crud->tabsEnabled())
                var tab_id = $(container).closest('[role="tabpanel"]').attr('id');
                $("#form_tabs [aria-controls="+tab_id+"]").addClass('text-danger');
                @endif
            });
        });

      @endif

      $("a[data-toggle='tab']").click(function(){
          currentTabName = $(this).attr('tab_name');
          $("input[name='current_tab']").val(currentTabName);
      });

      if (window.location.hash) {
          $("input[name='current_tab']").val(window.location.hash.substr(1));
          $('ul.nav a[href="#tab_' + window.location.hash.substr(1) + '"]').trigger('click');
      }

      });
    </script>
@endpush
