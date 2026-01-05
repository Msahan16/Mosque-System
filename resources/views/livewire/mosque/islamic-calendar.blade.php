<div class="py-6 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800" style="margin-left: 0 !important;">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Islamic Calendar</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Prayer times, Azan schedule & Islamic dates for {{ $mosque->name }}</p>
            </div>
            <a href="{{ route('mosque.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <!-- Current Date & Hijri Date Card -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Gregorian Date -->
                <div class="text-center">
                    <p class="text-emerald-100 text-sm font-medium mb-2">Gregorian Date</p>
                    <p class="text-3xl font-bold">{{ \Carbon\Carbon::now($timezone)->format('d M Y') }}</p>
                    <p class="text-emerald-100 text-sm mt-1">{{ \Carbon\Carbon::now($timezone)->format('l') }}</p>
                </div>

                <!-- Current Time -->
                <div class="text-center">
                    <p class="text-emerald-100 text-sm font-medium mb-2">Current Time</p>
                    <p class="text-3xl font-bold font-mono" wire:poll="getCurrentTime">{{ $currentTime }}</p>
                    <p class="text-emerald-100 text-sm mt-1">{{ $timezone }}</p>
                </div>

                <!-- Hijri Date -->
                <div class="text-center">
                    <p class="text-emerald-100 text-sm font-medium mb-2">Islamic Date</p>
                    <p class="text-2xl font-bold">{{ $hijriDate ?? 'Loading...' }}</p>
                    <p class="text-emerald-100 text-sm mt-1">Hijri Calendar</p>
                </div>
            </div>
        </div>

        <!-- Next Prayer Card - Modern Design -->
        @if($nextPrayer)
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 dark:from-slate-950 dark:via-blue-950 dark:to-slate-950 rounded-2xl shadow-lg p-4 mb-4 border border-blue-500/20">
                <!-- Content -->
                <div class="relative z-10">
                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-3 pb-3 border-b border-white/10">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-2xl shadow-lg">
                            {{ $nextPrayer['emoji'] }}
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs font-medium uppercase tracking-wide mb-0.5">Next Prayer</p>
                            <h2 class="text-2xl font-bold text-white">{{ $nextPrayer['name'] }}</h2>
                        </div>
                    </div>
                    
                    <!-- Time Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Azan Time Card -->
                        <div class="relative bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                <p class="text-blue-200 text-sm font-bold uppercase tracking-wide">Azan</p>
                            </div>
                            
                            <p class="text-4xl font-bold text-white font-mono mb-3">{{ $nextPrayer['time'] }}</p>
                            
                            <div class="flex items-start gap-2 bg-black/20 rounded-lg p-2 border border-white/5">
                                <svg class="w-4 h-4 text-blue-300 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-3xl font-bold text-blue-50 font-mono" wire:poll="updateRemainingTime">{{ $remainingTime }}</p>
                                    <p class="text-xs text-blue-200/70 uppercase tracking-wide">Remaining</p>
                                </div>
                            </div>
                        </div>

                        <!-- Iqamah Time Card -->
                        @if($nextPrayer['iqamah_time'])
                        <div class="relative bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                <p class="text-emerald-200 text-sm font-bold uppercase tracking-wide">Iqamah</p>
                            </div>
                            
                            <p class="text-4xl font-bold text-white font-mono mb-3">{{ $nextPrayer['iqamah_time'] }}</p>
                            
                            <div class="flex items-start gap-2 bg-black/20 rounded-lg p-2 border border-white/5">
                                <svg class="w-4 h-4 text-emerald-300 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-3xl font-bold text-emerald-50 font-mono" wire:poll="updateRemainingTime">{{ $iqamahRemainingTime }}</p>
                                    <p class="text-xs text-emerald-200/70 uppercase tracking-wide">Remaining</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Prayer Times Schedule -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden mb-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Prayer Times Schedule</h3>
                        <p class="text-blue-100 text-sm mt-1">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $selectedDate, $timezone)->format('l, d F Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="changeDate(-1)" class="p-2 hover:bg-blue-700 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button wire:click="goToToday" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 rounded-lg text-sm font-medium transition">
                            Today
                        </button>
                        <button wire:click="changeDate(1)" class="p-2 hover:bg-blue-700 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Prayer Times Grid -->
            <div class="p-6">
                @if($loadingPrayers)
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-12 h-12 text-blue-600 animate-spin mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Loading prayer times...</p>
                    </div>
                @elseif($apiError)
                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-600 rounded-lg p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-red-800 dark:text-red-200 font-semibold">{{ $apiError }}</p>
                                <button wire:click="retryLoadPrayers" class="mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition duration-200">
                                    Retry
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($prayerSchedule)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Fajr -->
                        <div class="bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-xl p-6 border-l-4 border-purple-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Fajr (Dawn)</h4>
                                <span class="text-3xl">🌙</span>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Azan</p>
                                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 font-mono">{{ $prayerSchedule->fajr }}</p>
                                </div>
                                @if($prayerSchedule->fajr_iqamah)
                                <div class="pt-2 border-t border-purple-200 dark:border-purple-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Iqamah</p>
                                    <p class="text-2xl font-semibold text-purple-700 dark:text-purple-300 font-mono">{{ $prayerSchedule->fajr_iqamah }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">Pre-dawn prayer</p>
                        </div>

                        <!-- Sunrise -->
                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-xl p-6 border-l-4 border-orange-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Sunrise</h4>
                                <span class="text-3xl">🌅</span>
                            </div>
                            <p class="text-4xl font-bold text-orange-600 dark:text-orange-400 font-mono">{{ $prayerSchedule->sunrise }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Sun rises above horizon</p>
                        </div>

                        <!-- Dhuhr -->
                        <div class="bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-xl p-6 border-l-4 border-yellow-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Dhuhr (Noon)</h4>
                                <span class="text-3xl">☀️</span>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Azan</p>
                                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 font-mono">{{ $prayerSchedule->dhuhr }}</p>
                                </div>
                                @if($prayerSchedule->dhuhr_iqamah)
                                <div class="pt-2 border-t border-yellow-200 dark:border-yellow-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Iqamah</p>
                                    <p class="text-2xl font-semibold text-yellow-700 dark:text-yellow-300 font-mono">{{ $prayerSchedule->dhuhr_iqamah }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">Midday prayer</p>
                        </div>

                        <!-- Asr -->
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-6 border-l-4 border-amber-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Asr (Afternoon)</h4>
                                <span class="text-3xl">🌤️</span>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Azan</p>
                                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 font-mono">{{ $prayerSchedule->asr }}</p>
                                </div>
                                @if($prayerSchedule->asr_iqamah)
                                <div class="pt-2 border-t border-amber-200 dark:border-amber-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Iqamah</p>
                                    <p class="text-2xl font-semibold text-amber-700 dark:text-amber-300 font-mono">{{ $prayerSchedule->asr_iqamah }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">Afternoon prayer</p>
                        </div>

                        <!-- Maghrib -->
                        <div class="bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-6 border-l-4 border-orange-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Maghrib (Sunset)</h4>
                                <span class="text-3xl">🌆</span>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Azan</p>
                                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 font-mono">{{ $prayerSchedule->maghrib }}</p>
                                </div>
                                @if($prayerSchedule->maghrib_iqamah)
                                <div class="pt-2 border-t border-orange-200 dark:border-orange-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Iqamah</p>
                                    <p class="text-2xl font-semibold text-orange-700 dark:text-orange-300 font-mono">{{ $prayerSchedule->maghrib_iqamah }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">Sunset prayer</p>
                        </div>

                        <!-- Isha -->
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-xl p-6 border-l-4 border-indigo-600">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Isha (Night)</h4>
                                <span class="text-3xl">🌃</span>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Azan</p>
                                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 font-mono">{{ $prayerSchedule->isha }}</p>
                                </div>
                                @if($prayerSchedule->isha_iqamah)
                                <div class="pt-2 border-t border-indigo-200 dark:border-indigo-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Iqamah</p>
                                    <p class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300 font-mono">{{ $prayerSchedule->isha_iqamah }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">Evening prayer</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-600 dark:text-gray-400">No prayer times available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Important Islamic Dates Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden mb-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 text-white px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="text-2xl font-bold">Important Islamic Dates & Events</h3>
                </div>
            </div>

            <!-- Important Dates Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($importantDates as $event)
                        <div class="rounded-lg p-4 border-l-4 
                            @if($event['color'] === 'blue') border-blue-500 bg-blue-50 dark:bg-blue-900/20
                            @elseif($event['color'] === 'purple') border-purple-500 bg-purple-50 dark:bg-purple-900/20
                            @elseif($event['color'] === 'green') border-green-500 bg-green-50 dark:bg-green-900/20
                            @elseif($event['color'] === 'indigo') border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20
                            @elseif($event['color'] === 'yellow') border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20
                            @elseif($event['color'] === 'teal') border-teal-500 bg-teal-50 dark:bg-teal-900/20
                            @elseif($event['color'] === 'red') border-red-500 bg-red-50 dark:bg-red-900/20
                            @endif
                        ">
                            <div class="flex items-start gap-3">
                                <span class="text-3xl">{{ $event['emoji'] }}</span>
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-gray-600 dark:text-gray-400">{{ $event['date'] }}</p>
                                    <p class="font-semibold text-gray-900 dark:text-white text-base">{{ $event['event'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Mosque Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Mosque Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Mosque</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $mosque->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Timezone</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $timezone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Calculation Method</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Karachi Method (Sri Lanka)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Data Source</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Aladhan API</p>
                    </div>
                </div>
            </div>

            <!-- Prayer Guide -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">About Prayer Times</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p>✦ <strong>Fajr:</strong> Begin 2 hours before sunrise, ends at sunrise</p>
                    <p>✦ <strong>Dhuhr:</strong> Begins when sun passes zenith (midday)</p>
                    <p>✦ <strong>Asr:</strong> Begins in afternoon, ends at sunset</p>
                    <p>✦ <strong>Maghrib:</strong> Begins at sunset, lasts about 1-1.5 hours</p>
                    <p>✦ <strong>Isha:</strong> Begins after twilight, ends at midnight</p>
                    <p class="pt-2">Times are calculated based on your location and timezone.</p>
                </div>
            </div>
        </div>

        <style>
            [wire\:poll] {
                transition: color 0.3s ease;
            }
            
            /* Hide sidebar and overlay for full page view */
            #sidebar, #sidebar-overlay {
                display: none !important;
            }
            
            /* Adjust main content to full width */
            .flex-1.flex.flex-col.overflow-hidden.mosque-bg {
                margin-left: 0 !important;
            }
        </style>
    </div>
</div>