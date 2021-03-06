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
    @php
        Auth::guard('api')->user();
    @endphp
    <div id="app">
        <div class="desa-sidebar">
            <div class="sidebar-logo">
                <img src="https://www.powerpartspro.com/template/img/logo.png" height="55">
            </div>
            <div class="sidebar-profile">
                <img src="{{ Auth::user()->photo }}">
                <p>{{ Auth::user()->name }} {{ Auth::user()->surname}}</p>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <router-link :to="{name: 'Home'}">
                        <li><i class="fa fa-home"></i> Home</li>
                    </router-link>
                    <li class="menu-item">
                        <i class="fa fa-user"></i> Clients
                        <span class="itemDirection"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <ul class="sub">
                            <router-link :to="{name: 'clientCreate'}"><li>Add new</li></router-link>
                            <router-link :to="{name: 'clientIndex'}"><li>All clients</li></router-link>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <i class="fa fa-comments"></i> Quotes
                        <span class="itemDirection"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <ul class="sub">
                            <router-link :to="{name: 'quotesCreate'}"><li>Add new</li></router-link>
                            <router-link :to="{name: 'quotesIndex'}"><li>All quotes</li></router-link>
                        </ul>
                    </li>
                    {{-- <li class="menu-item">
                        <i class="fa fa-comments"></i> Requests
                        <span class="itemDirection"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <ul class="sub">
                            <router-link :to="{name: 'requestCreate'}"><li>Add new</li></router-link>
                            <router-link :to="{name: 'requestIndex'}"><li>All requests</li></router-link>
                        </ul>
                    </li> --}}
                    <li class="menu-item">
                        <i class="fa fa-file"></i> Orders
                        <span class="itemDirection"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <ul class="sub">
                            <router-link :to="{name: 'orderCreate'}"><li>Add new</li></router-link>
                            <router-link :to="{name: 'orderIndex'}"><li>All orders</li></router-link>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <i class="fa fa-gift"></i> Products
                        <span class="itemDirection"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <ul class="sub">
                            <router-link :to="{name: 'productCreate'}"><li>Add new</li></router-link>
                            <router-link :to="{name: 'productIndex'}"><li>All products</li></router-link>
                            <router-link :to="{name: 'categoriesView'}"><li>Categories</li></router-link>
                        </ul>
                    </li>
                    <router-link :to="{name: 'settingsProfile'}">
                        <li class="menu-item">
                            <i class="fa fa-gears"></i> Settings
                        </li>
                    </router-link>
                    <router-link :to="{name: 'importProductsView'}">
                        <li class="menu-item">
                            <i class="fa fa-upload"></i> Import
                        </li>
                    </router-link>
                    <li class="menu-item" onclick="(confirm('Do you realy want to log out?')) ? document.getElementById('logout-form').submit() : false;">
                        <i class="fa fa-sign-out"></i> Logout
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
            {{-- <div class="sidebar-copyright">
                Power Parts Pro
            </div> --}}
        </div>
        <div class="desa-content">
            <div class="top">
                <search />
                {{-- <b>{{ Auth::user()->name . ' ' . Auth::user()->surname }}</b> --}}

                {{-- <ul>
                    <li><i class="fa fa-search"></i></li>
                    <li><i class="fa fa-envelope"></i></li>
                    <li><i class="fa fa-bell"></i></li>
                    <li><i class="fa fa-weixin"></i></li>
                </ul> --}}
            </div>
            <div class="desa-content-main">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        window.user_id = '{{ Auth::user()->id }}'
        window.api_token = '{{ Auth::user()->api_token}}'
        window.csrf = '{{ csrf_token() }}'
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="https://use.fontawesome.com/31ce0d6872.js"></script> --}}
</body>
</html>
