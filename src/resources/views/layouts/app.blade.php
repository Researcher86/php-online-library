<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="d-flex flex-column">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top navbar-laravel">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/img/books.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <form id="form-search" class="form-inline" action="{!! url('/books') !!}">
                        <div class="input-group">
                            <input name="q" class="form-control py-2 border-right-0 border" type="search" placeholder="Поиск" id="example-search-input">
                            <span class="input-group-append">
                                <div class="input-group-text bg-white"><i class="fa fa-search"></i></div>
                            </span>
                        </div>
                    </form>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-5">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="books">
        <img src="/img/books/07139043.cover_250.jpg" title="">
        <img src="/img/books/09014102.cover_250.jpg" title="">
        <img src="/img/books/13704951.cover_250.jpg" title="">
        <img src="/img/books/26174170.cover_250.jpg" title="">
        <img src="/img/books/27385132.cover_250.jpg" title="">
    </div>
    <div class="row-product-bot"></div>

    <main class="flex-fill py-lg-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white mt-4">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-4">
                    Онлайн библиотека на Laravel 5 (2018 г.) <br>
                    <span class="small">Технологии: Laravel, MySQL, Redis, Elasticsearch, Docker</span>
                </div>
                <div class="col-md-4">
                    <div>
                        <i class="fas fa-map-marker-alt"></i><span> Казахстан, г. Костанай</span>
                    </div>
                    <div>
                        <i class="fas fa-phone"></i><span> +7 452 123456</span>
                    </div>
                    <div>
                        <i class="fas fa-envelope"></i><a href="mailto:researcher2286@gmail.com">
                            researcher2286@gmail.com</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <span>О библиотеке</span> <br>
                    <span class="small">Онлайн библиотека предназначена для поиска и просмотра книг по различным жанрам.</span>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
