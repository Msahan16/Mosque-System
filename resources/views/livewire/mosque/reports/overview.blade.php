{{-- Overview Report --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Total Families --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-blue-100 text-sm font-medium mb-1">Total Families</p>
        <p class="text-4xl font-bold">{{ number_format($reportData['total_families'] ?? 0) }}</p>
        <p class="text-blue-100 text-xs mt-2">+{{ number_format($reportData['new_families'] ?? 0) }} new this period</p>
    </div>

    {{-- Total Members --}}
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-emerald-100 text-sm font-medium mb-1">Total Members</p>
        <p class="text-4xl font-bold">{{ number_format($reportData['total_members'] ?? 0) }}</p>
        <p class="text-emerald-100 text-xs mt-2">Community size</p>
    </div>

    {{-- Total Donations --}}
    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-cyan-100 text-sm font-medium mb-1">Total Donations</p>
        <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_donations'] ?? 0) }}</p>
        <p class="text-cyan-100 text-xs mt-2">This period</p>
    </div>

    {{-- Santha Payments --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-purple-100 text-sm font-medium mb-1">Santha Paid</p>
        <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_santhas_paid'] ?? 0) }}</p>
        <p class="text-purple-100 text-xs mt-2">This period</p>
    </div>
</div>

{{-- Additional Stats --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    {{-- Students & Ustads --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 border border-slate-200 dark:border-slate-700">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Madrasa Overview
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Total Students</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($reportData['total_students'] ?? 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Active Ustads</p>
                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($reportData['active_ustads'] ?? 0) }}</p>
            </div>
        </div>
    </div>

    {{-- Date Range Info --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 border border-slate-200 dark:border-slate-700">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Report Period
        </h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">From:</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">To:</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Duration:</span>
                <span class="text-sm font-bold text-blue-900 dark:text-blue-300">{{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} days</span>
            </div>
        </div>
    </div>
</div>
