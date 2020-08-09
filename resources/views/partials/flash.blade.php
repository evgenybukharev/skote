<div id="flash-box" class="p-b-15"></div>
@if ($errors->any())
@section('script-bottom')
    @parent
    <script>
        @foreach ($errors->all() as $error)
        new Noty({
            text: "{{ $error }}",
            type: 'error',
        }).show();
        @endforeach
    </script>
@endsection
@endif

@if(Session::has('success'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('success')}}",
            type: 'success',
        }).show();
    </script>
@endsection
@endif
@if(Session::has('success-box'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('success-box')}}",
            type: 'success',
            container: '#flash-box'
        }).show();
    </script>
@endsection
@endif



@if(Session::has('info'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('info')}}",
            type: 'info',
        }).show();
    </script>
@endsection
@endif

@if(Session::has('info-box'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('info-box')}}",
            type: 'info',
            container: '#flash-box'
        }).show();
    </script>
@endsection
@endif

@if(Session::has('error'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('error')}}",
            type: 'error',
        }).show();
    </script>
@endsection
@endif

@if(Session::has('error-box'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('error-box')}}",
            type: 'error',
            container: '#flash-box'
        }).show();
    </script>
@endsection
@endif

@if(Session::has('warning'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('warning')}}",
            type: 'warning',
        }).show();
    </script>
@endsection
@endif

@if(Session::has('warning-box'))
@section('script-bottom')
    @parent
    <script>
        new Noty({
            text: "{{Session::pull('warning-box')}}",
            type: 'warning',
            container: '#flash-box'
        }).show();
    </script>
@endsection
@endif
