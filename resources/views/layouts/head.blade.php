
        @yield('css')
        @stack('css')
        @yield('head-styles')
        @stack('head-styles')

        <!-- App css -->
      <link href="{{ URL::asset('assets/vendor/skote/css/app.min.css')}}" id="app-light" rel="stylesheet" type="text/css" />

        @yield('head-styles-after')
        @stack('head-styles-after')
