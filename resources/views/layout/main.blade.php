<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{!! csrf_token() !!}" />
        <meta name="_token" content="{!! csrf_token() !!}"/>

        {!! sesstoken_meta() !!}

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title> .:: TALKTUBE ::.</title>

        <!-- Fonts -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway" rel="stylesheet">

        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/fontawesome/web-fonts-with-css/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.min.css') }}" type="text/css" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/dist/assets/owl.carousel.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/dist/assets/owl.theme.default.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('assets/zmdi-icons/css/material-design-iconic-font.min.css') }} ">

        <script type="text/javascript" src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/owlcarousel/dist/owl.carousel.min.js') }}"></script>
        <script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
    </head>
    <body>
        <div class="loading"></div>

        <div id="app" class="position-ref full-height app-color">
            @yield('content')
        </div>

        <script type="text/javascript">
            window.rootUrl = '{{ url("/") }}';

            window.pusherSettings = {
                sesstoken: '{{ sesstoken() }}',
                appKey: '{{ env("PUSHER_APP_KEY") }}',
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
            };

            window.peerServerSettings = {
                host: '{{ env("PEERJS_SERVER_HOST") }}',
                key: '{{ env("PEERJS_SERVER_KEY") }}',
                port: '{{ env("PEERJS_SERVER_PORT") }}',
                path: '{{ env("PEERJS_SERVER_PATH") }}'
            }

        </script>

        <script type="text/javascript" src="{{ asset('js/resources.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/services.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

        <script type="text/javascript">
            window.loading.hide();
        </script>

        @yield('scripts')
    </body>
</html>
