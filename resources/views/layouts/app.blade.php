<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Medical Clinic')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- CSRF Token for Livewire -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Stack for additional styles -->
    @stack('styles')
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1a9b8e",
                        "secondary": "#7bc143",
                        "accent": "#6cb33f",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }
        
        body {
            min-height: max(884px, 100dvh);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Mobile-first touch improvements */
        * {
            -webkit-tap-highlight-color: rgba(26, 155, 142, 0.1);
        }

        input, textarea, button, select {
            font-size: 16px !important; /* Prevent iOS zoom on focus */
        }

        @media (min-width: 640px) {
            input, textarea, select {
                font-size: 0.875rem !important;
            }
        }
    </style>
    
    <!-- Livewire Styles (will be loaded if Livewire exists) -->
    @if(class_exists(\Livewire\Livewire::class))
        @livewireStyles
    @endif
</head>
<body class="font-display">
    @yield('content')
    
    <!-- Livewire Scripts (will be loaded if Livewire exists) -->
    @if(class_exists(\Livewire\Livewire::class))
        @livewireScripts
    @endif
    
    <!-- Dark Mode Script -->
    <script>
        // Check for saved theme preference, default to light mode
        if (localStorage.getItem('color-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
            // Set light mode as default if no preference exists
            if (!localStorage.getItem('color-theme')) {
                localStorage.setItem('color-theme', 'light');
            }
        }
        
        // Toggle dark mode function
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>