@extends('skote::layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route(config('skote.url.dashboard', 'dashboard'))}}">Панель управления</a></li>
                        @if ($crud->hasAccess('list'))
                            <li class="breadcrumb-item"><a href="{{ url($crud->route) }}">{{ $crud->entity_name_plural }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="{{ $crud->getShowContentClass() }}">

                        <!-- Default box -->
                        <div class="">
                            @if ($crud->model->translationEnabled())
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <!-- Change translation button group -->
                                        <div class="btn-group float-right">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{trans('skote::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                                    <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                            @endif
                            <div class="card no-padding no-border">
                                <table class="table table-striped mb-0">
                                    <tbody>
                                    @foreach ($crud->columns() as $column)
                                        <tr>
                                            <td>
                                                <strong>{!! $column['label'] !!}:</strong>
                                            </td>
                                            <td>
                                                @if (!isset($column['type']))
                                                    @include('skote::crud.columns.text')
                                                @else
                                                    @if(view()->exists('vendor.skote.crud.columns.'.$column['type']))
                                                        @include('vendor.skote.crud.columns.'.$column['type'])
                                                    @else
                                                        @if(view()->exists('skote::crud.columns.'.$column['type']))
                                                            @include('skote::crud.columns.'.$column['type'])
                                                        @else
                                                            @include('skote::crud.columns.text')
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($crud->buttons()->where('stack', 'line')->count())
                                        <tr>
                                            <td><strong>{{ trans('skote::crud.actions') }}</strong></td>
                                            <td>
                                                @include('skote::crud.inc.button_stack', ['stack' => 'line'])
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/show.js') }}"></script>
@endsection
