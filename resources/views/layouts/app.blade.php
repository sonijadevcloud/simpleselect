<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ config('app.title', 'Laravel') }}</title>


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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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
                @if (Auth::check() && 
                (
                    Auth::user()->can('Home-R') || 
                    Auth::user()->can('Home-W') 
                )
                )
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == 'home' ? 'nvactive' : '' }}" href="{{ route('home') }}"><i class="bi bi-house"></i> {{ __('Home')}}</a>
                </li>
                @endif

                @if (Auth::check() && 
                (
                    Auth::user()->can('Noticies-R') || 
                    Auth::user()->can('Noticies-W') || 
                    Auth::user()->can('Noticies-R') 
                )
                )
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-receipt"></i> {{ __('Notices')}}</a>
                </li>
                @endif
                
                @if (Auth::check() && 
                (
                    Auth::user()->can('Subscriptions-R') || 
                    Auth::user()->can('Subscriptions-W') || 
                    Auth::user()->can('Subscriptions-R') 
                )
                )
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-suit-heart"></i> {{ __('Subscriptions')}}</a>
                </li>
                @endif
                
                @if (Auth::check() && 
                (
                    Auth::user()->can('Enforcement-R') || 
                    Auth::user()->can('Enforcement-W') || 
                    Auth::user()->can('Enforcement-R') 
                )
                )
                <li class="nav-item px-2">
                <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }}" href="#"><i class="bi bi-bank"></i> {{ __('Enforcement')}}</a>
                </li>
                @endif

                @if (Auth::check() && 
                        (
                            Auth::user()->can('Rewarding-R') || 
                            Auth::user()->can('Rewarding-W') || 
                            Auth::user()->can('Rewarding-D') || 
                            Auth::user()->can('DailySettlement-R') || 
                            Auth::user()->can('DailySettlement-W') || 
                            Auth::user()->can('DailySettlement-D') || 
                            Auth::user()->can('MonthlyQuarterlySettlement-R') || 
                            Auth::user()->can('MonthlyQuarterlySettlement-W') || 
                            Auth::user()->can('MonthlyQuarterlySettlement-D') || 
                            Auth::user()->can('AnnualSettlement-R') || 
                            Auth::user()->can('AnnualSettlement-W') || 
                            Auth::user()->can('AnnualSettlement-D') || 
                            Auth::user()->can('Documents-R') || 
                            Auth::user()->can('Documents-W') || 
                            Auth::user()->can('Documents-D') || 
                            Auth::user()->can('Reports-R') || 
                            Auth::user()->can('Reports-W') || 
                            Auth::user()->can('Reports-D') 
                        )
                    )
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }} dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-clipboard2-data"></i> {{ __('Accounting & reports')}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><h4 class="dropdown-header pb-3">{{ __('Accounting & reports')}}</h4></li>
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('Rewarding-R') || 
                            Auth::user()->can('Rewarding-W') || 
                            Auth::user()->can('Rewarding-R') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-currency-dollar pe-1"></i> {{ __('Rewarding')}}</a></li>
                        @endif

                        @if (Auth::check() && 
                        (
                            Auth::user()->can('DailySettlement-R') || 
                            Auth::user()->can('DailySettlement-W') || 
                            Auth::user()->can('DailySettlement-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-calendar-event pe-1"></i> {{ __('Daily settlement')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('MonthlyQuarterlySettlement-R') || 
                            Auth::user()->can('MonthlyQuarterlySettlement-W') || 
                            Auth::user()->can('MonthlyQuarterlySettlement-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-calendar2-month pe-1"></i> {{ __('Monthly and quarterly settlement')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AnnualSettlement-R') || 
                            Auth::user()->can('AnnualSettlement-W') || 
                            Auth::user()->can('AnnualSettlement-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-calendar2-x pe-1"></i> {{ __('Annual settlement')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('Documents-R') || 
                            Auth::user()->can('Documents-W') || 
                            Auth::user()->can('Documents-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-file-earmark-richtext pe-1"></i> {{ __('Documents and templates')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('Reports-R') || 
                            Auth::user()->can('Reports-W') || 
                            Auth::user()->can('Reports-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-graph-up-arrow pe-1"></i> {{ __('Reports')}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if (Auth::check() && 
                        (
                            Auth::user()->can('PPZMainSettings-R') || 
                            Auth::user()->can('PPZMainSettings-W') || 
                            Auth::user()->can('PPZMainSettings-D') || 
                            Auth::user()->can('PPZDictionaries-R') || 
                            Auth::user()->can('PPZDictionaries-W') || 
                            Auth::user()->can('PPZDictionaries-D') || 
                            Auth::user()->can('PPZControlSettings-R') || 
                            Auth::user()->can('PPZControlSettings-W') || 
                            Auth::user()->can('PPZControlSettings-D') || 
                            Auth::user()->can('PPZIntegration-R') || 
                            Auth::user()->can('PPZIntegration-W') || 
                            Auth::user()->can('PPZIntegration-D') 
                        )
                    )
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link nvlss {{ Route::currentRouteName() == '' ? 'nvactive' : '' }} dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-p-circle"></i> {{ __('PPZ Settings')}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><h4 class="dropdown-header pb-3">{{ __('PPZ Settings')}}</h4></li>
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('PPZMainSettings-R') || 
                            Auth::user()->can('PPZMainSettings-W') || 
                            Auth::user()->can('PPZMainSettings-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide-connected pe-1"></i> {{ __('Main settings')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('PPZDictionaries-R') || 
                            Auth::user()->can('PPZDictionaries-W') || 
                            Auth::user()->can('PPZDictionaries-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-journal-text pe-1"></i> {{ __('Dictionaries')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('PPZControlSettings-R') || 
                            Auth::user()->can('PPZControlSettings-W') || 
                            Auth::user()->can('PPZControlSettings-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-phone-vibrate pe-1"></i> {{ __('Control settings')}}</a></li>
                        @endif

                        @if (Auth::check() && 
                        (
                            Auth::user()->can('PPZIntegration-R') || 
                            Auth::user()->can('PPZIntegration-W') || 
                            Auth::user()->can('PPZIntegration-D') 
                        )
                        )
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-cpu pe-1"></i> {{ __('Integration settings')}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminSystemSettings-R') || 
                            Auth::user()->can('AdminSystemSettings-W') || 
                            Auth::user()->can('AdminSystemSettings-D') || 
                            Auth::user()->can('AdminUsers-R') || 
                            Auth::user()->can('AdminUsers-W') || 
                            Auth::user()->can('AdminUsers-D') || 
                            Auth::user()->can('AdminPrivilege-R') || 
                            Auth::user()->can('AdminPrivilege-W') || 
                            Auth::user()->can('AdminPrivilege-D') || 
                            Auth::user()->can('AdminIntegration-R') || 
                            Auth::user()->can('AdminIntegration-W') || 
                            Auth::user()->can('AdminIntegration-D') || 
                            Auth::user()->can('AdminSecurity-R') || 
                            Auth::user()->can('AdminSecurity-W') || 
                            Auth::user()->can('AdminSecurity-D')
                        )
                    )
                <li class="nav-item px-2 dropdown">
                    <a class="nav-link nvlss {{ Request::is('admin*') ? 'nvactive' : '' }} dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-fingerprint"></i> {{ __('Administration')}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><h4 class="dropdown-header pb-3">{{ __('Administration')}}</h4></li>
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminSystemSettings-R') || 
                            Auth::user()->can('AdminSystemSettings-W') || 
                            Auth::user()->can('AdminSystemSettings-D') 
                        )
                        )
                            <li><a class="dropdown-item py-2" href="{{ route('systemsettings.index') }}"><i class="bi bi-sliders2-vertical pe-1"></i> {{ __('System settings')}}</a></li>
                        @endif

                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminUsers-R') || 
                            Auth::user()->can('AdminUsers-W') || 
                            Auth::user()->can('AdminUsers-D') 
                        )
                        )
                            <li><a class="dropdown-item py-2" href="{{ route('users.index') }}"><i class="bi bi-people pe-1"></i> {{ __('Users management')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminPrivilege-R') || 
                            Auth::user()->can('AdminPrivilege-W') || 
                            Auth::user()->can('AdminPrivilege-D') 
                        )
                        )
                            <li><a class="dropdown-item py-2" href="{{ route('permissions.index') }}"><i class="bi bi-file-earmark-lock pe-1"></i> {{ __('Privilege management')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminIntegration-R') || 
                            Auth::user()->can('AdminIntegration-W') || 
                            Auth::user()->can('AdminIntegration-D') 
                        )
                        )
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-cpu pe-1"></i> {{ __('Integration management')}}</a></li>
                        @endif
                        
                        @if (Auth::check() && 
                        (
                            Auth::user()->can('AdminSecurity-R') || 
                            Auth::user()->can('AdminSecurity-W') || 
                            Auth::user()->can('AdminSecurity-D') 
                        )
                        )
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-shield-lock pe-1"></i> {{ __('Security settings')}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif
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
    <script>
        // ENABLE TOOLTIPS
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        // ///
    </script>
</body>
</html>
