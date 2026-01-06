{{-- Families Report - Professional Format --}}
<div class="space-y-6">
    {{-- Professional Data Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-4 border-b-2 border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Registered Families Report</h2>
                    <p class="text-blue-100 text-sm mt-1">Complete family registration records for the selected period</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Total Families</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($reportData['total'] ?? 0) }}</p>
                    <p class="text-blue-200 text-sm">{{ number_format($reportData['total_members'] ?? 0) }} Total Members</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Family ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Head of Family</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Phone Number</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Address</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Members</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Registered Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['families_list'] ?? [] as $index => $family)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700">{{ $family->family_id ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $family->family_head_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $family->phone }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $family->address ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-center text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-bold">{{ $family->total_members }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($family->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No families registered in this period</p>
                                <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">Try adjusting the date range to see more results</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['families_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Families:</td>
                        <td class="px-6 py-4 text-center text-lg font-bold text-purple-700 dark:text-purple-400 border-r border-slate-300 dark:border-slate-600">{{ number_format(collect($reportData['families_list'])->sum('total_members')) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400">{{ number_format(count($reportData['families_list'])) }} Records</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
