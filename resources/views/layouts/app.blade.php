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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&family=Vina+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Sans+TC&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                                  <div class="logo" id="logo">
                                      <span class="sonija"><i class="bi bi-ticket-detailed logson"></i> Sonija</span>
                                      <span class="simple">SIMPLE</span>
                                      <!-- <img class="devlogo" src="/img/devLOGO.png" id="devlogo"> -->
                                      <span class="ticket" id="cloud">Ticket</span>
                                      
                                      <div class="future">our support, your success</div>
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

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item disabled">{{ __('👋 Hello! ') }}{{ Auth::user()->name }}</a>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                                     <i class="bi bi-grid-1x2"></i>
                                        {{ __('Dashboard') }}
                                    </a>
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
        </nav>

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
