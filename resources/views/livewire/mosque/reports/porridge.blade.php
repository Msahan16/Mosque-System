{{-- Ramadan Porridge Report --}}
<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-orange-100 text-sm mb-2">Total Sponsors</p>
            <p class="text-4xl font-bold">{{ number_format($reportData['total_sponsors'] ?? 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-emerald-100 text-sm mb-2">Total Amount</p>
            <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_amount'] ?? 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-purple-100 text-sm mb-2">Days Covered</p>
            <p class="text-4xl font-bold">{{ number_format($reportData['days_covered'] ?? 0) }}</p>
        </div>
    </div>

    {{-- Sponsors List --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Porridge Sponsors</h3>
            <p class="text-orange-100 text-sm mt-1">Generous contributors during Ramadan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Sponsor Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Sponsored Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['sponsors_list'] ?? [] as $sponsor)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $sponsor->sponsor_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $sponsor->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($sponsor->sponsored_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400">LKR {{ number_format($sponsor->amount) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $sponsor->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                No sponsors in this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
