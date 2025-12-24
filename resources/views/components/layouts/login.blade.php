<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login - Mosque Management System' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/mosque.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                        "arabic": ["Amiri", "serif"]
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            @apply bg-gradient-to-br from-blue-50 via-slate-50 to-white dark:from-slate-950 dark:via-blue-950 dark:to-slate-900;
        }
    </style>
    
    @livewireStyles
</head>
<body class="antialiased">
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
