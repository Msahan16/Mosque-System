{{-- Ramadan Porridge Report - Professional Format --}}
<div class="space-y-6">
    {{-- Porridge Sponsors Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-orange-700 to-orange-800 px-6 py-4 border-b-2 border-orange-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Ramadan Porridge Sponsors Report</h2>
                    <p class="text-orange-100 text-sm mt-1">Complete sponsorship records for Ramadan porridge program</p>
                </div>
                <div class="text-right">
                    <p class="text-orange-100 text-xs uppercase tracking-wide">Total Amount</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($reportData['total_amount'] ?? 0) }}</p>
                    <p class="text-orange-200 text-sm">{{ number_format($reportData['total_sponsors'] ?? 0) }} Sponsors</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Sponsor Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Phone Number</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Ramadan Year</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Day Number</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Sponsor Type</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Amount (LKR)</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['sponsors_list'] ?? [] as $index => $sponsor)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $sponsor->sponsor_name ?? 'Anonymous' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $sponsor->sponsor_phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                <span class="px-2 py-1 rounded-md bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs font-semibold">{{ $sponsor->ramadan_year }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 font-bold">{{ $sponsor->day_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                <span class="px-2 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-semibold uppercase">{{ $sponsor->sponsor_type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right border-r border-slate-200 dark:border-slate-700">{{ number_format($sponsor->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($sponsor->payment_status === 'paid')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">PAID</span>
                                @elseif($sponsor->payment_status === 'pending')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">PENDING</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ strtoupper($sponsor->payment_status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No porridge sponsors in this period</p>
                                <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">Try adjusting the date range to see more results</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['sponsors_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="6" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Amount:</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-300 dark:border-slate-600">{{ number_format($reportData['total_amount'], 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format($reportData['total_sponsors']) }} Sponsors</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
