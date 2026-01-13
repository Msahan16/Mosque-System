{{-- Overview Report - Professional Format --}}
<div class="space-y-6">
    {{-- Summary Statistics Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-blue-900 px-6 py-4 border-b-2 border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Mosque Overview Report</h2>
                    <p class="text-blue-100 text-sm mt-1">Comprehensive summary of all mosque activities</p>
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
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Count / Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    {{-- Families Section --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Families
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Registered Families</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['total_families'] ?? 0) }}</td>
                    </tr>
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">New Families (This Period)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400 text-right">+{{ number_format($reportData['new_families'] ?? 0) }}</td>
                    </tr>
                    <tr class="border-b-2 border-slate-300 dark:border-slate-600 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Members</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['total_members'] ?? 0) }}</td>
                    </tr>

                    {{-- Financial Section --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Donations
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Donations (This Period)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right">LKR {{ number_format($reportData['total_donations'] ?? 0, 2) }}</td>
                    </tr>
                    <tr class="border-b-2 border-slate-300 dark:border-slate-600 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Santha Payments (This Period)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700 dark:text-emerald-400 text-right">LKR {{ number_format($reportData['total_santhas_paid'] ?? 0, 2) }}</td>
                    </tr>

                    {{-- Madrasa Section --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-purple-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-700 dark:text-purple-400 border-r border-slate-200 dark:border-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Madrasa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Total Students</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['total_students'] ?? 0) }}</td>
                    </tr>
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-purple-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-700 dark:text-purple-400 border-r border-slate-200 dark:border-slate-700"></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">Active Ustads</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white text-right">{{ number_format($reportData['active_ustads'] ?? 0) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
