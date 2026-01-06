{{-- Families Report --}}
<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 border-l-4 border-blue-600">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Total Families</p>
            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($reportData['total'] ?? 0) }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 border-l-4 border-emerald-600">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">New Registrations</p>
            <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($reportData['new_registrations'] ?? 0) }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 border-l-4 border-purple-600">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Total Members</p>
            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($reportData['total_members'] ?? 0) }}</p>
        </div>
    </div>

    {{-- Families List --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Registered Families</h3>
            <p class="text-blue-100 text-sm mt-1">Families registered during this period</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Family ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Head of Family</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Members</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['families_list'] ?? [] as $family)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 dark:text-blue-400">{{ $family->family_id ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $family->family_head_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $family->total_members }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $family->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($family->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                No families registered in this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
