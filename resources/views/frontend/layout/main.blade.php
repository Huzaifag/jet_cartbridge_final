<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jet Cartridge - {{ $title ?? 'Premium B2B Marketplace' }}</title>

    <!-- Inline Theme Script - Prevents Flash of Unstyled Content -->
    <script>
        (function() {
            // Get stored theme or system preference immediately
            const storedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = storedTheme || systemTheme;
            
            // Apply theme immediately before page renders
            document.documentElement.setAttribute('data-theme', theme);
            
            // Prevent flash by hiding body until theme is applied
            document.documentElement.style.visibility = 'visible';
        })();
    </script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light-theme.css') }}">
    
    <style>
        /* Prevent flash of unstyled content */
        html:not([data-theme]) {
            visibility: hidden;
        }
        
        html[data-theme] {
            visibility: visible;
        }
        
        /* Smooth theme transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        /* Disable transitions on page load */
        .preload * {
            transition: none !important;
        }
    </style>
</head>

<body class="preload">

    @include('components.header')
    @include('components.toast')

    <main>
      @yield('content')
    </main>

    @include('components.footer')


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Premium Theme JavaScript -->
    <script src="{{ asset('js/premium-theme.js') }}"></script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
</body>

</html>
