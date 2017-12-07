<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DESAmedia') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="desa-sidebar">
            <div class="sidebar-logo">
                <img src="http://www.powerpartspro.co.uk/themes/powerparts/assets/images/logo.png" height="55">
            </div>
            <div class="sidebar-profile">
                {{-- <img src="https://lh3.googleusercontent.com/-XYhBmobHM8I/AAAAAAAAAAI/AAAAAAAAAAA/fXUYd9YPhCE/s128-c-k/photo.jpg"> --}}
            </div>
            <div class="sidebar-menu">
                <ul>
                    <a href="{{ route('login') }}"><li><i class="fa fa-sign-in" aria-hidden="true"></i> Login</li></a>
                    <a href="{{ route('register') }}"><li><i class="fa fa-user-plus" aria-hidden="true"></i> Register</li></a>
                </ul>
            </div>
            {{-- <div class="sidebar-copyright">
                Power Parts Pro
            </div> --}}
        </div>
        <div class="desa-content">
            <div class="top"></div>
            <div class="desa-content-main">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="https://use.fontawesome.com/31ce0d6872.js"></script> --}}
</body>
</html>
