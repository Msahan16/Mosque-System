<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Ramadan Porridge Distribution</h2>
                <p class="text-white/80 mt-1 text-sm sm:text-base">Track daily porridge sponsorship and distribution</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative group">
                    <select wire:model.live="ramadanYear" 
                        class="appearance-none pl-4 pr-10 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all cursor-pointer hover:bg-white/20 shadow-lg">
                        @for($year = 2024; $year <= 2030; $year++)
                            <option value="{{ $year }}" class="text-gray-900">{{ $year }} Ramadan</option>
                        @endfor
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/60 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <button wire:click="openModal" 
                    class="group relative inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-bold rounded-xl transition-all duration-300 shadow-[0_10px_20px_-10px_rgba(16,185,129,0.5)] hover:shadow-[0_15px_25px_-10px_rgba(16,185,129,0.6)] hover:-translate-y-0.5 active:translate-y-0 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Sponsor</span>
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-100 text-sm font-medium">Total Sponsors</span>
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $totalSponsors }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-green-100 text-sm font-medium">Total Porridges</span>
                    <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalPorridges) }}</p>                <p class="text-xs text-green-200 mt-1">1 per day</p>            </div>

            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-100 text-sm font-medium">Total Amount</span>
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">LKR {{ number_format($totalAmount, 2) }}</p>
                <p class="text-xs text-blue-200 mt-1">Paid: LKR {{ number_format($paidAmount, 2) }}</p>
            </div>

            <div class="bg-gradient-to-br from-blue-700 to-blue-900 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-100 text-sm font-medium">Distributed</span>
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($distributedCount) }}</p>
                <p class="text-xs text-blue-200 mt-1">of {{ number_format($totalPorridges) }} total</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-8 overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
        <div class="flex p-1.5 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/10 w-fit min-w-max">
            <button wire:click="setActiveTab('overview')"
                class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'overview' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Overview
            </button>
            <button wire:click="setActiveTab('sponsors')"
                class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'sponsors' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Sponsors
            </button>
        </div>
    </div>

    <!-- Overview Tab -->
    @if($activeTab === 'overview')
        <div class="space-y-6">
            <!-- 30-Day Calendar -->
            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Ramadan {{ $ramadanYear }} - 30 Days Porridge Distribution</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Click on any day to add sponsors or view details</p>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                        @for($day = 1; $day <= 30; $day++)
                            <div class="relative group">
                                @if($daySummary[$day]['is_budget_full'])
                                    <div class="w-full p-4 rounded-2xl border-2 border-emerald-500 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/20 dark:to-gray-800 shadow-md {{ $daySummary[$day]['is_distributed'] ? 'ring-2 ring-green-400' : '' }}">
                                        <div class="text-center">
                                            <div class="text-2xl font-black text-gray-900 dark:text-white mb-1">Day {{ $day }}</div>
                                            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter mb-2">
                                                Budget Full
                                            </div>
                                            <div class="text-[10px] text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">
                                                LKR {{ number_format($daySummary[$day]['daily_budget'], 0) }} • {{ $daySummary[$day]['sponsors_count'] }} sponsors
                                            </div>
                                            @if($daySummary[$day]['is_distributed'])
                                                <div class="mt-2 text-center">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-bold bg-green-500 text-white rounded-lg shadow-sm">
                                                        DISTRIBUTED
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2 text-center">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-bold bg-blue-500 text-white rounded-lg shadow-sm">
                                                        SPONSORED
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <button wire:click="openModal({{ $day }})"
                                            class="w-full p-4 rounded-2xl border-2 transition-all duration-300 hover:scale-[1.03] hover:shadow-xl text-center
                                                   {{ $daySummary[$day]['total_porridges'] > 0 
                                                      ? 'border-emerald-400 bg-gradient-to-br from- emerald-50/50 to-white dark:from-emerald-900/10 dark:to-gray-800' 
                                                      : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-400' }}
                                                   {{ $daySummary[$day]['is_distributed'] ? 'ring-2 ring-green-400' : '' }}">
                                        <div class="text-2xl font-black text-gray-900 dark:text-white mb-1">Day {{ $day }}</div>
                                        @if($daySummary[$day]['total_porridges'] > 0)
                                            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter mb-1">
                                                Collected: LKR {{ number_format($daySummary[$day]['total_amount'], 0) }}
                                            </div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400 font-bold">
                                                Need: LKR {{ number_format($daySummary[$day]['remaining_budget'], 0) }}
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400 dark:text-gray-500 font-medium">Available for sponsorship</div>
                                            <div class="mt-2 inline-flex items-center text-[10px] font-bold text-blue-500 uppercase tracking-wider group-hover:translate-x-1 transition-transform">
                                                Sponsor Now →
                                            </div>
                                        @endif
                                    </button>
                                @endif

                                @if($daySummary[$day]['sponsors_count'] > 0)
                                    <div class="mt-2 space-y-1">
                                        @foreach($daySummary[$day]['sponsors'] as $sponsor)
                                            <div class="text-[10px] bg-gray-100 dark:bg-gray-700/50 backdrop-blur-sm border border-gray-200 dark:border-gray-600 rounded-lg p-2 shadow-sm">
                                                <div class="font-bold text-gray-800 dark:text-gray-200 truncate">{{ $sponsor->sponsor_name }}</div>
                                                <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 mt-0.5">
                                                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">LKR {{ number_format($sponsor->total_amount, 0) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Sponsors Tab -->
    @if($activeTab === 'sponsors')
        <!-- Search and Filters -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search sponsors..."
                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select wire:model.live="selectedDay" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white">
                    <option value="">All Days</option>
                    @for($day = 1; $day <= 30; $day++)
                        <option value="{{ $day }}">Day {{ $day }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Sponsors Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Sponsor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Distribution</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($sponsors as $sponsor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                        Day {{ $sponsor->day_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $sponsor->sponsor_name ? strtoupper(substr($sponsor->sponsor_name, 0, 1)) : 'A' }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $sponsor->display_name }}</div>
                                            @if($sponsor->sponsor_phone)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $sponsor->sponsor_phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $sponsor->sponsor_type === 'group' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                        {{ ucfirst($sponsor->sponsor_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">LKR {{ number_format($sponsor->total_amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($sponsor->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($sponsor->payment_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ ucfirst($sponsor->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($sponsor->distribution_status === 'distributed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($sponsor->distribution_status === 'pending') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ ucfirst($sponsor->distribution_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                        @if($sponsor->payment_status !== 'paid')
                                            <button wire:click="markAsPaid({{ $sponsor->id }})" title="Mark as Paid" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="hidden sm:inline">Paid</span>
                                            </button>
                                        @endif
                                        @if($sponsor->distribution_status !== 'distributed')
                                            <button wire:click="markAsDistributed({{ $sponsor->id }})" title="Mark as Distributed" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="hidden sm:inline">Dist</span>
                                            </button>
                                        @endif
                                        <button wire:click="editSponsor({{ $sponsor->id }})" title="Edit" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="$dispatch('swal:confirm', {
                                            title: 'Delete Sponsor?',
                                            text: 'Are you sure you want to delete this porridge sponsorship? This action cannot be undone.',
                                            icon: 'warning',
                                            confirmButtonText: 'Yes, Delete',
                                            cancelButtonText: 'Cancel',
                                            eventName: 'deleteSponsor',
                                            eventParams: [{{ $sponsor->id }}]
                                        })" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">No porridge sponsors found</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add Sponsor" to add the first porridge sponsorship</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($sponsors->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $sponsors->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">
                        {{ $editMode ? 'Edit Sponsorship' : 'Add Porridge Sponsor' }}
                    </h3>
                    <button wire:click="closeModal" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <form wire:submit.prevent="saveSponsor" class="space-y-6">
                        <!-- Primary Info Section -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Ramadan Day</label>
                                <select wire:model="day_number" required
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                    @for($day = 1; $day <= 30; $day++)
                                        <option value="{{ $day }}">Day {{ $day }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-span-1 flex items-end pb-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input wire:model.live="is_anonymous" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 transition-colors">Anonymous</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Sponsor Name</label>
                                <input wire:model="sponsor_name" type="text" {{ $is_anonymous ? 'disabled' : 'required' }} 
                                    placeholder="{{ $is_anonymous ? 'Anonymous' : 'Name' }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all {{ $is_anonymous ? 'bg-gray-50 dark:bg-gray-700 cursor-not-allowed' : '' }}">
                                @error('sponsor_name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Type</label>
                                <select wire:model="sponsor_type" required
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                    <option value="individual">Individual</option>
                                    <option value="group">Group</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Contact Number</label>
                            <input wire:model="sponsor_phone" type="tel" placeholder="07XXXXXXXX"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        </div>

                        <!-- Rate Section -->
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Sponsorship Amount (LKR)</label>
                                <input wire:model.live="custom_amount_per_porridge" type="number" step="0.01"
                                    placeholder="{{ number_format($porridgeAmount, 0) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                <p class="mt-1 text-[10px] text-gray-400 font-medium italic">Leave empty to use the default rate: LKR {{ number_format($porridgeAmount, 0) }}</p>
                            </div>

                            <div class="pt-3 border-t border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-600 dark:text-gray-400">Total Amount</span>
                                <div class="text-right">
                                    <div class="text-xl font-black text-blue-600 dark:text-blue-400">
                                        LKR {{ number_format(($custom_amount_per_porridge ?: $porridgeAmount), 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Payment</label>
                                <select wire:model="payment_status" required
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Distribution</label>
                                <select wire:model="distribution_status" required
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                    <option value="pending">Pending</option>
                                    <option value="distributed">Distributed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1.5">Notes</label>
                            <textarea wire:model="notes" rows="2" placeholder="Optional notes..."
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-4 py-2.5 text-sm font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-[2] px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
                                {{ $editMode ? 'Update Record' : 'Save Sponsorship' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
