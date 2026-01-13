@section('title', 'Donation Management')

<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Donation Management</h2>
                <p class="text-white/80 dark:text-gray-400 mt-1 text-sm sm:text-base">Track incoming and outgoing donations</p>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button wire:click="openModal('received')" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 transition shadow-lg text-sm sm:text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Receive
                </button>
                <button wire:click="openModal('given')" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg text-sm sm:text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Give
                </button>
            </div>
        </div>

        <!-- Type Filter Tabs -->
        <div class="mb-8 overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
            <div class="flex p-1.5 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/10 w-fit min-w-max">
                <button wire:click="$set('filterType', 'received')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $filterType === 'received' ? 'bg-green-600 text-white shadow-lg shadow-green-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Donations Received
                </button>
                <button wire:click="$set('filterType', 'given')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $filterType === 'given' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Donations Given
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Purpose</label>
                <select wire:model.live="filterPurpose" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">All Purposes</option>
                    <option value="general">General</option>
                    <option value="construction">Construction</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="charity">Charity</option>
                    <option value="ramadan">Ramadan</option>
                    <option value="eid">Eid</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Payment Method</label>
                <select wire:model.live="filterMethod" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                    <option value="check">Check</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-white dark:text-gray-300 mb-2">Search</label>
                <input wire:model.live="search" type="text" placeholder="Search by donor name..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500">
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($filterType === 'received')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-100 text-sm font-medium">Total Received</span>
                        <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($totalReceivedDonations, 0) }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-emerald-500 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-green-100 text-sm font-medium">This Month</span>
                        <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($thisMonthReceivedDonations, 0) }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-cyan-500 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-sm font-medium">Total Donors</span>
                        <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $totalReceivedDonors }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-emerald-100 text-sm font-medium">Average</span>
                        <svg class="w-8 h-8 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($averageReceivedDonation, 0) }}</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-sm font-medium">Total Given</span>
                        <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($totalGivenDonations, 0) }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-sm font-medium">This Month</span>
                        <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($thisMonthGivenDonations, 0) }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-sm font-medium">Families Helped</span>
                        <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $totalGivenFamilies }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-blue-100 text-sm font-medium">Average</span>
                        <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">LKR{{ number_format($averageGivenDonation, 0) }}</p>
                </div>
            </div>
        @endif

        <!-- Donations Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r {{ $filterType === 'received' ? 'from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30' : 'from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30' }}">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Receipt #</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ $filterType === 'received' ? 'Donor' : 'Recipient' }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ $filterType === 'received' ? 'Contact' : 'Family' }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Purpose</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($donations as $donation)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono text-amber-600 dark:text-amber-400">{{ $donation->receipt_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br {{ $filterType === 'received' ? 'from-green-400 to-green-600' : 'from-blue-400 to-blue-600' }} rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($filterType === 'received' ? $donation->donor_name : ($donation->family ? $donation->family->family_head_name : $donation->donor_name), 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $filterType === 'received' ? $donation->donor_name : ($donation->family ? $donation->family->family_head_name : $donation->donor_name) }}
                                            </div>
                                            @if($filterType === 'received' && $donation->is_anonymous)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">(Anonymous)</span>
                                            @elseif($filterType === 'given' && $donation->family)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $donation->family->phone }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($filterType === 'received')
                                        @if(!$donation->is_anonymous)
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $donation->donor_phone }}</div>
                                            @if($donation->donor_email)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $donation->donor_email }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-400">Anonymous</span>
                                        @endif
                                    @else
                                        @if($donation->family)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400">
                                                {{ $donation->family->family_head_name }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-amber-600 dark:text-amber-400">LKR{{ number_format($donation->amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ ucfirst($donation->purpose) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $donation->donation_date->format('d M, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $donation->payment_method == 'cash' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                        {{ ucfirst($donation->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                        <button wire:click="editDonation({{ $donation->id }})" title="Edit Donation" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-amber-600 text-white text-xs rounded hover:bg-amber-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="viewReceipt({{ $donation->id }})" title="View Receipt" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            <span class="hidden sm:inline">View</span>
                                        </button>
                                        <button onclick="confirmDelete('confirmDeleteDonation', {{ $donation->id }}, 'Delete Donation?', 'This will permanently delete this donation record. This action cannot be undone.')" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">No donations recorded yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Record Donation" to add a donation</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($donations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r {{ $transaction_type === 'received' ? 'from-green-600 to-emerald-600' : 'from-blue-600 to-cyan-600' }} text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            {{ $editMode ? 'Edit Donation' : ($transaction_type === 'received' ? 'Receive Donation' : 'Give Donation') }}
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
                    <form wire:submit.prevent="saveDonation" class="space-y-3">
                        <!-- Donor Name and Amount (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ $transaction_type === 'received' ? 'Donor' : 'Source' }} <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="donor_name" type="text" required
                                    placeholder="Name"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-{{ $transaction_type === 'received' ? 'green' : 'blue' }}-500">
                                @error('donor_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Amount (LKR) <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="amount" type="number" step="0.01" required placeholder="0"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('amount') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Family (Single row) -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Family
                            </label>
                            <div class="relative">
                                <input 
                                    type="text"
                                    wire:model.live="familySearch"
                                    wire:focus="$set('showFamilyDropdown', true)"
                                    placeholder="Search by name, phone, or ID..."
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-{{ $transaction_type === 'received' ? 'green' : 'blue' }}-500">
                                
                                @if($family_id)
                                    <button 
                                        type="button"
                                        wire:click="clearFamily"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                @endif

                                @if($showFamilyDropdown && !empty($familySearch))
                                    <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-xl max-h-60 overflow-auto">
                                        @forelse($this->filteredFamilies() as $family)
                                            <button 
                                                type="button"
                                                wire:click="selectFamily({{ $family->id }}, '{{ $family->family_head_name }}')"
                                                class="w-full px-3 py-2 text-left hover:bg-blue-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="font-medium text-gray-900 dark:text-white text-xs">{{ $family->family_head_name }}</div>
                                                        <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                            @if($family->phone)
                                                                <span>{{ $family->phone }}</span>
                                                            @endif
                                                            @if($family->family_id)
                                                                <span>ID: {{ $family->family_id }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($family_id == $family->id)
                                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </button>
                                        @empty
                                            <div class="px-3 py-4 text-center text-gray-500 dark:text-gray-400">
                                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                                <p class="text-xs font-medium">No families found</p>
                                            </div>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                            @error('family_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            
                            @if($family_id)
                                <p class="mt-1 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Family selected
                                </p>
                            @endif
                        </div>

                        <!-- Type and Purpose (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="donation_type" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                    <option value="">Select</option>
                                    <option value="cash">Cash</option>
                                    <option value="zakat">Zakat</option>
                                    <option value="sadaqah">Sadaqah</option>
                                    <option value="waqf">Waqf</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('donation_type') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Purpose <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="purpose" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                    <option value="">Select</option>
                                    <option value="general">General</option>
                                    <option value="construction">Construction</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="charity">Charity</option>
                                    <option value="ramadan">Ramadan</option>
                                    <option value="eid">Eid</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('purpose') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Payment Method and Date (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Method <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="payment_method" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="check">Check</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="donation_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                @error('donation_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Contact Info (2 columns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone
                                </label>
                                <input wire:model="donor_phone" type="tel" placeholder="Phone"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                @error('donor_phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input wire:model="donor_email" type="email" placeholder="Email"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500">
                                @error('donor_email') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Anonymous Donation -->
                        <div class="flex items-center gap-2">
                            <input wire:model="is_anonymous" type="checkbox" id="is_anonymous"
                                class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                            <label for="is_anonymous" class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                Anonymous
                            </label>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="notes" rows="1"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-amber-500" placeholder="Optional notes..."></textarea>
                            @error('notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-3 py-1.5 text-xs bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-3 py-1.5 text-xs {{ $transaction_type === 'received' ? 'bg-gradient-to-r from-emerald-600 to-emerald-800' : 'bg-gradient-to-r from-blue-600 to-blue-800' }} text-white rounded-lg hover:opacity-90 font-semibold transition shadow-lg">
                                {{ $editMode ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Donation Receipt Modal -->
    @if($showReceiptModal && $viewingDonation)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Receipt</h3>
                    <div class="space-x-2">
                        <button onclick="printDonationReceipt()" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Print</button>
                        <button onclick="downloadDonationReceipt()" class="px-3 py-1 bg-green-600 text-white rounded text-xs">Download</button>
                        <button wire:click="closeReceiptModal" class="px-3 py-1 bg-gray-300 text-gray-800 rounded text-xs">Close</button>
                    </div>
                </div>

                <div id="donation-receipt-content" style="background:#ffffff;padding:22px;color:#111827;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;max-width:640px;margin:0 auto;">
                    <div style="text-align:center;margin-bottom:8px;">
                        <h2 style="font-size:20px;margin:0 0 4px 0;font-weight:700;color:#0f172a;">{{ $viewingDonation['mosque_name'] }}</h2>
                        <p style="margin:0;color:#6b7280;font-size:13px;">Donation Receipt</p>
                    </div>

                    <table style="width:100%;border-collapse:collapse;margin-top:12px;">
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Receipt #</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingDonation['receipt_number'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Date</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingDonation['donation_date'] }}</td>
                        </tr>
                    </table>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    <div style="color:#374151;font-size:14px;line-height:1.5;margin-bottom:10px;">
                        <div><strong>Donor:</strong> {{ $viewingDonation['donor_name'] }}</div>
                        <div><strong>Phone:</strong> {{ $viewingDonation['donor_phone'] }}</div>
                        @if(!empty($viewingDonation['family_name']))
                            <div><strong>Family:</strong> {{ $viewingDonation['family_name'] }}</div>
                        @endif
                    </div>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                        <div style="font-weight:600;color:#111827;">Amount</div>
                        <div style="font-size:18px;font-weight:700;color:#0f172a;">LKR{{ number_format($viewingDonation['amount'], 2) }}</div>
                    </div>
                    <div style="color:#6b7280;margin-top:8px;font-size:13px;">Purpose: {{ ucfirst($viewingDonation['purpose'] ?? '') }}</div>
                    <div style="color:#6b7280;margin-top:6px;font-size:13px;">Method: {{ ucfirst($viewingDonation['payment_method']) }}</div>
                    @if(!empty($viewingDonation['notes']))
                        <div style="margin-top:8px;font-size:13px;color:#374151;">Notes: {{ $viewingDonation['notes'] }}</div>
                    @endif

                    <div style="text-align:left;color:#9ca3af;margin-top:16px;font-size:12px;">This receipt is generated by {{ config('app.name') }}.</div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function _getDonationPrintableHtml() {
            const content = document.getElementById('donation-receipt-content');
            if (!content) return '';

            const clone = content.cloneNode(true);
            function sanitize(node) {
                if (node.className) {
                    node.className = node.className.replace(/\bdark:[^\s]+\b/g, '').replace(/\bbg-[^\s]+\b/g, '').replace(/\btext-[^\s]+\b/g, '');
                }
                Array.from(node.children || []).forEach(child => sanitize(child));
            }
            sanitize(clone);

            const wrapperStyle = [
                'width:640px',
                'margin:0 auto',
                'padding:20px',
                'background:#ffffff',
                'color:#111827',
                "font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial",
            ].join(';');

            return `<!doctype html><html><head><meta charset="utf-8"><title>Receipt</title>` +
                '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">' +
                `<style>body{margin:0;padding:20px;background:#f3f4f6} .receipt-container{${wrapperStyle}} .text-center{text-align:center} .font-bold{font-weight:700}</style>` +
                '</head><body><div class="receipt-container">' + clone.innerHTML + '</div></body></html>';
        }

        function printDonationReceipt() {
            const html = _getDonationPrintableHtml();
            if (!html) return;
            const w = window.open('', '_blank');
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.focus();
            setTimeout(() => { w.print(); }, 600);
        }

        function downloadDonationReceipt() {
            const printableHtml = _getDonationPrintableHtml();
            if (!printableHtml) return;
            const temp = document.createElement('div');
            temp.style.position = 'fixed';
            temp.style.left = '-9999px';
            temp.innerHTML = printableHtml;
            document.body.appendChild(temp);

            const render = () => {
                if (window.html2pdf) {
                    html2pdf().from(temp).set({margin:10, filename: 'donation_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove());
                } else {
                    const s = document.createElement('script');
                    s.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js';
                    s.onload = () => { html2pdf().from(temp).set({margin:10, filename: 'donation_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove()); };
                    document.head.appendChild(s);
                }
            };

            setTimeout(render, 200);
        }
    </script>

