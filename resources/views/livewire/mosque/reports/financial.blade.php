{{-- Financial Summary Report --}}
<div class="space-y-6">
    {{-- Main Financial Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-2xl p-8 text-white transform hover:scale-105 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-emerald-100 text-sm mb-1">Total Income</p>
                    <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_income'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-2xl p-8 text-white transform hover:scale-105 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-red-100 text-sm mb-1">Total Expenses</p>
                    <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_expenses'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-2xl p-8 text-white transform hover:scale-105 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-100 text-sm mb-1">Net Balance</p>
                    <p class="text-4xl font-bold">LKR {{ number_format($reportData['net_balance'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Income Breakdown --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Income Breakdown</h3>
            <p class="text-emerald-100 text-sm mt-1">Revenue sources during this period</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-6 border-2 border-cyan-200 dark:border-cyan-700">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Donations</p>
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400">LKR {{ number_format($reportData['income_breakdown']['donations'] ?? 0) }}</p>
                    <div class="mt-3 pt-3 border-t border-cyan-200 dark:border-cyan-700">
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            {{ $reportData['total_income'] > 0 ? number_format(($reportData['income_breakdown']['donations'] / $reportData['total_income']) * 100, 1) : 0 }}% of total income
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-6 border-2 border-purple-200 dark:border-purple-700">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Santha Payments</p>
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">LKR {{ number_format($reportData['income_breakdown']['santhas'] ?? 0) }}</p>
                    <div class="mt-3 pt-3 border-t border-purple-200 dark:border-purple-700">
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            {{ $reportData['total_income'] > 0 ? number_format(($reportData['income_breakdown']['santhas'] / $reportData['total_income']) * 100, 1) : 0 }}% of total income
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-6 border-2 border-orange-200 dark:border-orange-700">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Porridge Sponsors</p>
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">LKR {{ number_format($reportData['income_breakdown']['porridge'] ?? 0) }}</p>
                    <div class="mt-3 pt-3 border-t border-orange-200 dark:border-orange-700">
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            {{ $reportData['total_income'] > 0 ? number_format(($reportData['income_breakdown']['porridge'] / $reportData['total_income']) * 100, 1) : 0 }}% of total income
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Expense Breakdown --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Expense Breakdown</h3>
            <p class="text-red-100 text-sm mt-1">Expenditure during this period</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-6 border-2 border-red-200 dark:border-red-700">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Imam Management</p>
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">LKR {{ number_format($reportData['expense_breakdown']['imam'] ?? 0) }}</p>
                    <div class="mt-3 pt-3 border-t border-red-200 dark:border-red-700">
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            {{ $reportData['total_expenses'] > 0 ? number_format(($reportData['expense_breakdown']['imam'] / $reportData['total_expenses']) * 100, 1) : 0 }}% of total expenses
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-600 rounded-xl p-6 border-2 border-slate-200 dark:border-slate-600">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Other Expenses</p>
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-600 dark:text-slate-400">LKR 0</p>
                    <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-600">
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            0% of total expenses
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Financial Health Indicator --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Financial Health</h3>
        </div>
        <div class="p-8">
            <div class="text-center">
                @php
                    $balance = $reportData['net_balance'] ?? 0;
                    $healthColor = $balance > 0 ? 'emerald' : ($balance < 0 ? 'red' : 'slate');
                    $healthStatus = $balance > 0 ? 'Surplus' : ($balance < 0 ? 'Deficit' : 'Balanced');
                @endphp
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-{{ $healthColor }}-100 dark:bg-{{ $healthColor }}-900/30 mb-4">
                    <svg class="w-16 h-16 text-{{ $healthColor }}-600 dark:text-{{ $healthColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($balance > 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @elseif($balance < 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        @endif
                    </svg>
                </div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ $healthStatus }}</p>
                <p class="text-4xl font-bold text-{{ $healthColor }}-600 dark:text-{{ $healthColor }}-400 mb-4">
                    LKR {{ number_format(abs($balance)) }}
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                    @if($balance > 0)
                        Excellent! The mosque has a healthy surplus for this period. Continue maintaining good financial practices.
                    @elseif($balance < 0)
                        Attention needed. The mosque is running a deficit. Consider reviewing expenses or increasing fundraising efforts.
                    @else
                        The mosque's income and expenses are balanced for this period.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
