@extends('skote::layouts.master')

@section('title',$crud->getHeading() ?? $crud->entity_name_plural)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route(config('skote.url.dashboard', 'dashboard'))}}">Панель управления</a></li>
                        <li class="breadcrumb-item active">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Default box -->
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- THE ACTUAL CONTENT -->
                <div class="{{ $crud->getListContentClass() }}">
                    <div class="row mb-0">
                        <div class="col-sm-6">
                    <div id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</div>
                            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                                <div class="hidden-print {{ $crud->hasAccess('create')?'with-border':'' }}">

                                    @include('skote::crud.inc.button_stack', ['stack' => 'top'])

                                </div>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            <div id="datatable_search_stack" class="mt-sm-0 mt-2"></div>
                        </div>
                    </div>

                    {{-- Backpack List Filters --}}
                    @if ($crud->filtersEnabled())
                        @include('skote::crud.inc.filters_navbar')
                    @endif

                    <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
                        <thead>
                        <tr>
                            {{-- Table columns --}}
                            @foreach ($crud->columns() as $column)
                                <th
                                    data-orderable="{{ var_export($column['orderable'], true) }}"
                                    data-priority="{{ $column['priority'] }}"
                                    {{--

                                       data-visible-in-table => if developer forced field in table with 'visibleInTable => true'
                                       data-visible => regular visibility of the field
                                       data-can-be-visible-in-table => prevents the column to be loaded into the table (export-only)
                                       data-visible-in-modal => if column apears on responsive modal
                                       data-visible-in-export => if this field is exportable
                                       data-force-export => force export even if field are hidden

                                   --}}

                                    {{-- If it is an export field only, we are done. --}}
                                    @if(isset($column['exportOnlyField']) && $column['exportOnlyField'] === true)
                                    data-visible="false"
                                    data-visible-in-table="false"
                                    data-can-be-visible-in-table="false"
                                    data-visible-in-modal="false"
                                    data-visible-in-export="true"
                                    data-force-export="true"

                                    @else

                                    data-visible-in-table="{{var_export($column['visibleInTable'] ?? false)}}"
                                    data-visible="{{var_export($column['visibleInTable'] ?? true)}}"
                                    data-can-be-visible-in-table="true"
                                    data-visible-in-modal="{{var_export($column['visibleInModal'] ?? true)}}"
                                    @if(isset($column['visibleInExport']))
                                    @if($column['visibleInExport'] === false)
                                    data-visible-in-export="false"
                                    data-force-export="false"
                                    @else
                                    data-visible-in-export="true"
                                    data-force-export="true"
                                    @endif
                                    @else
                                    data-visible-in-export="true"
                                    data-force-export="false"
                                    @endif
                                    @endif
                                >
                                    {!! $column['label'] !!}
                                </th>
                            @endforeach

                            @if ( $crud->buttons()->where('stack', 'line')->count() )
                                <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}" data-visible-in-export="false">{{ trans('skote::crud.actions') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            {{-- Table columns --}}
                            @foreach ($crud->columns() as $column)
                                <th>{!! $column['label'] !!}</th>
                            @endforeach

                            @if ( $crud->buttons()->where('stack', 'line')->count() )
                                <th>{{ trans('skote::crud.actions') }}</th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>

                    @if ( $crud->buttons()->where('stack', 'bottom')->count() )
                        <div id="bottom_buttons" class="hidden-print">
                            @include('skote::crud.inc.button_stack', ['stack' => 'bottom'])

                            <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('head-styles')
    <!-- DATA TABLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/skote/libs/datatables/datatables.min.css') }}">
    {{--  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">--}}
    {{--  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">--}}
    {{--  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">--}}

    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/skote/crud/css/list.css') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('script-bottom')
    @include('skote::crud.inc.datatables_logic')
    <script src="{{ asset('assets/vendor/skote/crud/js/crud.js') }}"></script>
    <script src="{{ asset('assets/vendor/skote/crud/js/form.js') }}"></script>
    <script src="{{ asset('assets/vendor/skote/crud/js/list.js') }}"></script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection
