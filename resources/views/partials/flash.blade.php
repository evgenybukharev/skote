<div id="flash-box" class=""></div>

@if ($errors->any())
    @push('script-bottom')
        <script>
            @foreach ($errors->all() as $error)
            new Noty({
                text: "{{ $error }}",
                type: 'error',
            }).show();
            @endforeach
        </script>
    @endpush
@endif

@if(Session::has('success'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('success')}}",
                type: 'success',
            }).show();
        </script>
    @endpush
@endif
@if(Session::has('success-box'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('success-box')}}",
                type: 'success',
                container: '#flash-box'
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('info'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('info')}}",
                type: 'info',
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('info-box'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('info-box')}}",
                type: 'info',
                container: '#flash-box'
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('error'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('error')}}",
                type: 'error',
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('error-box'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('error-box')}}",
                type: 'error',
                container: '#flash-box'
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('warning'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('warning')}}",
                type: 'warning',
            }).show();
        </script>
    @endpush
@endif

@if(Session::has('warning-box'))
    @push('script-bottom')
        <script>
            new Noty({
                text: "{{Session::pull('warning-box')}}",
                type: 'warning',
                container: '#flash-box'
            }).show();
        </script>
    @endpush
@endif
