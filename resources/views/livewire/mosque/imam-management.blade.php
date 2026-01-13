@section('title', 'Imam Management')

<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Imam Management</h2>
                <p class="text-white/80 dark:text-gray-400 mt-1 text-sm sm:text-base">Manage imams, salaries, advances, and availability schedules</p>
            </div>
            <div class="grid grid-cols-2 lg:flex lg:flex-wrap lg:justify-end gap-2 w-full lg:w-auto">
                <button wire:click="openImamModal" class="inline-flex items-center justify-center px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg text-xs sm:text-sm lg:text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Imam</span>
                    <span class="sm:hidden">Imam</span>
                </button>
                <button wire:click="openSalaryModal" class="inline-flex items-center justify-center px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 bg-gradient-to-r from-emerald-600 to-emerald-800 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-emerald-900 transition shadow-lg text-xs sm:text-sm lg:text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">Record Salary</span>
                    <span class="sm:hidden">Salary</span>
                </button>
                <button wire:click="openAdvanceModal" class="inline-flex items-center justify-center px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg text-xs sm:text-sm lg:text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Request Advance</span>
                    <span class="sm:hidden">Advance</span>
                </button>
                <button wire:click="openDaysModal" class="inline-flex items-center justify-center px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg text-xs sm:text-sm lg:text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Availability</span>
                    <span class="sm:hidden">Days</span>
                </button>
            </div>
        </div>

        <!-- Type Filter Tabs -->
        <div class="mb-8 overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
            <div class="flex p-1.5 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/10 w-fit min-w-max">
                <button wire:click="$set('activeTab', 'imams')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'imams' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Imams
                </button>
                <button wire:click="$set('activeTab', 'salaries')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'salaries' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Salaries
                </button>
                <button wire:click="$set('activeTab', 'advances')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'advances' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Advances
                </button>
                <button wire:click="$set('activeTab', 'availability')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'availability' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Availability
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Type</label>
                <select wire:model.live="filterType" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">All Types</option>
                    <option value="salary">Salary</option>
                    <option value="advance">Advance</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Search</label>
                <input wire:model.live="search" type="text" placeholder="Search imams, records..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500">
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($activeTab === 'imams')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Total Imams</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $imams->total() }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-100 text-xs sm:text-sm font-medium">Active Imams</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $imams->where('status', 'active')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-red-100 text-xs sm:text-sm font-medium">Inactive Imams</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $imams->where('status', 'inactive')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Total Salary Budget</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold break-words">LKR{{ number_format($imams->sum('monthly_salary'), 0) }}</p>
                </div>
            </div>
        
        @elseif($activeTab === 'advances')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Total Advances</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold break-words">LKR{{ number_format($advances->sum('amount'), 0) }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-100 text-xs sm:text-sm font-medium">Paid Advances</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $advances->where('status', 'paid')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-red-100 text-xs sm:text-sm font-medium">Pending Advances</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $advances->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Approved Advances</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $advances->where('status', 'approved')->count() }}</p>
                </div>
            </div>
        @elseif($activeTab === 'availability')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Total Schedules</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $availableDays->total() }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-100 text-xs sm:text-sm font-medium">Available Slots</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $availableDays->where('is_available', true)->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-red-100 text-xs sm:text-sm font-medium">Unavailable Slots</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $availableDays->where('is_available', false)->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-4 sm:p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-xs sm:text-sm font-medium">Active Imams</span>
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $availableDays->unique('imam_id')->count() }}</p>
                </div>
            </div>
        @endif

        <!-- Imams Tab -->
        @if($activeTab === 'imams')
            <!-- Imams Table -->
            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Imam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($imams as $imam)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($imam->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $imam->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $imam->email ?: 'N/A' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $imam->phone ?: 'N/A' }}</div>
                                    </td>
                                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $imam->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ ucfirst($imam->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                            <button wire:click="openImamModal({{ $imam->id }})" title="Edit Imam" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button onclick="confirmDelete('confirmDeleteImam', {{ $imam->id }}, 'Delete Imam?', 'This will permanently delete this imam and all related records. This action cannot be undone.')" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">No imams found</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add Imam" to create your first imam</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($imams->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $imams->links() }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Salaries Tab -->
        @if($activeTab === 'salaries')
            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($financialSummary as $summary)
                    <div class="bg-gradient-to-br from-green-200 to-emerald-200 dark:from-green-800 dark:to-emerald-800 rounded-xl p-6 border border-green-300 dark:border-green-700 shadow-lg text-gray-900 dark:text-white relative">
                        <!-- Paid Badge -->
                        @if($summary['salary_paid'])
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                                    ✓ PAID
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($summary['imam']->name, 0, 1)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $summary['imam']->name }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $summary['imam']->phone ?: 'No phone' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Monthly Salary -->
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-600 dark:text-gray-400">Monthly Salary</span>
                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">LKR{{ number_format($summary['monthly_salary'], 2) }}</span>
                            </div>

                            <!-- Paid Advances -->
                            @if($summary['paid_advances'] > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Paid Advances</span>
                                    <span class="text-sm font-semibold text-red-600 dark:text-red-400">-LKR{{ number_format($summary['paid_advances'], 2) }}</span>
                                </div>
                            @endif

                            <!-- Paid Salary Amount -->
                            @if($summary['salary_paid'])
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Paid Salary ({{ now()->format('M Y') }})</span>
                                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">LKR{{ number_format($summary['paid_salary_amount'], 2) }}</span>
                                </div>
                            @endif

                            <!-- Available Salary -->
                            @if(!$summary['salary_paid'])
                                <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Available Salary</span>
                                    <span class="text-lg font-bold {{ $summary['available_salary'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        LKR{{ number_format($summary['available_salary'], 2) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Pending Advances -->
                            @if($summary['pending_advances'] > 0)
                                <div class="flex justify-between items-center pt-2 border-t border-orange-200 dark:border-orange-700">
                                    <span class="text-xs font-medium text-orange-700 dark:text-orange-300">Pending Advances</span>
                                    <span class="text-sm font-bold text-orange-600 dark:text-orange-400">LKR{{ number_format($summary['pending_advances'], 2) }}</span>
                                </div>
                            @endif

                            <!-- Pay Salary Button -->
                            @if($summary['salary_paid'])
                                <div class="w-full mt-4 space-y-2">
                                    <div class="px-4 py-2.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg font-medium text-sm text-center border-2 border-green-500">
                                        ✓ Salary Paid This Month
                                    </div>
                                    <button wire:click="viewSalarySlip({{ $summary['salary_record_id'] }})" 
                                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                        📄 View Salary Slip
                                    </button>
                                </div>
                            @elseif($summary['available_salary'] > 0)
                                <button wire:click="openSalaryPaymentModal({{ $summary['imam']->id }})" 
                                        class="w-full mt-4 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-medium text-sm hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    💰 Pay Salary Now
                                </button>
                            @else
                                <div class="w-full mt-4 px-4 py-2.5 bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg font-medium text-sm text-center cursor-not-allowed">
                                    No Available Salary
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">No active imams found</p>
                    </div>
                @endforelse
            </div>

            

                <!-- Pagination -->
                @if($salaries->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $salaries->links() }}
                    </div>
                @endif>
            </div>

        @endif

        <!-- Advances Tab -->
        @if($activeTab === 'advances')
            <!-- Advances Table -->
            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Imam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Request Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Purpose</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($advances as $advance)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($advance->imam->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $advance->imam->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $advance->imam->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-purple-600 dark:text-purple-400">LKR{{ number_format($advance->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $advance->record_date->format('d M, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ ucfirst($advance->purpose ?: 'Other') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($advance->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($advance->status === 'approved') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($advance->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                            {{ ucfirst($advance->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                            @if($advance->status !== 'paid')
                                                <button wire:click="payAdvance({{ $advance->id }})" title="Pay" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span class="hidden sm:inline">Pay</span>
                                                </button>
                                            @endif
                                            <button wire:click="openAdvanceModal({{ $advance->id }})" title="Edit" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-purple-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button onclick="confirmDelete('confirmDeleteRecord', {{ $advance->id }}, 'Delete Advance Record?', 'This will permanently delete this advance record. This action cannot be undone.')" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">No advance records found</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Request Advance" to add an advance payment</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($advances->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $advances->links() }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Availability Tab -->
        @if($activeTab === 'availability')
            <!-- Availability Table -->
            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Imam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Available</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($availableDays as $day)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($day->imam->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $day->imam->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $day->imam->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $day->start_date->format('M d, Y') }} - {{ $day->end_date->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $day->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $day->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                            <button wire:click="openDaysModal({{ $day->id }})" title="Edit" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-orange-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button onclick="confirmDelete('confirmDeleteDay', {{ $day->id }}, 'Delete Availability?', 'This will permanently delete this availability record. This action cannot be undone.')" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">No availability records found</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add Availability" to schedule imam availability</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($availableDays->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $availableDays->links() }}
                    </div>
                @endif
            </div>
        @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Imam Modal -->
    @if($showImamModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click.self="closeImamModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editingImam ? 'Edit Imam' : 'Add New Imam' }}</h3>
                        <button wire:click="closeImamModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveImam" class="space-y-3">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="name" type="text" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email and Phone -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input wire:model="email" type="email"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('email') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone
                                </label>
                                <input wire:model="phone" type="text"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <textarea wire:model="address" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('address') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date of Birth and Monthly Salary -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Date of Birth
                                </label>
                                <input wire:model="date_of_birth" type="date"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('date_of_birth') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Monthly Salary (LKR) <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="monthly_salary" type="number" step="0.01" min="0" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('monthly_salary') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Qualification and Status -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Qualification
                                </label>
                                <input wire:model="qualification" type="text"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('qualification') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="status" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Experience
                            </label>
                            <textarea wire:model="experience" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('experience') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeImamModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 font-semibold transition shadow-lg">
                                {{ $editingImam ? 'Update Imam' : 'Add Imam' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Salary Modal -->
    @if($showSalaryModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click.self="closeRecordModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editingRecord ? 'Edit Salary Record' : 'Record Salary Payment' }}</h3>
                        <button wire:click="closeRecordModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveRecord" class="space-y-3">
                        <!-- Imam Selection -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Imam <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="imam_id_record" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                <option value="">Select Imam</option>
                                @foreach($imams->items() as $imam)
                                    <option value="{{ $imam->id }}">{{ $imam->name }} - LKR{{ number_format($imam->monthly_salary, 2) }}/month</option>
                                @endforeach
                            </select>
                            @error('imam_id_record') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Salary Month and Status -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Salary Month <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="record_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('record_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="record_status" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                @error('record_status') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Salary Breakdown -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Salary Breakdown</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Basic Salary (LKR) <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="basic_salary" type="number" step="0.01" min="0" required
                                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    @error('basic_salary') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        House Allowance (LKR)
                                    </label>
                                    <input wire:model="house_allowance" type="number" step="0.01" min="0"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    @error('house_allowance') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Transport Allowance (LKR)
                                    </label>
                                    <input wire:model="transport_allowance" type="number" step="0.01" min="0"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    @error('transport_allowance') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Medical Allowance (LKR)
                                    </label>
                                    <input wire:model="medical_allowance" type="number" step="0.01" min="0"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    @error('medical_allowance') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Other Allowances (LKR)
                                </label>
                                <input wire:model="other_allowances" type="number" step="0.01" min="0"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('other_allowances') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Payment Date and Method -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Date
                                </label>
                                <input wire:model="payment_date" type="date"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('payment_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method
                                </label>
                                <select wire:model="payment_method"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Online">Online</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Transaction ID and Notes -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Transaction ID
                                </label>
                                <input wire:model="transaction_id" type="text"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('transaction_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-end">
                                <div class="w-full">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Total: <span class="font-bold text-green-600">LKR{{ number_format(((float)($basic_salary ?? 0)) + ((float)($house_allowance ?? 0)) + ((float)($transport_allowance ?? 0)) + ((float)($medical_allowance ?? 0)) + ((float)($other_allowances ?? 0)), 2) }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="record_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500"></textarea>
                            @error('record_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeRecordModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-semibold transition shadow-lg">
                                {{ $editingRecord ? 'Update Salary' : 'Record Salary' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Advance Modal -->
    @if($showAdvanceModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click.self="closeRecordModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editingRecord ? 'Edit Advance Payment' : 'Request Advance Payment' }}</h3>
                        <button wire:click="closeRecordModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveRecord" class="space-y-3">
                        <!-- Imam Selection -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Imam <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.live="imam_id_record" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Imam</option>
                                @foreach($imams->items() as $imam)
                                    <option value="{{ $imam->id }}">{{ $imam->name }}</option>
                                @endforeach
                            </select>
                            @error('imam_id_record') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Salary Information -->
                        @if($imam_id_record)
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Salary Information</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Monthly Salary</span>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            LKR{{ number_format($imams->find($imam_id_record)?->monthly_salary ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Available Salary</span>
                                        <p class="text-sm font-semibold {{ $this->getAvailableSalary($imam_id_record) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            LKR{{ number_format($this->getAvailableSalary($imam_id_record), 2) }}
                                        </p>
                                    </div>
                                </div>
                                @if($this->getAvailableSalary($imam_id_record) < 0)
                                    <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded">
                                        <p class="text-xs text-red-700 dark:text-red-300">
                                            ⚠️ Advance amount will result in negative salary balance
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Amount and Request Date -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Amount (LKR) <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="amount" type="number" step="0.01" min="0" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('amount') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Request Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="record_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('record_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Purpose and Status -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Purpose
                                </label>
                                <select wire:model="purpose"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select Purpose</option>
                                    <option value="Medical">Medical</option>
                                    <option value="Family Emergency">Family Emergency</option>
                                    <option value="Education">Education</option>
                                    <option value="House Repair">House Repair</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('purpose') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="record_status" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="paid">Paid</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                @error('record_status') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Reason -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Reason
                            </label>
                            <textarea wire:model="reason" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('reason') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="record_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('record_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeRecordModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 font-semibold transition shadow-lg">
                                {{ $editingRecord ? 'Update Advance' : 'Request Advance' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Modal -->
    @if($showPaymentModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click.self="closePaymentModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">Process Advance Payment</h3>
                        <button wire:click="closePaymentModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    @if($paymentAdvance)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mb-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Advance Details</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Imam</span>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $paymentAdvance->imam->name }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Amount</span>
                                    <p class="text-sm font-semibold text-green-600 dark:text-green-400">LKR{{ number_format($paymentAdvance->amount, 2) }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Purpose</span>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($paymentAdvance->purpose ?: 'Other') }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Request Date</span>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $paymentAdvance->record_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="processPayment" class="space-y-3">
                        <!-- Payment Date and Method -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="payment_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('payment_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="payment_method" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Online">Online</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Transaction ID -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Transaction ID
                            </label>
                            <input wire:model="transaction_id" type="text"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                            @error('transaction_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Payment Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Payment Notes
                            </label>
                            <textarea wire:model="payment_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500"></textarea>
                            @error('payment_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closePaymentModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-semibold transition shadow-lg">
                                Process Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Availability Modal -->
    @if($showDaysModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click.self="closeDaysModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editingDay ? 'Edit Availability' : 'Add Availability' }}</h3>
                        <button wire:click="closeDaysModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveDay" class="space-y-3">
                        <!-- Imam Selection -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Imam <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="imam_id_day" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Imam</option>
                                @foreach($imams->items() as $imam)
                                    <option value="{{ $imam->id }}">{{ $imam->name }}</option>
                                @endforeach
                            </select>
                            @error('imam_id_day') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Period Availability -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="start_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('start_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="end_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('end_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="day_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('day_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeDaysModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 font-semibold transition shadow-lg">
                                {{ $editingDay ? 'Update Availability' : 'Add Availability' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Salary Payment Modal -->
    @if($showSalaryPaymentModal)
        <div class="fixed inset-0 bg-black/40 dark:bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl max-w-2xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-lg">Pay Salary</h3>
                    <button wire:click="closeSalaryPaymentModal" class="text-white hover:bg-white/20 p-1 rounded transition">✕</button>
                </div>

                <form wire:submit="paySalary" class="p-6 space-y-4">
                    <!-- Imam Name (Read-only) -->
                    @if($paymentImamId)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imam</label>
                            <input type="text" value="{{ \App\Models\Imam::find($paymentImamId)?->name }}" disabled
                                class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
                        </div>
                    @endif

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount (LKR)</label>
                        <input type="number" wire:model="paymentAmount" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('paymentAmount') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Payment Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Date</label>
                        <input type="date" wire:model="paymentDate"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('paymentDate') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                        <select wire:model="paymentMethodSalary"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                            <option value="online">Online</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Transaction ID -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction ID (Optional)</label>
                        <input type="text" wire:model="paymentTransactionId" placeholder="e.g., TXN123456"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                        <textarea wire:model="paymentNotes" placeholder="Add any additional notes..." rows="2"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2 pt-4">
                        <button type="button" wire:click="closeSalaryPaymentModal"
                            class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-semibold transition shadow-lg">
                            Pay Salary
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Salary Slip Modal -->
    @if($showSalarySlip && !empty($viewingSalarySlip))
        <div class="fixed inset-0 bg-black/40 dark:bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl max-w-2xl w-full max-h-[95vh] sm:max-h-screen overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-lg">Salary Payment Slip</h3>
                    <button wire:click="closeSalarySlip" class="text-white hover:bg-white/20 p-1 rounded transition">✕</button>
                </div>

                <div class="p-6">
                    <!-- Print & Download Buttons -->
                    <div class="mb-4 flex gap-2">
                        <button onclick="printSalarySlip()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                            Print
                        </button>
                        <button onclick="downloadSalarySlip()" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                            Download PDF
                        </button>
                        <button wire:click="closeSalarySlip" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                            Close
                        </button>
                    </div>

                    <!-- Salary Slip Content -->
                    <div id="salary-slip-content" style="background:#ffffff;padding:22px;color:#111827;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;max-width:640px;margin:0 auto;">
                        <div style="text-align:center;margin-bottom:8px;">
                            <h2 style="font-size:20px;margin:0 0 4px 0;font-weight:700;color:#0f172a;">{{ $viewingSalarySlip['mosque_name'] }}</h2>
                            <p style="margin:0;color:#6b7280;font-size:13px;">Salary Payment Slip</p>
                        </div>

                        <table style="width:100%;border-collapse:collapse;margin-top:12px;">
                            <tr>
                                <td style="padding:8px 0;color:#374151;width:60%;"><strong>Slip #</strong></td>
                                <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSalarySlip['slip_number'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0;color:#374151;"><strong>Payment Date</strong></td>
                                <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSalarySlip['payment_date'] }}</td>
                            </tr>
                        </table>

                        <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                        <div style="color:#374151;font-size:14px;line-height:1.5;margin-bottom:10px;">
                            <div><strong>Imam:</strong> {{ $viewingSalarySlip['imam_name'] }}</div>
                            <div><strong>Phone:</strong> {{ $viewingSalarySlip['imam_phone'] }}</div>
                            <div><strong>Period:</strong> {{ $viewingSalarySlip['period'] }}</div>
                        </div>

                        <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                        <!-- Salary Calculation Breakdown -->
                        <div style="background:#f9fafb;padding:12px;border-radius:4px;margin-bottom:10px;font-size:14px;">
                            <div style="font-weight:600;color:#111827;margin-bottom:8px;font-size:15px;">Salary Calculation</div>
                            
                            <table style="width:100%;border-collapse:collapse;">
                                <!-- Basic Salary -->
                                <tr style="border-bottom:1px solid #e5e7eb;">
                                    <td style="padding:8px 0;color:#374151;">Basic Salary</td>
                                    <td style="padding:8px 0;text-align:right;color:#059669;font-weight:700;font-size:15px;">LKR{{ number_format($viewingSalarySlip['basic_salary'], 2) }}</td>
                                </tr>

                                <!-- Allowances if any -->
                                @if($viewingSalarySlip['house_allowance'] > 0)
                                    <tr>
                                        <td style="padding:6px 0 6px 20px;color:#6b7280;font-size:13px;">+ House Allowance</td>
                                        <td style="padding:6px 0;text-align:right;color:#059669;font-weight:600;">LKR{{ number_format($viewingSalarySlip['house_allowance'], 2) }}</td>
                                    </tr>
                                @endif
                                @if($viewingSalarySlip['transport_allowance'] > 0)
                                    <tr>
                                        <td style="padding:6px 0 6px 20px;color:#6b7280;font-size:13px;">+ Transport Allowance</td>
                                        <td style="padding:6px 0;text-align:right;color:#059669;font-weight:600;">LKR{{ number_format($viewingSalarySlip['transport_allowance'], 2) }}</td>
                                    </tr>
                                @endif
                                @if($viewingSalarySlip['medical_allowance'] > 0)
                                    <tr>
                                        <td style="padding:6px 0 6px 20px;color:#6b7280;font-size:13px;">+ Medical Allowance</td>
                                        <td style="padding:6px 0;text-align:right;color:#059669;font-weight:600;">LKR{{ number_format($viewingSalarySlip['medical_allowance'], 2) }}</td>
                                    </tr>
                                @endif
                                @if($viewingSalarySlip['other_allowances'] > 0)
                                    <tr>
                                        <td style="padding:6px 0 6px 20px;color:#6b7280;font-size:13px;">+ Other Allowances</td>
                                        <td style="padding:6px 0;text-align:right;color:#059669;font-weight:600;">LKR{{ number_format($viewingSalarySlip['other_allowances'], 2) }}</td>
                                    </tr>
                                @endif

                                <!-- Advances Deducted -->
                                @if(!empty($viewingSalarySlip['advances']) && count($viewingSalarySlip['advances']) > 0)
                                    @foreach($viewingSalarySlip['advances'] as $advance)
                                        <tr>
                                            <td style="padding:6px 0 6px 20px;color:#dc2626;font-size:13px;">
                                                - Advance ({{ $advance['date'] }})
                                                @if(!empty($advance['purpose']))
                                                    <br><span style="font-size:11px;color:#991b1b;margin-left:10px;">{{ $advance['purpose'] }}</span>
                                                @endif
                                            </td>
                                            <td style="padding:6px 0;text-align:right;color:#dc2626;font-weight:600;">-LKR{{ number_format($advance['amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                <!-- Net Salary -->
                                <tr style="border-top:2px solid #111827;background:#dcfce7;">
                                    <td style="padding:12px 8px;color:#14532d;font-weight:700;font-size:16px;">Pay Balance Salary</td>
                                    <td style="padding:12px 8px;text-align:right;color:#15803d;font-weight:700;font-size:18px;">LKR{{ number_format($viewingSalarySlip['amount'], 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Payment Details -->
                        <div style="background:#f3f4f6;padding:10px;border-radius:4px;margin-top:12px;font-size:13px;">
                            <table style="width:100%;border-collapse:collapse;">
                                <tr>
                                    <td style="padding:4px 0;color:#374151;">Payment Method:</td>
                                    <td style="padding:4px 0;text-align:right;color:#111827;font-weight:600;">{{ $viewingSalarySlip['payment_method'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 0;color:#374151;">Transaction ID:</td>
                                    <td style="padding:4px 0;text-align:right;color:#111827;font-weight:600;">{{ $viewingSalarySlip['transaction_id'] }}</td>
                                </tr>
                            </table>
                        </div>

                        @if(!empty($viewingSalarySlip['notes']))
                            <div style="margin-top:8px;font-size:13px;color:#374151;">
                                <strong>Notes:</strong> {{ $viewingSalarySlip['notes'] }}
                            </div>
                        @endif

                        <div style="text-align:left;color:#9ca3af;margin-top:16px;font-size:12px;">
                            Processed by: {{ $viewingSalarySlip['created_by'] }} | Generated: {{ now()->format('Y-m-d H:i:s') }}
                        </div>
                        <div style="text-align:left;color:#9ca3af;font-size:12px;">
                            This slip is generated by {{ config('app.name') }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function printSalarySlip() {
        const content = document.getElementById('salary-slip-content');
        if (!content) return;
        
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Salary Slip</title>');
        printWindow.document.write(content.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    function downloadSalarySlip() {
        const content = document.getElementById('salary-slip-content');
        if (typeof html2pdf !== 'undefined' && content) {
            const temp = document.createElement('div');
            temp.innerHTML = content.innerHTML;
            html2pdf().from(temp).set({margin:10, filename: 'salary_slip_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove());
        } else if (content) {
            const s = document.createElement('script');
            s.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
            document.head.appendChild(s);
            s.onload = () => { 
                const temp = document.createElement('div');
                temp.innerHTML = content.innerHTML;
                html2pdf().from(temp).set({margin:10, filename: 'salary_slip_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove());
            };
        }
    }
</script>
