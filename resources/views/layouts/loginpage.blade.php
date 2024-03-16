<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ config('app.title', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/styles.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&family=Vina+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="sss-login-page">
    <div id="app">
        

        <section class="h-100">
            @yield('content')
        </section>
    </div>

    <footer>
    <p>© {{ date('Y') }}. {{ __('All rights reserved for Sonija Dev Cloud') }}.</p>
    <p>{{ __('version') }} {{ config('app.version') }}</p>
    </footer>
    @if(!request()->cookie('cookie_accepted'))
    <div class="cookie-consent">
        <div class="cookiesbox shadow-sm">
                <div class="card-header mb-4">
                    <h1><i class="bi bi-p-square-fill sonijaicon"></i><i class="bi bi-cookie ms-2"></i></h1>
                </div>
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center fw-bolder">{{ __('Before you start working at Sonija Simple Select') }}</h2>
                    <span class="card-text fw-bold lh-2 fs-5">We use <a href="https://www.kaspersky.com/resource-center/definitions/cookies" target="_blank">cookies</a> and other data to:</span><br>
                    <span class="card-text ps-3"><i class="bi bi-database-fill-up"></i> Provide and maintain Sonija Dev Cloud services</span><br>
                    <span class="card-text ps-3"><i class="bi bi-shield-check"></i> Track service interruptions and protect users from spam, fraud and abuse</span><br>
                    <span class="card-text text-break ps-3"><i class="bi bi-bar-chart-line-fill"></i> Measure audience engagement and generate site statistics to better understand how our services are used and to improve the quality of our services</span><br>
                    <p class="card-text my-4 mb-2 fw-bold lh-2 fs-5">If you select "Accept all", we will also use cookies and other data to:</p>
                    <span class="card-text ps-3"><i class="bi bi-braces-asterisk"></i> Developing and improving new services</span><br>
                    <span class="card-text ps-3"><i class="bi bi-bug-fill"></i> Log problems when using the application</span><br>
                    <p class="card-text mt-4 lh-1">If you select "Reject all", the application may become difficult to use or may close automatically.</p>
                    <p class="card-text lh-1">To view additional information, including details on how to manage your privacy settings, please go to our privacy policy or contact us at <a href="https://sonija.cloud" target="_blank">https://sonija.cloud</a></p>
                    <p class="card-text"></p>
                </div>
                <div class="card-footer mt-5 text-center">
                    <a href="#" id="sonijacdiscardAll" class="btn btn-danger mx-2">{{ __('Discard all') }}</a>
                    <a href="#" id="sonijacacceptAll" class="btn btn-primary mx-2">{{ __('Accept all') }}</a><br><br>
                    <a href="https://sonija.cloud/privacy/" target="_blank" id="cookiespolicylink" class="mt-2 text-center text-secondary">{{ __('privacy policy') }}</a>
                </div>
        </div>
    </div>
    @endif
    <script>
        // ENABLE TOOLTIPS
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        // ///
    </script>
    <script>
        // Pobierz przyciski za pomocą ich identyfikatorów
const acceptAllBtn = document.getElementById('sonijacacceptAll');
const discardAllBtn = document.getElementById('sonijacdiscardAll');

// Obsługa kliknięcia przycisku "Accept all"
acceptAllBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Zapobiegamy domyślnej akcji przycisku

    // Wyślij żądanie POST do akcji /cookie-consent/accept
    fetch('/cookie-consent/accept', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Przekazujemy token CSRF
        }
    }).then(response => {
        // Sprawdzamy, czy odpowiedź jest poprawna
        if (response.ok) {
            // Jeśli tak, odświeżamy stronę
            window.location.reload();
        } else {
            console.error('Failed to accept cookies.');
        }
    }).catch(error => {
        console.error('Error occurred while accepting cookies:', error);
    });
});

// Obsługa kliknięcia przycisku "Discard all"
discardAllBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Zapobiegamy domyślnej akcji przycisku

    // Zamykamy bieżącą kartę przeglądarki
    window.location.href = 'https://sonija.cloud';
});
</script>
</body>
</html>
