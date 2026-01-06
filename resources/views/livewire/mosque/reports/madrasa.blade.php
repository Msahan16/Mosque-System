{{-- Madrasa Report - Professional Format --}}
<div class="space-y-6">
    {{-- Students Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-4 border-b-2 border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Madrasa Students Report</h2>
                    <p class="text-blue-100 text-sm mt-1">Complete student enrollment records</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Total Students</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($reportData['total_students'] ?? 0) }}</p>
                    <p class="text-blue-200 text-sm">{{ number_format($reportData['active_students'] ?? 0) }} Active</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Student Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Class Level</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Guardian</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Phone</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['students_list'] ?? [] as $index => $student)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">
                                <span class="px-2 py-1 rounded-md bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs font-semibold">{{ $student->class_level }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $student->guardian_name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $student->phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($student->is_active)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">ACTIVE</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-400">INACTIVE</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No students enrolled</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['students_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Students:</td>
                        <td class="px-6 py-4 text-center text-lg font-bold text-blue-700 dark:text-blue-400">{{ number_format(count($reportData['students_list'])) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Ustads Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600">
        {{-- Table Header --}}
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-800 px-6 py-4 border-b-2 border-emerald-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Madrasa Ustads Report</h2>
                    <p class="text-emerald-100 text-sm mt-1">Teaching staff records</p>
                </div>
                <div class="text-right">
                    <p class="text-emerald-100 text-xs uppercase tracking-wide">Total Ustads</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($reportData['total_ustads'] ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">{{ number_format($reportData['active_ustads'] ?? 0) }} Active</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Ustad Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Qualification</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600">Phone</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($reportData['ustads_list'] ?? [] as $index => $ustad)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700">{{ $ustad->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $ustad->qualification ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700">{{ $ustad->phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($ustad->is_active)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">ACTIVE</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-400">INACTIVE</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center bg-slate-50 dark:bg-slate-800/50">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="text-lg font-semibold text-slate-500 dark:text-slate-400">No ustads registered</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($reportData['ustads_list'] ?? []) > 0)
                <tfoot>
                    <tr class="bg-slate-100 dark:bg-slate-700 border-t-2 border-slate-400 dark:border-slate-500">
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-200 uppercase">Total Ustads:</td>
                        <td class="px-6 py-4 text-center text-lg font-bold text-emerald-700 dark:text-emerald-400">{{ number_format(count($reportData['ustads_list'])) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
