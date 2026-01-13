@section('title', 'Santha Collection')

<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Santha Collection</h2>
                <p class="text-white/80 mt-1 text-sm">Monthly membership payments - {{ $currentMonthName }}</p>
            </div>
            <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-800 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-emerald-900 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Record Payment
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-blue-100 text-xs font-medium">This Month</p>
                <p class="text-2xl font-bold mt-1">LKR {{ number_format($totalCollectedThisMonth, 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-emerald-100 text-xs font-medium">Paid</p>
                <p class="text-2xl font-bold mt-1">{{ $paidThisMonth }} / {{ $totalFamilies }}</p>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-red-100 text-xs font-medium">Pending</p>
                <p class="text-2xl font-bold mt-1">{{ $pendingThisMonth }}</p>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl p-4 shadow-lg">
                <p class="text-blue-100 text-xs font-medium">Rate</p>
                <p class="text-2xl font-bold mt-1">{{ $collectionRate }}%</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <select wire:model.live="filterMonth" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                    <option value="">All Months</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <select wire:model.live="filterYear" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <input wire:model.live="search" type="text" placeholder="Search family or receipt..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
            </div>
        </div>

        <!-- Payments Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Receipt</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Family</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Period/Months</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Date</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($santhas as $santha)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <span class="text-xs font-mono text-blue-600 dark:text-blue-400">{{ $santha->receipt_number }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $santha->family->family_head_name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($santha->months_covered > 1)
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">
                                            {{ $santha->months_covered }} Month{{ $santha->months_covered > 1 ? 's' : '' }}
                                            @if($santha->status === 'partial')
                                                <span class="text-xs text-blue-600">({{ floor($santha->amount / 500) }} full, 1 partial)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $santha->getMonthsCoveredDisplay() }}</div>
                                    @else
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $santha->month }} {{ $santha->year }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-semibold text-green-600 dark:text-green-400">LKR {{ number_format($santha->amount, 0) }}</div>
                                    @if($santha->status === 'partial' && $santha->balance_due > 0)
                                        <div class="text-xs text-orange-600 dark:text-orange-400">Balance: {{ number_format($santha->balance_due, 0) }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($santha->status === 'partial')
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                            Partial
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            {{ ucfirst($santha->status ?? 'paid') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $santha->payment_date->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                        <button wire:click="viewReceipt({{ $santha->id }})" title="View Receipt" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            <span class="hidden sm:inline">View</span>
                                        </button>
                                        @if($santha->status === 'partial' && $santha->balance_due > 0)
                                            <button wire:click="payBalance({{ $santha->id }})" title="Pay Balance" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="hidden sm:inline">Pay</span>
                                            </button>
                                        @endif
                                        <button wire:click="editSantha({{ $santha->id }})" title="Edit Payment" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button onclick="confirmDelete('confirmDeleteSantha', {{ $santha->id }}, 'Delete Payment?', 'This action cannot be undone.')" title="Delete Payment" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">No payments found</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Click "Record Payment" to add one</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($santhas->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $santhas->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-4 py-2 rounded-t-lg sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold">{{ $editMode ? 'Edit Payment' : 'Record Payment' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveSantha" class="space-y-3">
                        <!-- Family Selection with Search -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Family * 
                                <span class="text-xs text-gray-500">(Search by name, ID or phone)</span>
                            </label>
                            <div class="relative">
                                <div class="relative">
                                    <input 
                                        wire:model.live.debounce.300ms="familySearch" 
                                        wire:focus="$set('showFamilyDropdown', true)"
                                        type="text" 
                                        placeholder="Type to search families..."
                                        autocomplete="off"
                                        class="w-full px-3 py-1.5 pr-10 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    
                                    <!-- Search Icon / Clear Button -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        @if($family_id)
                                            <button type="button" wire:click="clearFamily" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Dropdown Results -->
                                @if($showFamilyDropdown && !empty($familySearch))
                                    <div class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-xl max-h-48 overflow-auto">
                                        @forelse($this->filteredFamilies as $family)
                                            <button 
                                                type="button"
                                                wire:click="selectFamily({{ $family->id }}, '{{ $family->family_head_name }}')"
                                                class="w-full px-3 py-2 text-left hover:bg-blue-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="font-medium text-sm text-gray-900 dark:text-white">{{ $family->family_head_name }}</div>
                                                        <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                            @if($family->family_id)
                                                                <span class="flex items-center gap-0.5">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                    </svg>
                                                                    ID: {{ $family->family_id }}
                                                                </span>
                                                            @endif
                                                            @if($family->phone)
                                                                <span class="flex items-center gap-0.5">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                    </svg>
                                                                    {{ $family->phone }}
                                                                </span>
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
                                                <svg class="w-8 h-8 mx-auto mb-1 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <!-- Partial Payment Alert -->
                        @if(!empty($familyPartialPayments))
                            <div class="p-2.5 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-red-800 dark:text-red-300">Outstanding Balance Found!</p>
                                        <p class="text-xs text-red-700 dark:text-red-400 mt-0.5">This family has unpaid balances:</p>
                                        @foreach($familyPartialPayments as $partial)
                                            <div class="mt-1.5 p-1.5 bg-white dark:bg-gray-900 rounded border border-red-200 dark:border-red-800">
                                                <div class="flex justify-between items-center text-xs">
                                                    <span class="text-gray-700 dark:text-gray-300">{{ $partial['months'] }}</span>
                                                    <span class="font-bold text-red-600">LKR {{ number_format($partial['balance'], 0) }} due</span>
                                                </div>
                                                <button type="button" wire:click="payBalance({{ $partial['id'] }})" class="mt-1 w-full px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                                    Pay This Balance
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Family Credit Display -->
                        @if($family_id && $familyCredit > 0)
                            <div class="p-2.5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-green-800 dark:text-green-300">Credit Available: LKR {{ number_format($familyCredit, 2) }}</p>
                                        <p class="text-xs text-green-700 dark:text-green-400 mt-0.5">From previous overpayment</p>
                                        @if($amountNeeded > 0)
                                            <p class="text-xs text-green-600 dark:text-green-500 mt-1 font-medium">
                                                Pay only LKR {{ number_format($amountNeeded, 0) }} more
                                            </p>
                                        @else
                                            <p class="text-xs text-green-600 dark:text-green-500 mt-1 font-medium">
                                                Already covered by credit!
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Amount -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Amount (LKR) * <span class="text-xs text-gray-500">(Monthly: {{ number_format($monthlyAmount, 0) }})</span>
                            </label>
                            <input wire:model.live="amount" type="number" step="0.01" required class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                            @error('amount') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            
                            @if($amount && $monthlyAmount > 0)
                                <div class="mt-1 p-1.5 bg-blue-50 dark:bg-blue-900/20 rounded text-xs text-blue-700 dark:text-blue-300">
                                    @if($familyCredit > 0)
                                        <div class="font-medium">Credit: {{ number_format($familyCredit, 0) }} + Payment: {{ number_format($amount, 0) }} = {{ number_format($amount + $familyCredit, 0) }}</div>
                                    @endif
                                    <div class="{{ $familyCredit > 0 ? 'mt-0.5' : '' }}">Covers <strong>{{ $monthsToPay }} month(s)</strong>
                                    @if($overpaymentMode === 'credit' && $newCredit > 0)
                                        + {{ number_format($newCredit, 0) }} credit
                                    @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Overpayment Handling Option -->
                        @if($amount > $monthlyAmount)
                            <div class="border border-blue-200 dark:border-blue-800 rounded p-2.5 bg-blue-50 dark:bg-blue-900/20">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Overpayment Mode</label>
                                <div class="space-y-1.5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" wire:model.live="overpaymentMode" value="credit" class="text-blue-600 focus:ring-blue-500">
                                        <span class="text-xs text-gray-900 dark:text-white">Credit for Future Months</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" wire:model.live="overpaymentMode" value="single_month" class="text-blue-600 focus:ring-blue-500">
                                        <span class="text-xs text-gray-900 dark:text-white">Single Month (Extra as donation)</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        <!-- Months Covered -->
                        @if(!empty($selectedMonths))
                            <div class="bg-green-50 dark:bg-green-900/20 rounded p-2.5">
                                <div class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Covers: {{ $monthsToPay }} month(s)</div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($selectedMonths as $sm)
                                        <span class="px-2 py-0.5 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 rounded text-xs">
                                            {{ $sm['monthName'] }} {{ $sm['year'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Payment Date & Method -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Date *</label>
                                <input wire:model="payment_date" type="date" required class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                @error('payment_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Method *</label>
                                <select wire:model="payment_method" required class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="check">Check</option>
                                </select>
                                @error('payment_method') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="2" placeholder="Optional notes..." class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white resize-none"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2 pt-1.5">
                            <button type="button" wire:click="closeModal" class="flex-1 px-3 py-1.5 text-sm bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 font-medium">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-3 py-1.5 text-sm bg-gradient-to-r from-emerald-600 to-emerald-800 text-white rounded hover:from-emerald-700 hover:to-emerald-900 font-medium shadow-lg">
                                {{ $editMode ? 'Update' : 'Save Payment' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Receipt Modal -->
    @if($showReceiptModal && $viewingSantha)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Receipt</h3>
                    <div class="space-x-2">
                        <button onclick="printSanthaReceipt()" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Print</button>
                        <button onclick="downloadSanthaReceipt()" class="px-3 py-1 bg-green-600 text-white rounded text-xs">Download</button>
                        <button wire:click="closeReceiptModal" class="px-3 py-1 bg-gray-300 text-gray-800 rounded text-xs">Close</button>
                    </div>
                </div>

                <div id="santha-receipt-content" style="background:#ffffff;padding:22px;color:#111827;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;max-width:640px;margin:0 auto;">
                    <div style="text-align:center;margin-bottom:8px;">
                        <h2 style="font-size:20px;margin:0 0 4px 0;font-weight:700;color:#0f172a;">{{ $viewingSantha['mosque_name'] }}</h2>
                        <p style="margin:0;color:#6b7280;font-size:13px;">Santha Receipt</p>
                    </div>

                    <table style="width:100%;border-collapse:collapse;margin-top:12px;">
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Receipt #</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSantha['receipt_number'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Date</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSantha['payment_date'] }}</td>
                        </tr>
                    </table>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    <div style="color:#374151;font-size:14px;line-height:1.5;margin-bottom:10px;">
                        <div><strong>Family:</strong> {{ $viewingSantha['family_name'] }}</div>
                        <div><strong>Phone:</strong> {{ $viewingSantha['family_phone'] }}</div>
                        @if($viewingSantha['months_covered'] > 1)
                            <div><strong>Months Covered:</strong> {{ $viewingSantha['months_covered'] }} months</div>
                            <div style="font-size:13px;color:#6b7280;">{{ $viewingSantha['months_display'] }}</div>
                        @else
                            <div><strong>Period:</strong> {{ $viewingSantha['month'] }} {{ $viewingSantha['year'] }}</div>
                        @endif
                    </div>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    @if($viewingSantha['previous_credit_used'] > 0)
                        <div style="background:#f0fdf4;padding:10px;border-radius:4px;margin-bottom:10px;font-size:13px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span>Previous Credit Used</span>
                                <span style="font-weight:600;color:#059669;">LKR{{ number_format($viewingSantha['previous_credit_used'], 0) }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span>New Payment</span>
                                <span style="font-weight:600;color:#2563eb;">LKR{{ number_format($viewingSantha['amount'], 0) }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;padding-top:4px;border-top:1px solid #dcfce7;margin-top:4px;">
                                <span style="font-weight:600;">Total Applied</span>
                                <span style="font-weight:700;color:#047857;">LKR{{ number_format($viewingSantha['total_applied'], 0) }}</span>
                            </div>
                        </div>
                    @endif

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                        <div style="font-weight:600;color:#111827;">Amount Paid</div>
                        <div style="font-size:18px;font-weight:700;color:#0f172a;">LKR{{ number_format($viewingSantha['amount'], 0) }}</div>
                    </div>

                    @if($viewingSantha['new_credit'] > 0)
                        <div style="background:#eff6ff;padding:10px;border-radius:4px;margin-top:10px;font-size:13px;">
                            <div style="color:#1e40af;">ℹ️ Balance Remaining ({{ $viewingSantha['balance_month'] }}): <strong>LKR{{ number_format($viewingSantha['new_credit'], 0) }}</strong></div>
                        </div>
                    @endif

                    <div style="color:#6b7280;margin-top:8px;font-size:13px;">Method: {{ ucfirst($viewingSantha['payment_method']) }}</div>
                    @if(!empty($viewingSantha['notes']))
                        <div style="margin-top:8px;font-size:13px;color:#374151;">Notes: {{ $viewingSantha['notes'] }}</div>
                    @endif

                    <div style="text-align:left;color:#9ca3af;margin-top:16px;font-size:12px;">This receipt is generated by {{ config('app.name') }}.</div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function _getSanthaPrintableHtml() {
            const content = document.getElementById('santha-receipt-content');
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

        function printSanthaReceipt() {
            const html = _getSanthaPrintableHtml();
            if (!html) return;

            const w = window.open('', '_blank');
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.focus();
            setTimeout(() => { w.print(); }, 600);
        }

        function downloadSanthaReceipt() {
            const printableHtml = _getSanthaPrintableHtml();
            if (!printableHtml) return;
            const temp = document.createElement('div');
            temp.style.position = 'fixed';
            temp.style.left = '-9999px';
            temp.innerHTML = printableHtml;
            document.body.appendChild(temp);

            const render = () => {
                if (window.html2pdf) {
                    html2pdf().from(temp).set({margin:10, filename: 'santha_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove());
                } else {
                    const s = document.createElement('script');
                    s.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js';
                    s.onload = () => { html2pdf().from(temp).set({margin:10, filename: 'santha_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove()); };
                    document.head.appendChild(s);
                }
            };

            setTimeout(render, 200);
        }
    </script>
</div>
