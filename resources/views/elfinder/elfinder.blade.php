@extends('skote::layouts.master')

@section('title',trans('skote::base.file_manager'))

@section('script-bottom')
    @include('vendor.elfinder.common_scripts')
    @include('vendor.elfinder.common_styles')

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale)
                lang: '{{ $locale }}', // locale
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}'
            });
        });
    </script>
@endsection

@php
    $breadcrumbs = [
      trans('skote::crud.admin') => url(config('skote.base.route_prefix'), 'dashboard'),
      'File Manager' => false,
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{trans('skote::base.file_manager')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route(config('skote.url.dashboard', 'dashboard'))}}">Панель управления</a></li>
                        <li class="breadcrumb-item active">{{trans('skote::base.file_manager')}}</li>
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
                    <div id="elfinder"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
