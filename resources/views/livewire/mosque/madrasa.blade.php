@section('title', 'Madrasa Management')

<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Madrasa Management</h2>
                <p class="text-white/80 dark:text-white-400 mt-1 text-sm sm:text-base">Manage ustads, students, and payments</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-8 overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
            <div class="flex p-1.5 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/10 w-fit min-w-max">
                <button wire:click="setActiveTab('ustads')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'ustads' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Ustads
                </button>
                <button wire:click="setActiveTab('students')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'students' ? 'bg-blue-700 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Students
                </button>
                <button wire:click="setActiveTab('payments')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'payments' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payments
                </button>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input wire:model.live="search" type="text" placeholder="Search..." class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
        </div>

        <!-- Ustads Tab -->
        @if($activeTab === 'ustads')
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white dark:text-white">Ustads Management</h3>
                <button wire:click="openUstadModal" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Ustad
                </button>
            </div>

            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Specialization</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Experience</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($ustads as $ustad)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold">{{ strtoupper(substr($ustad->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ustad->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ustad->qualification }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $ustad->specialization ?? 'Not specified' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        <div>{{ $ustad->phone }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ustad->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $ustad->experience_years ?? 0 }} years</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ustad->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $ustad->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                            <button wire:click="viewUstad({{ $ustad->id }})" title="View Details" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                <span class="hidden sm:inline">View</span>
                                            </button>
                                            <button wire:click="editUstad({{ $ustad->id }})" title="Edit Ustad" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button wire:click="$dispatch('swal:confirm', {
                                                title: 'Delete Ustad?',
                                                text: 'Are you sure you want to delete this ustad? This action cannot be undone.',
                                                icon: 'warning',
                                                confirmButtonText: 'Yes, Delete',
                                                cancelButtonText: 'Cancel',
                                                eventName: 'deleteUstad',
                                                eventParams: [{{ $ustad->id }}]
                                            })" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No ustads found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $ustads->links() }}
                </div>
            </div>
        @endif

        <!-- Students Tab -->
        @if($activeTab === 'students')
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white dark:text-white">Students Management</h3>
                <button wire:click="openStudentModal" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Student
                </button>
            </div>

            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ustad</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Class Level</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Parent Contact</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student->gender }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $student->ustad?->name ?? 'Not assigned' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($student->class_level === 'Beginner') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($student->class_level === 'Intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                            {{ $student->class_level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        <div>{{ $student->parent_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student->parent_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                            <button wire:click="editStudent({{ $student->id }})" title="Edit Student" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button wire:click="$dispatch('swal:confirm', {
                                                title: 'Delete Student?',
                                                text: 'Are you sure you want to delete this student? This action cannot be undone.',
                                                icon: 'warning',
                                                confirmButtonText: 'Yes, Delete',
                                                cancelButtonText: 'Cancel',
                                                eventName: 'deleteStudent',
                                                eventParams: [{{ $student->id }}]
                                            })" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No students found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $students->links() }}
                </div>
            </div>
        @endif

        <!-- Payments Tab -->
        @if($activeTab === 'payments')
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white dark:text-white">Payment Records</h3>
                <button wire:click="openPaymentModal" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Record Payment
                </button>
            </div>

            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Payment Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $payment->student->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->student->parent_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">LKR {{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $payment->payment_method }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $payment->payment_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        @if($payment->payment_months && $payment->payment_year)
                                            @php
                                                $monthNames = [
                                                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
                                                    7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
                                                ];
                                                $months = collect($payment->payment_months)->map(function($month) use ($monthNames) {
                                                    return $monthNames[$month] ?? $month;
                                                })->join(', ');
                                            @endphp
                                            {{ $months }} {{ $payment->payment_year }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <button wire:click="$dispatch('swal:confirm', {
                                            title: 'Delete Payment?',
                                            text: 'Are you sure you want to delete this payment record? This action cannot be undone.',
                                            icon: 'warning',
                                            confirmButtonText: 'Yes, Delete',
                                            cancelButtonText: 'Cancel',
                                            eventName: 'deletePayment',
                                            eventParams: [{{ $payment->id }}]
                                        })" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No payments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $payments->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Ustad Modal -->
    @if($showUstadModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeUstadModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            @if($viewUstadMode)
                                View Ustad Details
                            @elseif($editUstadMode)
                                Edit Ustad
                            @else
                                Add New Ustad
                            @endif
                        </h3>
                        <button wire:click="closeUstadModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    @if($viewUstadMode)
                        <!-- View Mode -->
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Name
                                </label>
                                <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    {{ $ustad_name }}
                                </div>
                            </div>

                            <!-- Phone and Email (2 columns) -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Phone
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ $ustad_phone ?? 'Not provided' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Email
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ $ustad_email ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Specialization and Experience (2 columns) -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Specialization
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ $ustad_specialization ?? 'Not specified' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Experience (Years)
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ $ustad_experience_years ?? 0 }}
                                    </div>
                                </div>
                            </div>

                            <!-- Qualification and Salary (2 columns) -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Qualification
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ $ustad_qualification ?? 'Not specified' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Salary (LKR)
                                    </label>
                                    <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        {{ number_format($ustad_salary ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Joining Date -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Joining Date
                                </label>
                                <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    {{ $ustad_joining_date ? \Carbon\Carbon::parse($ustad_joining_date)->format('M d, Y') : 'Not specified' }}
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Address
                                </label>
                                <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white min-h-[2.5rem]">
                                    {{ $ustad_address ?? 'Not provided' }}
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Notes
                                </label>
                                <div class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white min-h-[2.5rem]">
                                    {{ $ustad_notes ?? 'No notes' }}
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center gap-2">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                                    Status:
                                </label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ustad_is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $ustad_is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <!-- Close Button -->
                            <div class="flex justify-end pt-4">
                                <button type="button" wire:click="closeUstadModal"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                    Close
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Edit/Add Mode -->
                        <form wire:submit.prevent="saveUstad" class="space-y-3">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="ustad_name" type="text" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('ustad_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone and Email (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone
                                </label>
                                <input wire:model="ustad_phone" type="tel"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input wire:model="ustad_email" type="email"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_email') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Specialization and Experience (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Specialization
                                </label>
                                <input wire:model="ustad_specialization" type="text" placeholder="e.g., Quran, Hadith"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_specialization') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Experience (Years)
                                </label>
                                <input wire:model="ustad_experience_years" type="number" min="0"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_experience_years') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Qualification and Salary (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Qualification
                                </label>
                                <input wire:model="ustad_qualification" type="text" placeholder="e.g., Hafiz, Alim"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_qualification') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Salary (LKR)
                                </label>
                                <input wire:model="ustad_salary" type="number" step="0.01" min="0"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('ustad_salary') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Joining Date -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Joining Date <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="ustad_joining_date" type="date" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('ustad_joining_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <textarea wire:model="ustad_address" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('ustad_address') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="ustad_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('ustad_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Active Checkbox -->
                        <div class="flex items-center gap-2">
                            <input wire:model="ustad_is_active" type="checkbox" id="ustad_is_active"
                                class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                            <label for="ustad_is_active" class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                Active
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeUstadModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold transition shadow-lg">
                                {{ $editUstadMode ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Student Modal -->
    @if($showStudentModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeStudentModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editStudentMode ? 'Edit Student' : 'Add New Student' }}</h3>
                        <button wire:click="closeStudentModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveStudent" class="space-y-3">
                        <!-- Student Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Student Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="student_name" type="text" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('student_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date of Birth and Gender (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Date of Birth
                                </label>
                                <input wire:model="student_date_of_birth" type="date"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('student_date_of_birth') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="student_gender" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('student_gender') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Assign Ustad and Class Level (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Assign Ustad
                                </label>
                                <select wire:model="student_ustad_id"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select Ustad (Optional)</option>
                                    @foreach($availableUstads as $ustad)
                                        <option value="{{ $ustad->id }}">{{ $ustad->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_ustad_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Class Level <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="student_class_level" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                </select>
                                @error('student_class_level') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Parent Name and Phone (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Parent Name
                                </label>
                                <input wire:model="student_parent_name" type="text"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('student_parent_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Parent Phone
                                </label>
                                <input wire:model="student_parent_phone" type="tel"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('student_parent_phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Enrollment Date -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Enrollment Date <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="student_enrollment_date" type="date" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('student_enrollment_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <textarea wire:model="student_address" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('student_address') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="student_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('student_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Active Checkbox -->
                        <div class="flex items-center gap-2">
                            <input wire:model="student_is_active" type="checkbox" id="student_is_active"
                                class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                            <label for="student_is_active" class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                Active Student
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeStudentModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold transition shadow-lg">
                                {{ $editStudentMode ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Modal -->
    @if($showPaymentModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closePaymentModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">Record Payment</h3>
                        <button wire:click="closePaymentModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="savePayment" class="space-y-3">
                        <!-- Student Selection -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Student <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="payment_student_id" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                <option value="">Select Student</option>
                                @foreach($students->items() as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->parent_name }}</option>
                                @endforeach
                            </select>
                            @error('payment_student_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Amount and Payment Date (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Amount (LKR) <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="payment_amount" type="number" step="0.01" min="0" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('payment_amount') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="payment_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                @error('payment_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Payment Method and Type (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="payment_method" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Online">Online</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Type <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="payment_type" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="Monthly Fee">Monthly Fee</option>
                                    <option value="Registration">Registration</option>
                                    <option value="Books">Books</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('payment_type') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Year and Months (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Year
                                </label>
                                <select wire:model="payment_year"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                                @error('payment_year') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Months (Multiple)
                                </label>
                                <select wire:model="payment_months" multiple
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                @error('payment_months') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Transaction ID -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Transaction ID
                            </label>
                            <input wire:model="payment_transaction_id" type="text"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500">
                            @error('payment_transaction_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="payment_notes" rows="2"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-green-500"></textarea>
                            @error('payment_notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closePaymentModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-semibold transition shadow-lg">
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    </div>
</div>
