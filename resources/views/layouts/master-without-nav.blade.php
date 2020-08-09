<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Всезаймы</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon-apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    @include('skote::layouts.head')
</head>

@yield('body')
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
@yield('content')

@include('skote::layouts.footer-script')
</body>
</html>
