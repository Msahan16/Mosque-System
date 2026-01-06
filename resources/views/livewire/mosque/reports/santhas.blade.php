{{-- Santha Payments Report --}}
<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-emerald-100 text-sm mb-2">Total Paid</p>
            <p class="text-3xl font-bold">LKR {{ number_format($reportData['total_paid'] ?? 0) }}</p>
            <p class="text-emerald-100 text-xs mt-2">{{ number_format($reportData['paid_count'] ?? 0) }} payments</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-red-100 text-sm mb-2">Total Unpaid</p>
            <p class="text-3xl font-bold">LKR {{ number_format($reportData['total_unpaid'] ?? 0) }}</p>
            <p class="text-red-100 text-xs mt-2">{{ number_format($reportData['unpaid_count'] ?? 0) }} pending</p>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-blue-100 text-sm mb-2">Payment Rate</p>
            <p class="text-3xl font-bold">
                {{ $reportData['paid_count'] + $reportData['unpaid_count'] > 0 ? number_format(($reportData['paid_count'] / ($reportData['paid_count'] + $reportData['unpaid_count'])) * 100, 1) : 0 }}%
            </p>
            <p class="text-blue-100 text-xs mt-2">Collection efficiency</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-purple-100 text-sm mb-2">Total Families</p>
            <p class="text-3xl font-bold">{{ number_format(($reportData['paid_count'] ?? 0) + ($reportData['unpaid_count'] ?? 0)) }}</p>
            <p class="text-purple-100 text-xs mt-2">Registered for Santha</p>
        </div>
    </div>

    {{-- Paid Santhas --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Paid Santhas</h3>
            <p class="text-emerald-100 text-sm mt-1">Payments received during this period</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Family</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Month/Year</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Payment Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['paid_list'] ?? [] as $santha)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $santha->family->family_head_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $santha->month }} {{ $santha->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400">LKR {{ number_format($santha->amount) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($santha->payment_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    Paid
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                No paid santhas in this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Unpaid Santhas --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Unpaid Santhas</h3>
            <p class="text-red-100 text-sm mt-1">Pending payments requiring attention</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Family</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Month/Year</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Amount Due</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['unpaid_list'] ?? [] as $santha)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $santha->family->family_head_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $santha->month }} {{ $santha->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400">LKR {{ number_format($santha->amount) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Unpaid
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-emerald-500 dark:text-emerald-400">
                                ✨ All santhas are paid! Excellent!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
