{{-- Santha Payments Report - Professional Format --}}
<div class="space-y-6">
    {{-- Paid Santhas Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-800 px-6 py-4 border-b-2 border-emerald-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Paid Santha Payments</h2>
                    <p class="text-emerald-100 text-sm mt-1">Successfully collected payments for the selected period</p>
                </div>
                <div class="text-right">
                    <p class="text-emerald-100 text-xs uppercase tracking-wide">Total Collected</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($reportData['total_paid'] ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">{{ number_format($reportData['paid_count'] ?? 0) }} Payments</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Family Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Month</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Year</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Amount (LKR)</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Payment Date</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['paid_list'] ?? [] as $index => $santha)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $santha->family->family_head_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $santha->month }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $santha->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right border-r border-slate-200 dark:border-slate-700">{{ number_format($santha->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ \Carbon\Carbon::parse($santha->payment_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">PAID</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No paid santhas in this period</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['paid_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Paid:</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-300 dark:border-slate-600">{{ number_format($reportData['total_paid'], 2) }}</td>
                        <td colspan="2" class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format($reportData['paid_count']) }} Payments</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Unpaid Santhas Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-red-700 to-red-800 px-6 py-4 border-b-2 border-red-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Unpaid Santha Payments</h2>
                    <p class="text-red-100 text-sm mt-1">Pending payments requiring collection</p>
                </div>
                <div class="text-right">
                    <p class="text-red-100 text-xs uppercase tracking-wide">Amount Due</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($reportData['total_unpaid'] ?? 0) }}</p>
                    <p class="text-red-200 text-sm">{{ number_format($reportData['unpaid_count'] ?? 0) }} Pending</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Family Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Month</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Year</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Amount Due (LKR)</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['unpaid_list'] ?? [] as $index => $santha)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $santha->family->family_head_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $santha->month }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $santha->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 text-right border-r border-slate-200 dark:border-slate-700">{{ number_format($santha->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">UNPAID</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center bg-emerald-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-emerald-300 dark:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">✨ All santhas are paid! Excellent!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['unpaid_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Unpaid:</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-red-700 dark:text-red-400 border-r border-slate-300 dark:border-slate-600">{{ number_format($reportData['total_unpaid'], 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format($reportData['unpaid_count']) }} Pending</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
