{{-- Imam Management Report --}}
<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-blue-100 text-sm mb-2">Total Schedules</p>
            <p class="text-4xl font-bold">{{ number_format($reportData['total_schedules'] ?? 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-emerald-100 text-sm mb-2">Total Payments</p>
            <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_payments'] ?? 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-xl p-6 text-white">
            <p class="text-red-100 text-sm mb-2">Total Expenses</p>
            <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_expenses'] ?? 0) }}</p>
        </div>
    </div>

    {{-- Schedules by Imam --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Schedules by Imam</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($reportData['by_imam'] ?? [] as $imam => $count)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 text-center border border-blue-200 dark:border-blue-700">
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">{{ $imam }}</p>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $count }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">schedules</p>
                    </div>
                @empty
                    <p class="text-slate-500 dark:text-slate-400 col-span-4 text-center py-4">No schedule data available</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Financial Records --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Financial Records</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['financials_list'] ?? [] as $record)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $record->type === 'salary' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ ucfirst($record->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-900 dark:text-white">{{ $record->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $record->type === 'salary' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                LKR {{ number_format($record->amount) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                No financial records in this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
