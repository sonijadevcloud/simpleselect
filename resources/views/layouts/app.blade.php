<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ config('app.desc') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/styles.css'])

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&family=Vina+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Sans+TC&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                                  <div class="logo" id="logo">
                                      <span class="sonija"><i class="bi bi-p-square-fill sonijaicon"></i> Sonija</span>
                                      <span class="simple">SIMPLE</span>
                                      <!-- <img class="devlogo" src="/img/devLOGO.png" id="devlogo"> -->
                                      <span class="ticket" id="cloud">Select</span>
                                      
                                      <div class="future">your parking sentinel</div>
                                  </div>
                              </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link nlh" href="{{ route('login') }}">{{ __('Login as an agent') }}</a>
                                </li>
                            @endif

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle" style="font-size: 1.3rem;"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end  z-3" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item disabled">{{ __('👋 Hello! ') }}{{ Auth::user()->name }}</a><br>
                                    <a class="dropdown-item" href="{{ route('settings') }}">
                                                     <i class="bi bi-sliders"></i>
                                        {{ __('User Settings') }}
                                    </a>
                                    <a class="dropdown-item mt-1 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="bi bi-box-arrow-right"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                    </ul>
                </div>
            </div>
            <hr>
        </nav>
        @guest
            @if (Route::has('login'))
            
            @endif
            @else
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary navbar-light bg-white shadow-sm z-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == 'home' ? 'nvactive' : '' }}" href="{{ route('home') }}"><i class="bi bi-house"></i> {{ __('Home')}}</a>
                </li>
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-receipt"></i> {{ __('Notices')}}</a>
                </li>
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-suit-heart"></i> {{ __('Subscriptions')}}</a>
                </li>
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-bank"></i> {{ __('Enforcement')}}</a>
                </li>
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }} dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-p-circle"></i> {{ __('PPZ Settings')}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear-wide-connected"></i> {{ __('Main settings')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-journal-text"></i> {{ __('Dictionaries')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-phone-vibrate"></i> {{ __('Control settings')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-cpu"></i> {{ __('Integration settings')}}</a></li>
                    </ul>
                </li>
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link nvlss {{ Request::is('admin*') ? 'nvactive' : '' }} dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-fingerprint"></i> {{ __('Administration')}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-sliders2-vertical"></i> {{ __('System settings')}}</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-people"></i> {{ __('Users management')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-lock"></i> {{ __('Privilege management')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-cpu"></i> {{ __('Integration management')}}</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock"></i> {{ __('Security settings')}}</a></li>
                    </ul>
                </li>
            </ul>
            </div>
        </div>
        </nav>
        @endguest

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <footer>
    <p>© {{ date('Y') }}. {{ __('All rights reserved for Sonija Dev Cloud') }}.</p>
    <p>{{ __('version') }} {{ config('app.version') }}</p>
    </footer>
    @include('cookie-consent::index')
    <script>
        // ENABLE TOOLTIPS
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        // ///
    </script>
</body>
</html>
