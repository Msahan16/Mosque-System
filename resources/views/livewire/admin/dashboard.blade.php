<div class="bg-gradient-to-br from-blue-50 via-slate-50 to-emerald-50 dark:from-slate-900 dark:via-blue-900 dark:to-slate-900 min-h-screen">
    <!-- Mosque Background Header -->
    <div class="mosque-bg h-48 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/70 to-transparent dark:from-blue-900/70"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white z-10">
                <h2 class="text-4xl font-bold mb-2">Welcome to Admin Panel</h2>
                <p class="text-blue-100">Manage all mosque operations and data</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 py-8 -mt-16 relative z-10">
        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Mosques Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-blue-600">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Active</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Total Mosques</p>
                <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $mosqueCount }}</p>
            </div>

            <!-- Families Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-emerald-600">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Growing</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Registered Families</p>
                <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ $familyCount }}</p>
            </div>

            <!-- Donations Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-cyan-600">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-cyan-100 dark:bg-cyan-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">↑ 12%</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Total Donations</p>
                <p class="text-4xl font-bold text-cyan-600 dark:text-cyan-400">₹{{ number_format($donationTotal, 0) }}</p>
            </div>

            <!-- Santhas Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-purple-600">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Regular</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Santha Payments</p>
                <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $santhaCount }}</p>
            </div>
        </div>

        <!-- Recent Mosques Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-emerald-600 px-8 py-6">
                <h3 class="text-2xl font-bold text-white">Recent Mosques</h3>
                <p class="text-blue-100 text-sm mt-1">Latest registered mosques in the system</p>
            </div>

            <div class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($recentMosques as $mosque)
                    <div class="px-8 py-6 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-md">
                                @if($mosque->logo)
                                    <img src="{{ Storage::url($mosque->logo) }}" alt="{{ $mosque->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('images/mosque.png') }}" alt="Mosque" class="w-8 h-8 object-contain">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $mosque->name }}</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $mosque->city }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $mosque->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' }}">
                            {{ $mosque->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                @empty
                    <div class="px-8 py-12 text-center text-slate-500 dark:text-slate-400">
                        <p>No mosques registered yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
        <!-- Header -->
        <div class="flex items-center bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg p-4 pb-2 justify-between sticky top-0 z-10">
            <div class="flex size-12 shrink-0 items-center justify-start">
                <button @click="$dispatch('toggle-menu')" class="p-2 rounded-full hover:bg-white/10 text-white">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
            <h2 class="text-base sm:text-lg font-bold leading-tight tracking-tight text-white flex-1 text-center flex items-center justify-center gap-2">
                <img src="{{ asset('images/mosque.png') }}" alt="Mosque Logo" class="w-8 h-8 object-contain">
                Admin Dashboard
            </h2>
            <div class="flex w-auto items-center justify-end">
                <button onclick="toggleDarkMode()" class="text-white hover:bg-white/10 p-2 rounded-full">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 gap-4 p-4">
            <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-700 shadow-lg">
                <p class="text-sm font-medium text-gray-600 dark:text-emerald-200">Mosques</p>
                <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-300">{{ $mosqueCount }}</p>
            </div>
            <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-emerald-900/50 border border-blue-200 dark:border-blue-700 shadow-lg">
                <p class="text-sm font-medium text-gray-600 dark:text-blue-200">Families</p>
                <p class="text-3xl font-bold tracking-tight text-blue-600 dark:text-blue-300">{{ $familyCount }}</p>
            </div>
            <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-emerald-900/50 border border-amber-200 dark:border-amber-700 shadow-lg">
                <p class="text-sm font-medium text-gray-600 dark:text-amber-200">Donations</p>
                <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-300">₹{{ number_format($donationTotal, 0) }}</p>
            </div>
            <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-emerald-900/50 border border-purple-200 dark:border-purple-700 shadow-lg">
                <p class="text-sm font-medium text-gray-600 dark:text-purple-200">Santhas</p>
                <p class="text-3xl font-bold tracking-tight text-purple-600 dark:text-purple-300">{{ $santhaCount }}</p>
            </div>
        </div>

        <!-- Recent Mosques -->
        <div class="px-4 pb-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-emerald-900 dark:text-emerald-100 text-base sm:text-lg font-bold leading-tight tracking-[-0.015em]">Recent Mosques</h3>
                <a href="{{ route('admin.mosques') }}" class="text-sm text-emerald-600 dark:text-emerald-300 hover:underline">View All</a>
            </div>

            <div class="flex flex-col space-y-2 pb-28">
                @forelse($recentMosques as $mosque)
                    <div class="flex items-center gap-4 bg-white dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-700 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-600/10 dark:bg-emerald-500/20">
                            <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path href="{{ asset('images/mosque.png') }}"/>
                            </svg>
                        </div>
                        <div class="flex flex-col justify-center flex-1 min-w-0">
                            <p class="text-emerald-900 dark:text-emerald-100 text-base font-medium leading-normal truncate">{{ $mosque->name }}</p>
                            @if($mosque->arabic_name)
                                <p class="text-emerald-700 dark:text-emerald-300 text-sm font-arabic truncate">{{ $mosque->arabic_name }}</p>
                            @endif
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-normal">
                                {{ $mosque->city }}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $mosque->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300' }}">
                                {{ $mosque->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 bg-white dark:bg-emerald-900/50 rounded-xl border border-emerald-200 dark:border-emerald-700 shadow-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path href="{{ asset('images/mosque.png') }}"/>
                        </svg>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">No mosques registered yet</p>
                        <a href="{{ route('admin.mosques') }}" class="mt-3 inline-block px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Register First Mosque
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>