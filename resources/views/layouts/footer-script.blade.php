        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/vendor/skote/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/skote/libs/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/skote/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/skote/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/skote/libs/node-waves/node-waves.min.js')}}"></script>

        @yield('script')

        <!-- App js -->
        <script src="{{ URL::asset('assets/vendor/skote/js/app.min.js')}}"></script>

        @yield('script-bottom')
