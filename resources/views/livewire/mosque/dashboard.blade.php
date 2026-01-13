<div class="min-h-screen bg-white dark:bg-gray-900">
    <!-- Mosque Background Header with Silhouette Image -->
    <div class="h-64 relative overflow-hidden" style="background-image: url('{{ asset('images/mosq1.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900/80"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white z-10">
                <h2 class="text-4xl font-bold mb-2 flex items-center justify-center gap-3">
                    <img src="{{ asset('images/mosque.png') }}" alt="Mosque Logo" class="w-12 h-12 object-contain">
                    {{ $mosqueName }}
                </h2>
                <p class="text-blue-100 text-lg">Dashboard & Management</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 py-8 -mt-12 relative z-10">
        <!-- Customize Button -->
        <div class="flex justify-end mb-4">
            <button wire:click="openCustomizeModal" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Customize Dashboard
            </button>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($cardPositions as $cardId)
                @if(in_array($cardId, $visibleCards))
                    @if($cardId === 'families')
                        <!-- Families Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-blue-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Active</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Total Families</p>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $totalFamilies }}</p>
                        </div>
                    @elseif($cardId === 'members')
                        <!-- Members Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-emerald-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 10H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Growing</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Total Members</p>
                            <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totalMembers }}</p>
                        </div>
                    @elseif($cardId === 'donations')
                        <!-- Donations Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-emerald-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">↑ 12%</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Total Donations</p>
                            <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">LKR{{ number_format($totalDonations, 0) }}</p>
                        </div>
                    @elseif($cardId === 'santhas_paid')
                        <!-- Paid This Month Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-emerald-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Regular</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">This Month Paid</p>
                            <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ $todaySanthas }}</p>
                        </div>
                    @elseif($cardId === 'students_count')
                        <!-- Madrasa Students Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-blue-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Learning</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Madrasa Students</p>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $studentsCount }}</p>
                        </div>
                    @elseif($cardId === 'porridge_sponsors')
                        <!-- Porridge Sponsors Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-emerald-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Ramadan</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Porridge Sponsors</p>
                            <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ $porridgeSponsorsCount }}</p>
                        </div>
                    @elseif($cardId === 'active_imams')
                        <!-- Active Imams Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-blue-600">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Serving</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Active Imams</p>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $activeImamsCount }}</p>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>

        <!-- Three Column Layout for Lists -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            @foreach($cardPositions as $cardId)
                @if(in_array($cardId, $visibleCards))
                    @if($cardId === 'recent_families')
                        <!-- Recent Families -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Recent Families</h3>
                                <p class="text-blue-100 text-sm mt-1">Latest registrations</p>
                            </div>
                            <div class="divide-y divide-slate-200 dark:divide-slate-700 max-h-96 overflow-y-auto">
                                @forelse($recentFamilies as $family)
                                    <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <h4 class="font-bold text-slate-900 dark:text-white">{{ $family->family_head_name }}</h4>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $family->total_members }} Members</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">{{ $family->phone }}</p>
                                    </div>
                                @empty
                                    <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <p>No families yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @elseif($cardId === 'recent_donations')
                        <!-- Recent Donations -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Recent Donations</h3>
                                <p class="text-emerald-100 text-sm mt-1">Latest received</p>
                            </div>
                            <div class="divide-y divide-slate-200 dark:divide-slate-700 max-h-96 overflow-y-auto">
                                @forelse($recentDonations as $donation)
                                    <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $donation->donor_name }}</h4>
                                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">{{ $donation->donation_type }}</p>
                                            </div>
                                            <div class="text-emerald-600 dark:text-emerald-400 font-bold">LKR{{ number_format($donation->amount, 0) }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <p>No donations yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @elseif($cardId === 'baithulmal_summary')
                        <!-- Baithulmal Summary -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Baithulmal Summary</h3>
                                <p class="text-emerald-100 text-sm mt-1">Financial overview</p>
                            </div>
                            
                            <!-- Summary Cards -->
                            <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-b border-emerald-200 dark:border-emerald-800">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="text-center">
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Income</p>
                                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">LKR{{ number_format($baithulmalSummary['totalIncome'], 0) }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Expense</p>
                                        <p class="text-sm font-bold text-red-600 dark:text-red-400">LKR{{ number_format($baithulmalSummary['totalExpense'], 0) }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">Balance</p>
                                        <p class="text-sm font-bold {{ $baithulmalSummary['currentBalance'] >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}">
                                            LKR{{ number_format($baithulmalSummary['currentBalance'], 0) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Transactions -->
                            <div class="divide-y divide-slate-200 dark:divide-slate-700 max-h-96 overflow-y-auto">
                                @forelse($recentBaithulmalTransactions as $transaction)
                                    <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $transaction->type === 'income' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                                        {{ $transaction->type === 'income' ? '↑ Income' : '↓ Expense' }}
                                                    </span>
                                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->category }}</span>
                                                </div>
                                                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">
                                                    {{ $transaction->description ?: ($transaction->type === 'income' ? 'Income' : 'Expense') }}
                                                </h4>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                    {{ $transaction->transaction_date->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="text-right ml-4">
                                                <p class="font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ $transaction->type === 'income' ? '+' : '-' }}LKR{{ number_format($transaction->amount, 0) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p>No transactions yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @elseif($cardId === 'recent_santhas')
                        <!-- Recent Santhas -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Recent Santha Collections</h3>
                                <p class="text-emerald-100 text-sm mt-1">Latest collections</p>
                            </div>
                            <div class="divide-y divide-slate-200 dark:divide-slate-700 max-h-96 overflow-y-auto">
                                @forelse($recentSanthas as $santha)
                                    <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $santha->family->family_head_name ?? 'Unknown Family' }}</h4>
                                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                                    {{ $santha->getMonthsCoveredDisplay() }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">
                                                    {{ $santha->payment_date->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="text-emerald-600 dark:text-emerald-400 font-bold">LKR{{ number_format($santha->amount, 0) }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <p>No santha collections yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <!-- Customization Modal -->
    @if($showCustomizeModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeCustomizeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 rounded-t-2xl shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-xl font-bold">Customize Dashboard</h3>
                            <p class="text-blue-100 text-sm mt-1">Choose which cards to display and their order</p>
                        </div>
                        <button wire:click="closeCustomizeModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Card Count Indicator -->
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-purple-400/30">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium">Visible Cards:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-bold {{ count($visibleCards) >= 7 ? 'bg-red-500' : 'bg-emerald-500' }}">
                                    {{ count($visibleCards) }} / 7
                                </span>
                            </div>
                        </div>
                        @if(count($visibleCards) >= 7)
                            <div class="text-xs bg-red-500/20 px-3 py-1 rounded-full border border-red-400">
                                ⚠️ Maximum limit reached
                            </div>
                        @else
                            <div class="text-xs bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-400">
                                ✓ {{ 7 - count($visibleCards) }} more available
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($cardPositions as $index => $cardId)
                            @if(isset($availableCards[$cardId]))
                                @php
                                    $isVisible = in_array($cardId, $visibleCards);
                                    $isDisabled = !$isVisible && count($visibleCards) >= 7;
                                @endphp
                                <div class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-600 {{ $isDisabled ? 'opacity-50' : '' }}">
                                    <!-- Visibility Toggle -->
                                    <label class="relative inline-flex items-center {{ $isDisabled ? 'cursor-not-allowed' : 'cursor-pointer' }}">
                                        <input 
                                            type="checkbox" 
                                            wire:click="toggleCard('{{ $cardId }}')" 
                                            {{ $isVisible ? 'checked' : '' }} 
                                            {{ $isDisabled ? 'disabled' : '' }}
                                            class="sr-only peer {{ $isDisabled ? 'pointer-events-none' : '' }}">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600 {{ $isDisabled ? 'peer-disabled:opacity-50' : '' }}"></div>
                                    </label>

                                    <!-- Card Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-semibold text-slate-900 dark:text-white">{{ $availableCards[$cardId]['name'] }}</h4>
                                            @if($isDisabled)
                                                <span class="px-2 py-0.5 text-xs bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full">
                                                    Limit reached
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $availableCards[$cardId]['type'] ?? 'stat' }} card</p>
                                    </div>

                                    <!-- Position Controls -->
                                    <div class="flex gap-2">
                                        <button wire:click="moveCardUp('{{ $cardId }}')" {{ $index === 0 ? 'disabled' : '' }} class="p-2 bg-white dark:bg-slate-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-4 h-4 text-slate-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="moveCardDown('{{ $cardId }}')" {{ $index === count($cardPositions) - 1 ? 'disabled' : '' }} class="p-2 bg-white dark:bg-slate-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-4 h-4 text-slate-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <button wire:click="resetToDefault" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 font-semibold transition">
                            Reset to Default
                        </button>
                        <button wire:click="savePreferences" class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 font-semibold transition shadow-lg">
                            Save Preferences
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
