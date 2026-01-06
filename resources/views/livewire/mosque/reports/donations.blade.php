{{-- Donations Report - Professional Format --}}
@php
    $isReceived = ($reportData['transaction_type'] ?? 'received') === 'received';
    $title = $isReceived ? 'Donations Received' : 'Donations Given';
@endphp

<div class="space-y-6">
    {{-- Professional Data Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-4 border-b-2 border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $title }} Report</h2>
                    <p class="text-blue-100 text-sm mt-1">Detailed transaction records for the selected period</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Total Amount</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($reportData['total_amount'] ?? 0) }}</p>
                    <p class="text-blue-200 text-sm">{{ number_format($reportData['total_count'] ?? 0) }} Transactions</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">{{ $isReceived ? 'Donor' : 'Recipient' }} Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Payment Method</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Amount (LKR)</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['donations_list'] ?? [] as $index => $donation)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $donation->donor_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $donation->donor_phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                <span class="px-2 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-semibold">{{ $donation->donation_type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $donation->payment_method }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right border-r border-slate-200 dark:border-slate-700">{{ number_format($donation->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($donation->donation_date)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No {{ $isReceived ? 'donations received' : 'donations given' }} in this period</p>
                                <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">Try adjusting the date range to see more results</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['donations_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total:</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-300 dark:border-slate-600">{{ number_format($reportData['total_amount'], 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format($reportData['total_count']) }} Records</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
