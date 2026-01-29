<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Atelier Véridique')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @stack('styles')
    <style>
        /* Common CSS variables */
        :root {
            --primary-dark: #2C2416;
            --primary-light: #FEFDF8;
            --accent-gold: #D4AF77;
            --accent-tan: #8B7355;
            --neutral-light: #F5F2EA;
            --neutral-medium: #5A4A3A;
            --border-light: rgba(139, 115, 85, 0.15);
            --border-medium: rgba(139, 115, 85, 0.3);
            --success-green: #4A7C59;
            --success-light: rgba(74, 124, 89, 0.1);
        }
    </style>
</head>
<body>
    @yield('content')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>