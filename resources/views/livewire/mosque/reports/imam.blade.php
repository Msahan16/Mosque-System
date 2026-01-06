{{-- Imam Management Report - Professional Format --}}
<div class="space-y-6">
    {{-- Financial Records Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-purple-700 to-purple-800 px-6 py-4 border-b-2 border-purple-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Imam Financial Records</h2>
                    <p class="text-purple-100 text-sm mt-1">Salary and advance payment records</p>
                </div>
                <div class="text-right">
                    <p class="text-purple-100 text-xs uppercase tracking-wide">Total Payments</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($reportData['total_payments'] ?? 0) }}</p>
                    <p class="text-purple-200 text-sm">{{ number_format(count($reportData['financials_list'] ?? [])) }} Records</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Imam Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Type</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Amount (LKR)</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Record Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Payment Method</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['financials_list'] ?? [] as $index => $record)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-purple-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $record->imam->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                <span class="px-2 py-1 rounded-md {{ $record->type === 'salary' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300' }} text-xs font-semibold uppercase">{{ $record->type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-700 dark:text-purple-400 text-right border-r border-slate-200 dark:border-slate-700">{{ number_format($record->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $record->payment_method ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($record->status === 'paid')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">PAID</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ strtoupper($record->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No financial records in this period</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['financials_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Payments:</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-purple-700 dark:text-purple-400 border-r border-slate-300 dark:border-slate-600">{{ number_format(collect($reportData['financials_list'])->sum('amount'), 2) }}</td>
                        <td colspan="3" class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format(count($reportData['financials_list'])) }} Records</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
