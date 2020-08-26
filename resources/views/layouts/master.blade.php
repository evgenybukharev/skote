<!doctype html>
<html lang="ru">

<head>
    <title> @yield('title') | Всезаймы</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{config('skote.path.favicon','favicon.ico')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{config('skote.path.favicon-apple','favicon-apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{config('skote.path.favicon-32','favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{config('skote.path.favicon-16','favicon-16x16.png')}}">
    @include('skote::layouts.head')
</head>
@section('body')
@show
<body data-sidebar="dark">
<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>
<!-- Begin page -->
<div id="layout-wrapper">
@include('skote::layouts.topbar')
@include('skote::layouts.sidebar')

<!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('skote::partials.flash')
                @yield('content-header')
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('skote::layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
@include('skote::layouts.footer-script')
</body>
</html>
