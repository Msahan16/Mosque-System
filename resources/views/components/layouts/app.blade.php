<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Mosque Management System') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/mosque.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- Print Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/print-reports.css') }}">
    
    <!-- Stack for additional styles -->
    @stack('styles')
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1e40af",
                        "secondary": "#10b981",
                        "accent": "#0ea5e9",
                        "background-light": "#f0f9ff",
                        "background-dark": "#0c2340",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                        "arabic": ["Amiri", "serif"]
                    },
                },
            },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        * {
            @apply transition-colors duration-200;
        }
        
        body {
            @apply bg-gradient-to-br from-blue-50 via-slate-50 to-white dark:from-slate-950 dark:via-blue-950 dark:to-slate-900;
        }
        
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        /* Hide scrollbar but keep scrolling functionality */
        #sidebar::-webkit-scrollbar {
            display: none;
        }
        #sidebar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* Hide scrollbar for main content area */
        main::-webkit-scrollbar {
            display: none;
        }
        main {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        .mosque-bg {
            background-color: #0a1929;
            background-image: url("{{ asset('images/mqss.jpg') }}");
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        /* Make content containers semi-transparent for background visibility */
        .content-overlay {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .dark .content-overlay {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
        }
        
        /* Hide scrollbar for modals but keep scrolling functionality */
        .overflow-y-auto::-webkit-scrollbar {
            display: none;
        }
        .overflow-y-auto {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    
    @livewireStyles
</head>
<body class="antialiased">
    <div class="flex h-screen bg-white dark:bg-slate-900">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition fixed lg:relative inset-y-0 left-0 z-40 w-64 h-screen lg:h-auto bg-gradient-to-b from-blue-600 to-blue-800 dark:from-blue-900 dark:to-blue-950 shadow-2xl overflow-y-auto -translate-x-full lg:translate-x-0 no-print print-hide">
            <!-- Logo Section -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-900 dark:from-blue-900 dark:to-blue-950 px-6 py-3 border-b border-blue-500">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/masjid-logo.png') }}" alt="Logo" class="h-24 object-contain filter brightness-0 invert">
                </div>
            </div>
            

            <!-- Navigation Menu -->
            <nav class="px-4 py-6 space-y-2">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Navigation -->
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-blue-500 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.mosques') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('admin.mosques') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-medium">Manage Mosques</span>
                        </a>
                    @else
                        <!-- Mosque User Navigation -->
                        @php
                            $user = Auth::user();
                            $canAccess = function($permission) use ($user) {
                                // Mosque admins have all access
                                if ($user->role === 'mosque') {
                                    return true;
                                }
                                // Staff members can only access pages they have permission for
                                if ($user->role === 'staff') {
                                    return $user->hasPermission($permission);
                                }
                                return false;
                            };
                        @endphp
                        
                        @if($canAccess('dashboard'))
                        <a href="{{ route('mosque.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-blue-500 {{ request()->routeIs('mosque.dashboard') ? 'bg-blue-500 shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        @endif
                        
                        @if($canAccess('families'))
                        <a href="{{ route('mosque.families') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.families') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="font-medium">Families</span>
                        </a>
                        @endif
                        
                        @if($canAccess('santha'))
                        <a href="{{ route('mosque.santhas') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.santhas') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Santha Collection</span>
                        </a>
                        @endif
                        
                        @if($canAccess('donations'))
                        <a href="{{ route('mosque.donations') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.donations') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Donations</span>
                        </a>
                        @endif
                        
                        @if($canAccess('baithulmal'))
                        <a href="{{ route('mosque.baithulmal') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.baithulmal') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="font-medium">Baithulmal</span>
                        </a>
                        @endif
                        
                        @if($canAccess('prayer_schedule'))
                        <a href="{{ route('mosque.islamic-calendar') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.islamic-calendar') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">Islamic Calendar</span>
                        </a>
                        @endif
                        
                        @if($canAccess('students'))
                        <a href="{{ route('mosque.madrasa') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.madrasa') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="font-medium">Madrasa</span>
                        </a>
                        @endif
                        
                        @if($canAccess('porridge'))
                        <a href="{{ route('mosque.ramadan-porridge') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.ramadan-porridge') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-medium">Ramadan Porridge</span>
                        </a>
                        @endif
                        
                        @if($canAccess('imam'))
                        <a href="{{ route('mosque.imam-management') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.imam-management') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-medium">Imam Management</span>
                        </a>
                        @endif
                        
                        @if($canAccess('documents'))
                        <a href="{{ route('mosque.documents') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.documents') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Documents</span>
                        </a>
                        @endif
                        
                        @if($canAccess('reports'))
                        <a href="{{ route('mosque.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.reports') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Reports</span>
                        </a>
                        @endif
                        
                        @if($canAccess('board'))
                        <a href="{{ route('mosque.staff-management') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.staff-management') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="font-medium">Mosque Board</span>
                        </a>
                        @endif

                        @if($canAccess('settings'))
                        <a href="{{ route('mosque.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white {{ request()->routeIs('mosque.settings') ? 'bg-blue-500 text-white shadow-lg' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Settings</span>
                        </a>
                        @endif
                    @endif
                @endauth
            </nav>

            <!-- Divider -->
            <div class="border-t border-blue-500 mx-4"></div>

            <!-- User Section -->
            <div class="px-4 py-6 space-y-2">
                @auth
                    <div class="px-4 py-3 bg-blue-500 rounded-lg text-white mb-4">
                        <p class="text-xs text-blue-100">Logged in as</p>
                        <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                        @php
                            $user = auth()->user();
                            $roleName = ucfirst($user->role);
                            if ($user->role === 'staff' && $user->board_role) {
                                $roleName = match($user->board_role) {
                                    'president' => 'Head (President)',
                                    'secretary' => 'Secretary',
                                    'treasurer' => 'Treasurer',
                                    default => 'Board Member'
                                };
                            }
                        @endphp
                        <p class="text-xs text-blue-100 mt-1">{{ $roleName }}</p>
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white transition-all duration-300">
                        <div id="theme-icon-container" class="transition-transform duration-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="theme-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <span id="theme-text" class="font-medium">Dark Mode</span>
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-red-600 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                @endauth
                
                @auth('staff')
                    <div class="px-4 py-3 bg-blue-500 rounded-lg text-white mb-4">
                        <p class="text-xs text-blue-100">Logged in as Staff</p>
                        <p class="font-semibold truncate">{{ auth('staff')->user()->name }}</p>
                        @php
                            $user = auth('staff')->user();
                            $roleName = ucfirst($user->role);
                            if ($user->role === 'staff' && $user->board_role) {
                                $roleName = match($user->board_role) {
                                    'president' => 'Head (President)',
                                    'secretary' => 'Secretary',
                                    'treasurer' => 'Treasurer',
                                    default => 'Board Member'
                                };
                            }
                        @endphp
                        <p class="text-xs text-blue-100 mt-1">{{ $roleName }}</p>
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-500 hover:text-white transition-all duration-300">
                        <div id="staff-theme-icon-container" class="transition-transform duration-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="staff-theme-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <span id="staff-theme-text" class="font-medium">Dark Mode</span>
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-red-600 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <!-- Overlay for Mobile -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden no-print print-hide" onclick="toggleSidebar()"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden mosque-bg">
            <!-- Mobile Menu Toggle -->
            <div class="lg:hidden bg-blue-600 text-white p-4 flex items-center justify-between shadow-lg no-print print-hide">
                <button onclick="toggleSidebar()" class="p-2 hover:bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex-1 text-center">
                    <h1 class="text-lg font-bold">Mosque System</h1>
                </div>
                <div class="w-6"></div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto">
                <div class="h-full w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeUI(isDark);
        }

        function updateThemeUI(isDark) {
            const textElements = [document.getElementById('theme-text'), document.getElementById('staff-theme-text')];
            const iconPaths = [document.getElementById('theme-icon-path'), document.getElementById('staff-theme-icon-path')];
            const containers = [document.getElementById('theme-icon-container'), document.getElementById('staff-theme-icon-container')];

            const moonPath = "M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z";
            const sunPath = "M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z";

            textElements.forEach(el => { if (el) el.textContent = isDark ? 'Light Mode' : 'Dark Mode'; });
            iconPaths.forEach(path => { if (path) path.setAttribute('d', isDark ? sunPath : moonPath); });
            containers.forEach(container => { 
                if (container) {
                    container.style.transform = isDark ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            });
        }

        // Initialize dark mode
        const initialDark = localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (initialDark) {
            document.documentElement.classList.add('dark');
        }
        // Use DOMContentLoaded to ensure elements are available
        document.addEventListener('DOMContentLoaded', () => {
            updateThemeUI(initialDark);
        });

        // Generic confirm helper that shows SweetAlert and dispatches Livewire events
        function confirmDelete(eventName, id, title = 'Are you sure?', text = 'This action cannot be undone.') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.Livewire.dispatch(eventName, [id]);
                }
            });
        }

        // Livewire hook for dispatched events
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    title: event.title || 'Success!',
                    text: event.text || 'Operation completed successfully.',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            Livewire.on('swal:error', (event) => {
                Swal.fire({
                    title: event.title || 'Error!',
                    text: event.text || 'Something went wrong.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK',
                });
            });

            Livewire.on('swal:confirm', (event) => {
                Swal.fire({
                    title: event.title || 'Confirm',
                    text: event.text || 'Are you sure?',
                    icon: event.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: event.confirmButtonText || 'Confirm',
                    cancelButtonText: event.cancelButtonText || 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(event.eventName, event.eventParams || []);
                    }
                });
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
</body>
</html>
