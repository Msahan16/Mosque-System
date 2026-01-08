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
        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <p class="text-4xl font-bold text-cyan-600 dark:text-cyan-400">LKR{{ number_format($totalDonations, 0) }}</p>
            </div>

            <!-- Paid This Month Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all p-8 border-l-4 border-purple-600">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Regular</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">This Month Paid</p>
                <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $todaySanthas }}</p>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        

        <!-- Three Column Layout for Lists -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recent Families -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
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

            <!-- Recent Donations -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Recent Donations</h3>
                    <p class="text-cyan-100 text-sm mt-1">Latest received</p>
                </div>
                <div class="divide-y divide-slate-200 dark:divide-slate-700 max-h-96 overflow-y-auto">
                    @forelse($recentDonations as $donation)
                        <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 dark:text-white">{{ $donation->donor_name }}</h4>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">{{ $donation->donation_type }}</p>
                                </div>
                                <div class="text-cyan-600 dark:text-cyan-400 font-bold">LKR{{ number_format($donation->amount, 0) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            <p>No donations yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Baithulmal Summary -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
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
        </div>
    </div>
</div>
