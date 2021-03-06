  <!-- DATA TABLES SCRIPT -->
  <script type="text/javascript" src="{{ asset('assets/vendor/skote/libs/datatables/datatables.min.js') }}"></script>
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net/js/jquery.dataTables.min.js') }}"></script>--}}
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>--}}
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>--}}
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>--}}
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>--}}
{{--  <script type="text/javascript" src="{{ asset('packages/datatables.net-fixedheader-bs4/js/fixedHeader.bootstrap4.min.js') }}"></script>--}}

  <script>
    @if ($crud->getPersistentTable())

        var saved_list_url = localStorage.getItem('{{ Str::slug($crud->getRoute()) }}_list_url');

        //check if saved url has any parameter or is empty after clearing filters.

        if (saved_list_url && saved_list_url.indexOf('?') < 1) {
            var saved_list_url = false;
        }else{
            var persistentUrl = saved_list_url+'&persistent-table=true';
        }

    var arr =  window.location.href.split('?');
        //check if url has parameters.
        if (arr.length > 1 && arr[1] !== '') {
                // IT HAS! Check if it is our own persistence redirect.
                if (window.location.search.indexOf('persistent-table=true') < 1) {
                    // IF NOT: we don't want to redirect the user.
                    saved_list_url = false;
                }
        }

    @if($crud->getPersistentTableDuration())
        var saved_list_url_time = localStorage.getItem('{{ Str::slug($crud->getRoute()) }}_list_url_time');

        if (saved_list_url_time) {
            var $current_date = new Date();
            var $saved_time = new Date(parseInt(saved_list_url_time));
            $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

            //if the save time is not expired we force the filter redirection.
            if($saved_time > $current_date) {
                if (saved_list_url && persistentUrl!=window.location.href) {
                    window.location.href = persistentUrl;
                }
            } else {
            //persistent table expired, let's not redirect the user
                saved_list_url = false;
            }
        }

    @endif
        if (saved_list_url && persistentUrl!=window.location.href) {
            window.location.href = persistentUrl;
        }
    @endif

    var crud = {
      exportButtons: JSON.parse('{!! json_encode($crud->get('list.export_buttons')) !!}'),
      functionsToRunOnDataTablesDrawEvent: [],
      addFunctionToDataTablesDrawEventQueue: function (functionName) {
          if (this.functionsToRunOnDataTablesDrawEvent.indexOf(functionName) == -1) {
          this.functionsToRunOnDataTablesDrawEvent.push(functionName);
        }
      },
      responsiveToggle: function(dt) {
          $(dt.table().header()).find('th').toggleClass('all');
          dt.responsive.rebuild();
          dt.responsive.recalc();
      },
      executeFunctionByName: function(str, args) {
        var arr = str.split('.');
        var fn = window[ arr[0] ];

        for (var i = 1; i < arr.length; i++)
        { fn = fn[ arr[i] ]; }
        fn.apply(window, args);
      },
      updateUrl : function (new_url) {
        url_start = "{{ url($crud->route) }}";
        url_end = new_url.replace(url_start, '');
        url_end = url_end.replace('/search', '');
        new_url = url_start + url_end;

        window.history.pushState({}, '', new_url);
        localStorage.setItem('{{ Str::slug($crud->getRoute()) }}_list_url', new_url);
      },
      dataTableConfiguration: {

        @if ($crud->getResponsiveTable())
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        // show the content of the first column
                        // as the modal header
                        // var data = row.data();
                        // return data[0];
                        return '';
                    }
                } ),
                renderer: function ( api, rowIdx, columns ) {

                  var data = $.map( columns, function ( col, i ) {
                      var columnHeading = crud.table.columns().header()[col.columnIndex];

                      // hide columns that have VisibleInModal false
                      if ($(columnHeading).attr('data-visible-in-modal') == 'false') {
                        return '';
                      }

                      return '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td style="vertical-align:top; border:none;"><strong>'+col.title.trim()+':'+'<strong></td> '+
                                '<td style="padding-left:10px;padding-bottom:10px; border:none;">'+col.data+'</td>'+
                              '</tr>';
                  } ).join('');

                  return data ?
                      $('<table class="table table-striped mb-0">').append( '<tbody>' + data + '</tbody>' ) :
                      false;
                },
            }
        },
        fixedHeader: true,
        @else
        responsive: false,
        scrollX: true,
        @endif

        @if ($crud->getPersistentTable())
        stateSave: true,
        /*
            if developer forced field into table 'visibleInTable => true' we make sure when saving datatables state
            that it reflects the developer decision.
        */

        stateSaveParams: function(settings, data) {

            localStorage.setItem('{{ Str::slug($crud->getRoute()) }}_list_url_time', data.time);

            data.columns.forEach(function(item, index) {
                var columnHeading = crud.table.columns().header()[index];
                    if ($(columnHeading).attr('data-visible-in-table') == 'true') {
                        return item.visible = true;
                    }
            });
        },
        @if($crud->getPersistentTableDuration())
        stateLoadParams: function(settings, data) {
            var $saved_time = new Date(data.time);
            var $current_date = new Date();

            $saved_time.setMinutes($saved_time.getMinutes() + {{$crud->getPersistentTableDuration()}});

            //if the save time as expired we force datatabled to clear localStorage
            if($saved_time < $current_date) {
                if (localStorage.getItem('{{ Str::slug($crud->getRoute())}}_list_url')) {
                    localStorage.removeItem('{{ Str::slug($crud->getRoute()) }}_list_url');
                }
                if (localStorage.getItem('{{ Str::slug($crud->getRoute())}}_list_url_time')) {
                    localStorage.removeItem('{{ Str::slug($crud->getRoute()) }}_list_url_time');
                }
               return false;
            }
        },
        @endif
        @endif
        autoWidth: false,
        pageLength: {{ $crud->getDefaultPageLength() }},
        lengthMenu: @json($crud->getPageLengthMenu()),
        /* Disable initial sort */
        aaSorting: [],
        language: {
              "emptyTable":     "{{ trans('skote::crud.emptyTable') }}",
              "info":           "{{ trans('skote::crud.info') }}",
              "infoEmpty":      "{{ trans('skote::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('skote::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('skote::crud.infoPostFix') }}",
              "thousands":      "{{ trans('skote::crud.thousands') }}",
              "lengthMenu":     "{{ trans('skote::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('skote::crud.loadingRecords') }}",
              "processing":     "<img src='{{ asset('assets/vendor/skote/images/ajax-loader.gif') }}' alt='{{ trans('skote::crud.processing') }}'>",
              "search": "_INPUT_",
              "searchPlaceholder": "{{ trans('skote::crud.search') }}...",
              "zeroRecords":    "{{ trans('skote::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('skote::crud.paginate.first') }}",
                  "last":       "{{ trans('skote::crud.paginate.last') }}",
                  "next":       ">",
                  "previous":   "<"
              },
              "aria": {
                  "sortAscending":  "{{ trans('skote::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('skote::crud.aria.sortDescending') }}"
              },
              "buttons": {
                  "copy":   "{{ trans('skote::crud.export.copy') }}",
                  "excel":  "{{ trans('skote::crud.export.excel') }}",
                  "csv":    "{{ trans('skote::crud.export.csv') }}",
                  "pdf":    "{{ trans('skote::crud.export.pdf') }}",
                  "print":  "{{ trans('skote::crud.export.print') }}",
                  "colvis": "{{ trans('skote::crud.export.column_visibility') }}"
              },
          },
          processing: true,
          serverSide: true,
          searching: @json($crud->getOperationSetting('searchableTable') ?? true),
          ajax: {
              "url": "{!! url($crud->route.'/search').'?'.Request::getQueryString() !!}",
              "type": "POST"
          },
          // dom:
          //   "<'row hidden'<'col-sm-6 hidden-xs'i><'col-sm-6 hidden-print'f>>" +
          //   "<'row'<'col-sm-12'tr>>" +
          //   "<'row mt-2 '<'col-sm-6 col-md-4'l><'col-sm-2 col-md-4 text-center'B><'col-sm-6 col-md-4 hidden-print'p>>",
      }
  }
  </script>

  @include('skote::crud.inc.export_buttons')

  <script type="text/javascript">
    jQuery(document).ready(function($) {

      crud.table = $("#crudTable").DataTable(crud.dataTableConfiguration);

      // move search bar
      // $("#crudTable_filter").appendTo($('#datatable_search_stack' ));
      // $("#crudTable_filter input").removeClass('form-control-sm');
        $("#crudTable_filter input").removeClass('form-control-sm');
      // move "showing x out of y" info to header
      // $("#datatable_info_stack").html($('#crudTable_info')).css('display','inline-flex').addClass('animated fadeIn');

        $('#crudTable_length select').removeClass('custom-select-sm');
      @if($crud->getOperationSetting('resetButton') ?? true)
        // create the reset button
        var crudTableResetButton = '<a href="{{url($crud->route)}}" class="btn btn-light waves-effect m-l-10" id="crudTable_reset_button">{{ trans('skote::crud.reset') }}</a>';

        $('#crudTable_filter').append(crudTableResetButton);

          // when clicking in reset button we clear the localStorage for datatables.
        $('#crudTable_reset_button').on('click', function() {

          //clear the filters
          if (localStorage.getItem('{{ Str::slug($crud->getRoute())}}_list_url')) {
              localStorage.removeItem('{{ Str::slug($crud->getRoute()) }}_list_url');
          }
          if (localStorage.getItem('{{ Str::slug($crud->getRoute())}}_list_url_time')) {
              localStorage.removeItem('{{ Str::slug($crud->getRoute()) }}_list_url_time');
          }

          //clear the table sorting/ordering/visibility
          if(localStorage.getItem('DataTables_crudTable_/{{ $crud->getRoute() }}')) {
              localStorage.removeItem('DataTables_crudTable_/{{ $crud->getRoute() }}');
          }
        });
      @endif

      // move the bottom buttons before pagination
      $("#bottom_buttons").insertBefore($('#crudTable_wrapper .row:last-child' ));

      // override ajax error message
      $.fn.dataTable.ext.errMode = 'none';
      $('#crudTable').on('error.dt', function(e, settings, techNote, message) {
          new Noty({
              type: "error",
              text: "<strong>{{ trans('skote::crud.ajax_error_title') }}</strong><br>{{ trans('skote::crud.ajax_error_text') }}"
          }).show();
      });

      // make sure AJAX requests include XSRF token
      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
      });

      // on DataTable draw event run all functions in the queue
      // (eg. delete and details_row buttons add functions to this queue)
      $('#crudTable').on( 'draw.dt',   function () {
         crud.functionsToRunOnDataTablesDrawEvent.forEach(function(functionName) {
            crud.executeFunctionByName(functionName);
         });
      } ).dataTable();

      // when datatables-colvis (column visibility) is toggled
      // rebuild the datatable using the datatable-responsive plugin
      $('#crudTable').on( 'column-visibility.dt',   function (event) {
         crud.table.responsive.rebuild();
      } ).dataTable();

      @if ($crud->getResponsiveTable())
        // when columns are hidden by reponsive plugin,
        // the table should have the has-hidden-columns class
        crud.table.on( 'responsive-resize', function ( e, datatable, columns ) {
            if (crud.table.responsive.hasHidden()) {
              $("#crudTable").removeClass('has-hidden-columns').addClass('has-hidden-columns');
             } else {
              $("#crudTable").removeClass('has-hidden-columns');
             }
        } );
      @else
        // make sure the column headings have the same width as the actual columns
        // after the user manually resizes the window
        var resizeTimer;
        function resizeCrudTableColumnWidths() {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function() {
            // Run code here, resizing has "stopped"
            crud.table.columns.adjust();
          }, 250);
        }
        $(window).on('resize', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('expanded.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
        $(document).on('collapsed.pushMenu', function(e) {
          resizeCrudTableColumnWidths();
        });
      @endif

    });
  </script>

  @include('skote::crud.inc.details_row_logic')
