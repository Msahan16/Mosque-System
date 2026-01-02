@section('title', 'Santha Collection')

<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Santha Collection</h2>
                <p class="text-white/80 mt-1 text-sm">Monthly membership payments - {{ $currentMonthName }}</p>
            </div>
            <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-green-700 transition shadow-lg">
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
            <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-4 shadow-lg">
                <p class="text-green-100 text-xs font-medium">Paid</p>
                <p class="text-2xl font-bold mt-1">{{ $paidThisMonth }} / {{ $totalFamilies }}</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-orange-100 text-xs font-medium">Pending</p>
                <p class="text-2xl font-bold mt-1">{{ $pendingThisMonth }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-purple-100 text-xs font-medium">Rate</p>
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
                    <thead class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-blue-900/30 dark:to-green-900/30">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Receipt</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Family</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Period</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
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
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $santha->month }} {{ $santha->year }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">LKR {{ number_format($santha->amount, 0) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $santha->payment_date->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button wire:click="viewReceipt({{ $santha->id }})" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">View</button>
                                    <button wire:click="editSantha({{ $santha->id }})" class="px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">Edit</button>
                                    <button onclick="confirmDelete('confirmDeleteSantha', {{ $santha->id }}, 'Delete Payment?', 'This action cannot be undone.')" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-5 py-3 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editMode ? 'Edit Payment' : 'Record Payment' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-5">
                    <form wire:submit.prevent="saveSantha" class="space-y-4">
                        <!-- Family Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Family *</label>
                            <select wire:model.live="family_id" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                <option value="">Select Family</option>
                                @foreach($families as $family)
                                    <option value="{{ $family->id }}">{{ $family->family_head_name }}</option>
                                @endforeach
                            </select>
                            @error('family_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Month & Year -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Month *</label>
                                <select wire:model="month" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                                @error('month') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year *</label>
                                <select wire:model="year" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (LKR) *</label>
                            <input wire:model="amount" type="number" step="0.01" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                            @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Payment Date & Method -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Date *</label>
                                <input wire:model="payment_date" type="date" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                @error('payment_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Method *</label>
                                <select wire:model="payment_method" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="check">Check</option>
                                </select>
                                @error('payment_method') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="2" placeholder="Optional notes..." class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 font-medium">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg hover:from-blue-700 hover:to-green-700 font-medium shadow-lg">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Receipt</h3>
                    <div class="space-x-2">
                        <button onclick="printReceipt()" class="px-3 py-1.5 bg-blue-600 text-white rounded text-sm">Print</button>
                        <button wire:click="closeReceiptModal" class="px-3 py-1.5 bg-gray-300 text-gray-800 rounded text-sm">Close</button>
                    </div>
                </div>

                <div id="receipt-content" class="bg-white p-5 border rounded-lg">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">{{ $viewingSantha['mosque_name'] }}</h2>
                        <p class="text-gray-500 text-sm">Santha Receipt</p>
                    </div>

                    <div class="border-t border-b py-3 my-3 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Receipt #</span>
                            <span class="font-mono">{{ $viewingSantha['receipt_number'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span>{{ $viewingSantha['payment_date'] }}</span>
                        </div>
                    </div>

                    <div class="space-y-1 text-sm mb-4">
                        <p><span class="text-gray-600">Family:</span> {{ $viewingSantha['family_name'] }}</p>
                        <p><span class="text-gray-600">Phone:</span> {{ $viewingSantha['family_phone'] }}</p>
                        <p><span class="text-gray-600">Period:</span> {{ $viewingSantha['month'] }} {{ $viewingSantha['year'] }}</p>
                    </div>

                    <div class="border-t pt-3 flex justify-between items-center">
                        <span class="font-medium text-gray-700">Amount Paid</span>
                        <span class="text-xl font-bold text-green-600">LKR {{ number_format($viewingSantha['amount'], 2) }}</span>
                    </div>
                    <p class="text-gray-500 text-xs mt-2">Method: {{ ucfirst($viewingSantha['payment_method']) }}</p>
                    @if(!empty($viewingSantha['notes']))
                        <p class="text-gray-500 text-xs mt-1">Notes: {{ $viewingSantha['notes'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <script>
        function printReceipt() {
            const content = document.getElementById('receipt-content');
            if (!content) return;
            const w = window.open('', '_blank');
            w.document.write('<html><head><title>Receipt</title><style>body{font-family:sans-serif;padding:20px;}</style></head><body>');
            w.document.write(content.innerHTML);
            w.document.write('</body></html>');
            w.document.close();
            w.print();
        }
    </script>
</div>
