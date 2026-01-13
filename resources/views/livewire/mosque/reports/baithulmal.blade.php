{{-- Baithulmal Report - Professional Format --}}
<div class="space-y-6">
    {{-- Summary Statistics Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-blue-900 px-6 py-4 border-b-2 border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Baithulmal (Treasury) Report</h2>
                    <p class="text-blue-100 text-sm mt-1">Comprehensive income and expense management summary</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Report Period</p>
                    <p class="text-lg font-bold text-white">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    <p class="text-blue-200 text-sm">{{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} Days</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Description</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Amount / Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    {{-- Income Summary Section --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                                Income
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Income (This Period)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right">LKR {{ number_format($reportData['total_income'] ?? 0, 2) }}</td>
                    </tr>
                    <tr class="border-b-2 border-slate-300 dark:border-slate-600 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Number of Income Transactions</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['income_count'] ?? 0) }}</td>
                    </tr>

                    {{-- Expense Summary Section --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                                Expense
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Expense (This Period)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 text-right">LKR {{ number_format($reportData['total_expense'] ?? 0, 2) }}</td>
                    </tr>
                    <tr class="border-b-2 border-slate-300 dark:border-slate-600 hover:bg-red-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Number of Expense Transactions</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['expense_count'] ?? 0) }}</td>
                    </tr>

                    {{-- Net Balance Section --}}
                    <tr class="border-b-2 border-slate-400 dark:border-slate-500 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors bg-slate-50 dark:bg-slate-700/30">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Net Balance
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700">Income - Expense ({{ ($reportData['net_balance'] ?? 0) >= 0 ? 'Surplus' : 'Deficit' }})</td>
                        <td class="px-6 py-4 whitespace-nowrap text-base font-bold {{ ($reportData['net_balance'] ?? 0) >= 0 ? 'text-blue-700 dark:text-blue-400' : 'text-red-700 dark:text-red-400' }} text-right">LKR {{ number_format($reportData['net_balance'] ?? 0, 2) }}</td>
                    </tr>

                    {{-- Income by Category Section --}}
                    @if(!empty($reportData['income_by_category']))
                        <tr class="bg-emerald-50 dark:bg-emerald-900/10 border-b border-slate-200 dark:border-slate-700">
                            <td colspan="3" class="px-6 py-3 text-sm font-bold text-emerald-800 dark:text-emerald-300 uppercase tracking-wide">
                                Income Breakdown by Category
                            </td>
                        </tr>
                        @foreach($reportData['income_by_category'] as $category => $data)
                            <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700"></td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                    {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                    <span class="text-xs text-slate-500 dark:text-slate-500 ml-2">({{ $data['count'] }} transaction{{ $data['count'] > 1 ? 's' : '' }})</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400 text-right">LKR {{ number_format($data['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="border-b-2 border-slate-300 dark:border-slate-600">
                            <td colspan="3" class="py-2"></td>
                        </tr>
                    @endif

                    {{-- Expense by Category Section --}}
                    @if(!empty($reportData['expense_by_category']))
                        <tr class="bg-red-50 dark:bg-red-900/10 border-b border-slate-200 dark:border-slate-700">
                            <td colspan="3" class="px-6 py-3 text-sm font-bold text-red-800 dark:text-red-300 uppercase tracking-wide">
                                Expense Breakdown by Category
                            </td>
                        </tr>
                        @foreach($reportData['expense_by_category'] as $category => $data)
                            <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 border-r border-slate-200 dark:border-slate-700"></td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                    {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                    <span class="text-xs text-slate-500 dark:text-slate-500 ml-2">({{ $data['count'] }} transaction{{ $data['count'] > 1 ? 's' : '' }})</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 text-right">LKR {{ number_format($data['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Monthly Breakdown Table (if available) --}}
    @if(!empty($reportData['by_month']))
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
            {{-- Table Header --}}
            <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-4 border-b-2 border-blue-900">
                <h3 class="text-xl font-bold text-white">Monthly Breakdown</h3>
                <p class="text-blue-100 text-sm mt-1">Income and expense analysis by month</p>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Month</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Income</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Expense</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Net Balance</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800">
                        @foreach($reportData['by_month'] as $month => $data)
                            <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">
                                    {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400 text-right border-r border-slate-200 dark:border-slate-700">
                                    LKR {{ number_format($data['income'] ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 text-right border-r border-slate-200 dark:border-slate-700">
                                    LKR {{ number_format($data['expense'] ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ (($data['income'] ?? 0) - ($data['expense'] ?? 0)) >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }} text-right">
                                    LKR {{ number_format(($data['income'] ?? 0) - ($data['expense'] ?? 0), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Detailed Transactions Table --}}
    @if(!empty($reportData['transactions_list']) && count($reportData['transactions_list']) > 0)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
            {{-- Table Header --}}
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 border-b-2 border-slate-900">
                <h3 class="text-xl font-bold text-white">Detailed Transaction List</h3>
                <p class="text-slate-100 text-sm mt-1">Complete record of all transactions in this period</p>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Description</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Payment Method</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800">
                        @foreach($reportData['transactions_list'] as $transaction)
                            <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700">
                                    {{ $transaction->transaction_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-slate-200 dark:border-slate-700">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700">
                                    {{ str_replace('_', ' ', ucwords($transaction->category, '_')) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700">
                                    {{ $transaction->description ?? '-' }}
                                    @if($transaction->reference_number)
                                        <br><span class="text-xs text-slate-500 dark:text-slate-400">Ref: {{ $transaction->reference_number }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700">
                                    {{ $transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} LKR {{ number_format($transaction->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
