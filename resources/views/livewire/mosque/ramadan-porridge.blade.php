<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Ramadan Porridge Distribution</h2>
                <p class="text-white/80 mt-1 text-sm sm:text-base">Track daily porridge sponsorship and distribution</p>
            </div>
            <div class="flex items-center gap-4">
                <select wire:model.live="ramadanYear" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white">
                    @for($year = 2024; $year <= 2030; $year++)
                        <option value="{{ $year }}">{{ $year }} Ramadan</option>
                    @endfor
                </select>
                <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-700 transition shadow-lg text-sm sm:text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Sponsor
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-100 text-sm font-medium">Total Sponsors</span>
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $totalSponsors }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-green-100 text-sm font-medium">Total Porridges</span>
                    <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalPorridges) }}</p>                <p class="text-xs text-green-200 mt-1">1 per day</p>            </div>

            <div class="bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-amber-100 text-sm font-medium">Total Amount</span>
                    <svg class="w-8 h-8 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">LKR {{ number_format($totalAmount, 2) }}</p>
                <p class="text-xs text-amber-200 mt-1">Paid: LKR {{ number_format($paidAmount, 2) }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-purple-100 text-sm font-medium">Distributed</span>
                    <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($distributedCount) }}</p>
                <p class="text-xs text-purple-200 mt-1">of {{ number_format($totalPorridges) }} total</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 flex gap-2 border-b border-gray-300 dark:border-gray-700">
        <button wire:click="setActiveTab('overview')" 
            class="px-4 py-3 font-medium text-sm text-white transition {{ $activeTab === 'overview' ? 'border-b-2 border-emerald-600 dark:border-emerald-400' : 'hover:opacity-80' }}">
            Overview
        </button>
        <button wire:click="setActiveTab('sponsors')" 
            class="px-4 py-3 font-medium text-sm text-white transition {{ $activeTab === 'sponsors' ? 'border-b-2 border-emerald-600 dark:border-emerald-400' : 'hover:opacity-80' }}">
            Sponsors
        </button>
    </div>

    <!-- Overview Tab -->
    @if($activeTab === 'overview')
        <div class="space-y-6">
            <!-- 30-Day Calendar -->
            <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Ramadan {{ $ramadanYear }} - 30 Days Porridge Distribution</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Click on any day to add sponsors or view details</p>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                        @for($day = 1; $day <= 30; $day++)
                            <div class="relative">
                                @if($daySummary[$day]['is_budget_full'])
                                    <div class="w-full p-4 rounded-lg border-2 border-emerald-500 bg-emerald-500/10 {{ $daySummary[$day]['is_distributed'] ? 'ring-2 ring-green-500' : '' }}">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Day {{ $day }}</div>
                                            <div class="text-sm text-emerald-400 font-medium">
                                                Budget Full (LKR {{ number_format($daySummary[$day]['daily_budget'], 2) }})
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $daySummary[$day]['sponsors_count'] }} sponsors
                                            </div>
                                            @if($daySummary[$day]['is_distributed'])
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                        Distributed
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                        Sponsored
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <button wire:click="openModal({{ $day }})"
                                            class="w-full p-4 rounded-lg border-2 transition-all hover:scale-105
                                                   {{ $daySummary[$day]['total_porridges'] > 0 ? 'border-emerald-500 bg-emerald-500/10' : 'border-gray-600 bg-gray-800/50 hover:border-emerald-400' }}
                                                   {{ $daySummary[$day]['is_distributed'] ? 'ring-2 ring-green-500' : '' }}">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Day {{ $day }}</div>
                                            @if($daySummary[$day]['total_porridges'] > 0)
                                                <div class="text-sm text-emerald-400 font-medium">
                                                    LKR {{ number_format($daySummary[$day]['total_amount'], 2) }} collected
                                                </div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ $daySummary[$day]['sponsors_count'] }} sponsors
                                                </div>
                                                <div class="text-xs text-blue-400 mt-1">
                                                    LKR {{ number_format($daySummary[$day]['remaining_budget'], 2) }} remaining
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500">Available for sponsorship</div>
                                               
                                            @endif
                                        </div>
                                    </button>
                                @endif

                                @if($daySummary[$day]['sponsors_count'] > 0)
                                    <div class="mt-2 space-y-1">
                                        @foreach($daySummary[$day]['sponsors'] as $sponsor)
                                            <div class="text-xs bg-gray-200 dark:bg-gray-700 rounded px-2 py-1">
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $sponsor->sponsor_name }}</div>
                                                <div class="text-gray-600 dark:text-gray-400">{{ $sponsor->porridge_count }} × LKR {{ number_format($sponsor->amount_per_porridge, 2) }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Sponsors Tab -->
    @if($activeTab === 'sponsors')
        <!-- Search and Filters -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search sponsors..."
                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select wire:model.live="selectedDay" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white">
                    <option value="">All Days</option>
                    @for($day = 1; $day <= 30; $day++)
                        <option value="{{ $day }}">Day {{ $day }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Sponsors Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Sponsor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Distribution</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($sponsors as $sponsor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                        Day {{ $sponsor->day_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $sponsor->sponsor_name ? strtoupper(substr($sponsor->sponsor_name, 0, 1)) : 'A' }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $sponsor->display_name }}</div>
                                            @if($sponsor->sponsor_phone)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $sponsor->sponsor_phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $sponsor->sponsor_type === 'group' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                        {{ ucfirst($sponsor->sponsor_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">LKR {{ number_format($sponsor->total_amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($sponsor->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($sponsor->payment_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ ucfirst($sponsor->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($sponsor->distribution_status === 'distributed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($sponsor->distribution_status === 'pending') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ ucfirst($sponsor->distribution_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="space-x-2">
                                        @if($sponsor->payment_status !== 'paid')
                                            <button wire:click="markAsPaid({{ $sponsor->id }})" class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">
                                                Mark Paid
                                            </button>
                                        @endif
                                        @if($sponsor->distribution_status !== 'distributed')
                                            <button wire:click="markAsDistributed({{ $sponsor->id }})" class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                                Mark Distributed
                                            </button>
                                        @endif
                                        <button wire:click="editSponsor({{ $sponsor->id }})" class="inline-flex items-center px-2 py-1 bg-emerald-600 text-white text-xs font-medium rounded hover:bg-emerald-700 transition">
                                            Edit
                                        </button>
                                        <button wire:click="$dispatch('swal:confirm', {
                                            title: 'Delete Sponsor?',
                                            text: 'Are you sure you want to delete this porridge sponsorship? This action cannot be undone.',
                                            icon: 'warning',
                                            confirmButtonText: 'Yes, Delete',
                                            cancelButtonText: 'Cancel',
                                            eventName: 'deleteSponsor',
                                            eventParams: [{{ $sponsor->id }}]
                                        })" class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">No porridge sponsors found</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add Sponsor" to add the first porridge sponsorship</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($sponsors->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $sponsors->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            @if($editMode)
                                Edit Porridge Sponsor
                            @else
                                Add Porridge Sponsor
                            @endif
                        </h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveSponsor" class="space-y-3">
                        <!-- Day Number -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ramadan Day <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="day_number" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                @for($day = 1; $day <= 30; $day++)
                                    <option value="{{ $day }}">Day {{ $day }}</option>
                                @endfor
                            </select>
                            @error('day_number') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Anonymous Checkbox -->
                        <div>
                            <label class="flex items-center">
                                <input wire:model.live="is_anonymous" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-2 text-xs font-medium text-gray-700 dark:text-gray-300">Anonymous Sponsor</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Check this if the sponsor wishes to remain anonymous</p>
                        </div>

                        <!-- Sponsor Name and Type (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Sponsor Name <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="sponsor_name" type="text" {{ $is_anonymous ? 'disabled' : 'required' }} placeholder="{{ $is_anonymous ? 'Anonymous' : 'Individual or Group name' }}"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500 {{ $is_anonymous ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed' : '' }}">
                                @error('sponsor_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="sponsor_type" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                    <option value="individual">Individual</option>
                                    <option value="group">Group</option>
                                </select>
                                @error('sponsor_type') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Phone Number
                            </label>
                            <input wire:model="sponsor_phone" type="tel" placeholder="Contact phone"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                            @error('sponsor_phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                      

                        <!-- Custom Amount per Porridge -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Amount per Porridge (LKR)
                            </label>
                            <div class="relative">
                                <input wire:model="custom_amount_per_porridge" type="number" step="0.01" min="0" :max="$porridgeAmount"
                                    class="w-full pl-12 pr-4 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500"
                                    placeholder="Leave empty to use default: {{ number_format($porridgeAmount, 2) }}">
                            </div>
                            @error('custom_amount_per_porridge') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Maximum allowed: LKR {{ number_format($porridgeAmount, 2) }} (from settings). Leave empty to use default amount.
                            </p>
                        </div>

                        <!-- Total Amount Display -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount:</span>
                                <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                    LKR {{ number_format(($porridge_count ?? 0) * ($custom_amount_per_porridge ?: $porridgeAmount), 2) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                @if($custom_amount_per_porridge)
                                    Custom amount: LKR {{ number_format($custom_amount_per_porridge, 2) }} per porridge
                                @else
                                    Using default: LKR {{ number_format($porridgeAmount, 2) }} per porridge (from settings)
                                @endif
                            </div>
                        </div>

                        <!-- Payment Status and Method (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Status <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="payment_status" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                @error('payment_status') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method
                                </label>
                                <select wire:model="payment_method"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                    <option value="">Select Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Distribution Status -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Distribution Status <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="distribution_status" required
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                <option value="pending">Pending</option>
                                <option value="distributed">Distributed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('distribution_status') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="notes" rows="2" placeholder="Additional notes..."
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500"></textarea>
                            @error('notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold transition shadow-lg">
                                {{ $editMode ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
