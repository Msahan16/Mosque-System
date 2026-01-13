<div class="min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="content-overlay rounded-2xl shadow-2xl p-6 sm:p-8 mb-6 border border-blue-100 dark:border-blue-900 print:hidden">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Baithulmal Management
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Mosque Treasury & Financial Management</p>
                </div>
                <div class="flex gap-3">
                    <button wire:click="openModal('income')" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center gap-2 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Income
                    </button>
                    <button wire:click="openModal('expense')" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center gap-2 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                        Add Expense
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($activeTab !== 'reports')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 print:hidden">
            <!-- Total Income Card -->
            <div class="content-overlay rounded-2xl shadow-xl p-6 border-l-4 border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Income</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                            LKR {{ number_format($totalIncome, 2) }}
                        </p>
                    </div>
                    <div class="p-4 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Expense Card -->
            <div class="content-overlay rounded-2xl shadow-xl p-6 border-l-4 border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Expense</p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                            LKR {{ number_format($totalExpense, 2) }}
                        </p>
                    </div>
                    <div class="p-4 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Balance Card -->
            <div class="content-overlay rounded-2xl shadow-xl p-6 border-l-4 {{ $balance >= 0 ? 'border-blue-500' : 'border-orange-500' }} hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Balance</p>
                        <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }} mt-2">
                            LKR {{ number_format($balance, 2) }}
                        </p>
                    </div>
                    <div class="p-4 {{ $balance >= 0 ? 'bg-blue-100 dark:bg-blue-900' : 'bg-orange-100 dark:bg-orange-900' }} rounded-full">
                        <svg class="w-8 h-8 {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabs -->
        <div class="mb-8 overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide print:hidden">
            <div class="flex p-1.5 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/10 w-fit min-w-max">
                <button wire:click="setActiveTab('overview')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'overview' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Overview
                </button>
                <button wire:click="setActiveTab('transactions')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'transactions' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Transactions
                </button>
                <button wire:click="setActiveTab('reports')"
                    class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'reports' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Reports
                </button>
            </div>
        </div>

        <div class="content-overlay rounded-2xl shadow-xl mb-6 border border-blue-100 dark:border-blue-900 overflow-hidden">

            <!-- Tab Content -->
            <div class="p-6">
                @if($activeTab === 'overview')
                    <!-- Recent Transactions -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recent Transactions</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($recentTransactions as $transaction)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                                {{ $transaction->transaction_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                                {{ str_replace('_', ' ', ucwords($transaction->category, '_')) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ $transaction->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} LKR {{ number_format($transaction->amount, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <p class="mt-4 text-lg font-medium">No transactions found</p>
                                                <p class="mt-2">Start by adding your first income or expense transaction.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($activeTab === 'transactions')
                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                            <input type="text" wire:model.live="search" placeholder="Search transactions..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                            <select wire:model.live="filterType" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
                                <option value="all">All Types</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select wire:model.live="filterCategory" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
                                <option value="">All Categories</option>
                                <optgroup label="Income">
                                    @foreach($incomeCategories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Expense">
                                    @foreach($expenseCategories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                            <input type="date" wire:model.live="dateFrom" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                            <input type="date" wire:model.live="dateTo" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Method</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($transactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $transaction->transaction_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ str_replace('_', ' ', ucwords($transaction->category, '_')) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                            <div>{{ $transaction->description }}</div>
                                            @if($transaction->reference_number)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ref: {{ $transaction->reference_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} LKR {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button wire:click="viewTransaction({{ $transaction->id }})" title="View" class="px-2 py-1.5 bg-gray-600 text-white text-xs rounded hover:bg-gray-700 transition font-medium flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    <span class="hidden sm:inline">View</span>
                                                </button>
                                                <button wire:click="editTransaction({{ $transaction->id }})" title="Edit" class="px-2 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </button>
                                                <button onclick="confirmDelete('deleteTransaction', {{ $transaction->id }}, 'Delete Transaction?', 'This action cannot be undone.')" title="Delete" class="px-2 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="mt-4 text-lg font-medium">No transactions found</p>
                                            <p class="mt-2">Try adjusting your filters or add a new transaction.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>
                @elseif($activeTab === 'reports')
                    <!-- Reports Section with Print Functionality -->
                    <div>
                        <!-- Reports Controls -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 print:hidden">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                                    <input type="date" wire:model.live="dateFrom" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                                    <input type="date" wire:model.live="dateTo" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Report Type</label>
                                    <select wire:model.live="reportType" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                        <option value="1">Baithulmal Overview Report</option>
                                        <option value="2">Expense Report</option>
                                        <option value="3">Income Report</option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button onclick="window.print()" class="w-full px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                        Print Report
                                    </button>
                                </div>
                            </div>

                            @if($dateFrom || $dateTo)
                                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <p class="text-sm text-blue-800 dark:text-blue-300">
                                        <strong>Showing data for:</strong> 
                                        {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : 'Beginning' }} 
                                        to 
                                        {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d M Y') : 'Today' }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Print Header (Hidden on Screen) -->
                        <div class="hidden print:block mb-8">
                            <div class="text-center mb-6 border-b-2 border-gray-800 pb-4">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ auth()->user()->mosque->name ?? 'Mosque Management System' }}</h1>
                                <p class="text-sm text-gray-600">{{ auth()->user()->mosque->address ?? '' }}</p>
                                <h2 class="text-xl font-bold text-gray-800 mt-4">
                                    @if($reportType === '1')
                                        Baithulmal Overview Report
                                    @elseif($reportType === '2')
                                        Expense Report
                                    @elseif($reportType === '3')
                                        Income Report
                                    @endif
                                </h2>
                                <p class="text-sm text-gray-600 mt-2">
                                    <strong>Period:</strong> 
                                    {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : 'Beginning' }} 
                                    to 
                                    {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d M Y') : 'Today' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Generated on: {{ now()->format('d M Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        <!-- Main Report Section - Professional Table Format -->
                        @if($reportType === '1')
                            {{-- Overview Report --}}
                            <div class="space-y-6">
                                {{-- Summary Statistics Table --}}
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600 print:shadow-none print:border-2 print:border-gray-800">
                                    {{-- Table Header --}}
                                    <div class="bg-gradient-to-r from-indigo-700 to-indigo-800 px-6 py-4 border-b-2 border-indigo-900 print:bg-gray-100 print:border-gray-800">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h2 class="text-2xl font-bold text-white print:text-gray-900 print:hidden\">Baithulmal Overview Report</h2>
                                                <p class="text-indigo-100 text-sm mt-1 print:hidden">Comprehensive income and expense summary</p>
                                            </div>
                                            <div class="text-right print:hidden">
                                                <p class="text-indigo-100 text-xs uppercase tracking-wide">Report Period</p>
                                                <p class="text-lg font-bold text-white">{{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : 'All Time' }} - {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d M Y') : 'Today' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Table Content --}}
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse">
                                            <thead>
                                                <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500 print:bg-gray-200">
                                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900">Category</th>
                                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900">Description</th>
                                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider print:text-gray-900">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-slate-800 print:bg-white">
                                                {{-- Income Summary --}}
                                                <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-green-50 transition-colors print:border-gray-300">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700 dark:text-green-400 border-r border-slate-200 dark:border-slate-700 print:text-green-700 print:border-gray-300">
                                                        <span class="flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                            </svg>
                                                            Income
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700 print:text-gray-700 print:border-gray-300">Total Income (This Period)</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700 dark:text-green-400 text-right print:text-green-700">LKR {{ number_format($totalIncome, 2) }}</td>
                                                </tr>

                                                {{-- Expense Summary --}}
                                                <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 transition-colors print:border-gray-300">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 border-r border-slate-200 dark:border-slate-700 print:text-red-700 print:border-gray-300">
                                                        <span class="flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                                            </svg>
                                                            Expense
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700 print:text-gray-700 print:border-gray-300">Total Expense (This Period)</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-700 dark:text-red-400 text-right print:text-red-700">LKR {{ number_format($totalExpense, 2) }}</td>
                                                </tr>

                                                {{-- Net Balance --}}
                                                <tr class="border-b-2 border-slate-400 dark:border-slate-500 hover:bg-blue-50 transition-colors bg-slate-50 dark:bg-slate-700/30 print:bg-gray-100 print:border-gray-800">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700 dark:text-blue-400 border-r border-slate-200 dark:border-slate-700 print:text-blue-700 print:border-gray-300">
                                                        <span class="flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Net Balance
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm font-semibold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700 print:text-gray-700 print:border-gray-300">Income - Expense ({{ $balance >= 0 ? 'Surplus' : 'Deficit' }})</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base font-bold {{ $balance >= 0 ? 'text-blue-700 dark:text-blue-400' : 'text-orange-700 dark:text-orange-400' }} text-right print:{{ $balance >= 0 ? 'text-blue-700' : 'text-orange-700' }}">LKR {{ number_format($balance, 2) }}</td>
                                                </tr>

                                                {{-- Income by Category Section --}}
                                                @if($incomeByCategory->count() > 0)
                                                    <tr class="bg-green-50 dark:bg-green-900/10 border-b border-slate-200 dark:border-slate-700 print:bg-green-100 print:border-gray-300">
                                                        <td colspan="3" class="px-6 py-3 text-sm font-bold text-green-800 dark:text-green-300 uppercase tracking-wide print:text-green-800">
                                                            Income Breakdown by Category
                                                        </td>
                                                    </tr>
                                                    @foreach($incomeByCategory as $category => $amount)
                                                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-green-50 transition-colors print:border-gray-300">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400 border-r border-slate-200 dark:border-slate-700 print:text-green-600 print:border-gray-300"></td>
                                                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700 print:text-gray-700 print:border-gray-300">
                                                                {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400 text-right print:text-green-600">LKR {{ number_format($amount, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                {{-- Expense by Category Section --}}
                                                @if($expenseByCategory->count() > 0)
                                                    <tr class="bg-red-50 dark:bg-red-900/10 border-b border-slate-200 dark:border-slate-700 print:bg-red-100 print:border-gray-300">
                                                        <td colspan="3" class="px-6 py-3 text-sm font-bold text-red-800 dark:text-red-300 uppercase tracking-wide print:text-red-800">
                                                            Expense Breakdown by Category
                                                        </td>
                                                    </tr>
                                                    @foreach($expenseByCategory as $category => $amount)
                                                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 transition-colors print:border-gray-300">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 border-r border-slate-200 dark:border-slate-700 print:text-red-600 print:border-gray-300"></td>
                                                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 border-r border-slate-200 dark:border-slate-700 print:text-gray-700 print:border-gray-300">
                                                                {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 text-right print:text-red-600">LKR {{ number_format($amount, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        {{-- Expense Report --}}
                        @elseif($reportType === '2')
                            <div class="space-y-6">
                                {{-- Expense Summary Table --}}
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600 print:shadow-none print:border-2 print:border-gray-800">
                                    {{-- Table Header --}}
                                    <div class="bg-gradient-to-r from-red-700 to-red-800 px-6 py-4 border-b-2 border-red-900 print:bg-red-100 print:border-gray-800">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h2 class="text-2xl font-bold text-white print:text-gray-900 print:hidden">Expense Report</h2>
                                                <p class="text-red-100 text-sm mt-1 print:hidden">Detailed expense breakdown and analysis</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-red-100 text-xs uppercase tracking-wide print:text-gray-700">Total Expense</p>
                                                <p class="text-3xl font-bold text-white print:text-red-700">LKR {{ number_format($totalExpense, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Table Content --}}
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse">
                                            <thead>
                                                <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500 print:bg-gray-200">
                                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900 print:border-gray-300">Category</th>
                                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900 print:border-gray-300">Amount</th>
                                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider print:text-gray-900">Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-slate-800 print:bg-white">
                                                @forelse($expenseByCategory as $category => $amount)
                                                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-red-50 transition-colors print:border-gray-300">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700 print:text-gray-900 print:border-gray-300">
                                                            {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400 text-right border-r border-slate-200 dark:border-slate-700 print:text-red-600 print:border-gray-300">
                                                            LKR {{ number_format($amount, 2) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700 dark:text-slate-300 text-right print:text-gray-700">
                                                            @if($totalExpense > 0)
                                                                {{ number_format(($amount / $totalExpense) * 100, 1) }}%
                                                            @else
                                                                0%
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="py-8 text-center text-slate-500 dark:text-slate-400 print:text-gray-500">No expense data available</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            @if($expenseByCategory->count() > 0)
                                                <tfoot class="bg-red-50 dark:bg-red-900/10 border-t-2 border-slate-300 dark:border-slate-600 print:bg-red-100 print:border-gray-800">
                                                    <tr>
                                                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700 print:text-gray-900 print:border-gray-300">TOTAL EXPENSE</td>
                                                        <td class="px-6 py-4 text-right text-sm font-bold text-red-700 dark:text-red-300 border-r border-slate-200 dark:border-slate-700 print:text-red-700 print:border-gray-300">LKR {{ number_format($totalExpense, 2) }}</td>
                                                        <td class="px-6 py-4 text-right text-sm font-bold text-red-700 dark:text-red-300 print:text-red-700">100%</td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                        {{-- Income Report --}}
                        @elseif($reportType === '3')
                            <div class="space-y-6">
                                {{-- Income Summary Table --}}
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden border border-slate-300 dark:border-slate-600 print:shadow-none print:border-2 print:border-gray-800">
                                    {{-- Table Header --}}
                                    <div class="bg-gradient-to-r from-green-700 to-green-800 px-6 py-4 border-b-2 border-green-900 print:bg-green-100 print:border-gray-800">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h2 class="text-2xl font-bold text-white print:text-gray-900 print:hidden">Income Report</h2>
                                                <p class="text-green-100 text-sm mt-1 print:hidden">Detailed income breakdown and analysis</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-green-100 text-xs uppercase tracking-wide print:text-gray-700">Total Income</p>
                                                <p class="text-3xl font-bold text-white print:text-green-700">LKR {{ number_format($totalIncome, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Table Content --}}
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse">
                                            <thead>
                                                <tr class="bg-slate-200 dark:bg-slate-700 border-b-2 border-slate-400 dark:border-slate-500 print:bg-gray-200">
                                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900 print:border-gray-300">Category</th>
                                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider border-r border-slate-300 dark:border-slate-600 print:text-gray-900 print:border-gray-300">Amount</th>
                                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider print:text-gray-900">Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-slate-800 print:bg-white">
                                                @forelse($incomeByCategory as $category => $amount)
                                                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-green-50 transition-colors print:border-gray-300">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700 print:text-gray-900 print:border-gray-300">
                                                            {{ str_replace('_', ' ', ucwords($category, '_')) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400 text-right border-r border-slate-200 dark:border-slate-700 print:text-green-600 print:border-gray-300">
                                                            LKR {{ number_format($amount, 2) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700 dark:text-slate-300 text-right print:text-gray-700">
                                                            @if($totalIncome > 0)
                                                                {{ number_format(($amount / $totalIncome) * 100, 1) }}%
                                                            @else
                                                                0%
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="py-8 text-center text-slate-500 dark:text-slate-400 print:text-gray-500">No income data available</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            @if($incomeByCategory->count() > 0)
                                                <tfoot class="bg-green-50 dark:bg-green-900/10 border-t-2 border-slate-300 dark:border-slate-600 print:bg-green-100 print:border-gray-800">
                                                    <tr>
                                                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-white border-r border-slate-200 dark:border-slate-700 print:text-gray-900 print:border-gray-300">TOTAL INCOME</td>
                                                        <td class="px-6 py-4 text-right text-sm font-bold text-green-700 dark:text-green-300 border-r border-slate-200 dark:border-slate-700 print:text-green-700 print:border-gray-300">LKR {{ number_format($totalIncome, 2) }}</td>
                                                        <td class="px-6 py-4 text-right text-sm font-bold text-green-700 dark:text-green-300 print:text-green-700">100%</td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Print Footer (Hidden on Screen) -->
                        <div class="hidden print:block mt-16 pt-8 border-t-2 border-gray-800">
                            <div class="grid grid-cols-3 gap-8 text-center">
                                <div>
                                    <div class="border-t-2 border-gray-800 pt-2 mt-16">
                                        <p class="text-sm font-semibold">Prepared By</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="border-t-2 border-gray-800 pt-2 mt-16">
                                        <p class="text-sm font-semibold">Verified By</p>
                                        <p class="text-xs text-gray-600 mt-1">Treasury Officer</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="border-t-2 border-gray-800 pt-2 mt-16">
                                        <p class="text-sm font-semibold">Approved By</p>
                                        <p class="text-xs text-gray-600 mt-1">Mosque Administrator</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-8 text-xs text-gray-500">
                                <p>This is a computer-generated report from the Mosque Management System</p>
                                <p class="mt-1">Printed on: {{ now()->format('l, d F Y \\a\\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Transaction Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">
                            @if($viewMode)
                                Transaction Details
                            @else
                                {{ $editMode ? 'Edit Transaction' : 'Add New Transaction' }}
                            @endif
                        </h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                @if($viewMode)
                    <div class="p-6 space-y-6">
                        <!-- Transaction Type Badge -->
                        <div class="flex justify-center">
                            <span class="px-4 py-2 rounded-full text-lg font-bold {{ $type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                {{ ucfirst($type) }} Transaction
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Details -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $type === 'income' ? $incomeCategories[$category] ?? $category : $expenseCategories[$category] ?? $category }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($transaction_date)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</label>
                                    <p class="text-xl font-bold {{ $type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        LKR {{ number_format($amount, 2) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $payment_method)) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reference Number</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $reference_number ?: '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $type === 'income' ? 'Received From' : 'Paid To' }}
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $is_anonymous ? 'Anonymous' : ($type === 'income' ? $received_from : $paid_to) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Description & Notes -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                                <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                    {{ $description ?: 'No description provided' }}
                                </p>
                            </div>
                            @if($notes)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                                    <p class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                        {{ $notes }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Attachments -->
                        @if(!empty($existingAttachments))
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 block">Attachments</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($existingAttachments as $path)
                                        <a href="{{ Storage::url($path) }}" target="_blank" class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors border border-blue-100 dark:border-blue-800">
                                            <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-blue-900 dark:text-blue-100 truncate">
                                                    {{ basename($path) }}
                                                </p>
                                                <span class="text-xs text-blue-600 dark:text-blue-400">Click to view</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 flex justify-end">
                            <button type="button" wire:click="closeModal" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-all duration-200">
                                Close
                            </button>
                        </div>
                    </div>
                @else
                    <form wire:submit.prevent="saveTransaction" class="p-6 space-y-4">
                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction Type *</label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" wire:click="$set('type', 'income')" class="px-4 py-3 rounded-lg border-2 {{ $type === 'income' ? 'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300' }} font-semibold transition-all">
                                    Income
                                </button>
                                <button type="button" wire:click="$set('type', 'expense')" class="px-4 py-3 rounded-lg border-2 {{ $type === 'expense' ? 'border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300' }} font-semibold transition-all">
                                    Expense
                                </button>
                            </div>
                            @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                            <select wire:model="category" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Category</option>
                                @if($type === 'income')
                                    @foreach($incomeCategories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                @else
                                    @foreach($expenseCategories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <input type="text" wire:model="description" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Enter description">
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Amount and Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount (LKR) *</label>
                                <input type="number" step="0.01" wire:model="amount" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="0.00">
                                @error('amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction Date *</label>
                                <input type="date" wire:model="transaction_date" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('transaction_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Payment Method and Reference Number -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                                <select wire:model="payment_method" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('payment_method') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number</label>
                                <input type="text" wire:model="reference_number" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Receipt/Bill number">
                                @error('reference_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Anonymous Checkbox -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="is_anonymous" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                <div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Mark as Anonymous</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        Check this if you don't want to specify {{ $type === 'income' ? 'who gave' : 'who received' }} the payment
                                    </p>
                                </div>
                            </label>
                        </div>

                        <!-- Paid To / Received From -->
                        @if($type === 'expense')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Paid To {{ !$is_anonymous ? '*' : '' }}
                                </label>
                                <input type="text" wire:model="paid_to" {{ $is_anonymous ? 'disabled' : '' }} class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white {{ $is_anonymous ? 'opacity-50 cursor-not-allowed' : '' }}" placeholder="{{ $is_anonymous ? 'Anonymous' : 'Vendor/Person name' }}">
                                @error('paid_to') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Received From {{ !$is_anonymous ? '*' : '' }}
                                </label>
                                <input type="text" wire:model="received_from" {{ $is_anonymous ? 'disabled' : '' }} class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white {{ $is_anonymous ? 'opacity-50 cursor-not-allowed' : '' }}" placeholder="{{ $is_anonymous ? 'Anonymous' : 'Donor/Person name' }}">
                                @error('received_from') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <textarea wire:model="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Additional notes..."></textarea>
                            @error('notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Attachments -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Attachments (Bills/Receipts)</label>
                        
                        <!-- File Input -->
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload files</span>
                                        <input id="file-upload" wire:model="newAttachments" type="file" class="sr-only" multiple accept="image/*,application/pdf">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, PDF up to 2MB each
                                </p>
                            </div>
                        </div>

                        <!-- Existing Attachments List -->
                        @if(!empty($existingAttachments))
                            <div class="mt-4 space-y-2">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Existing Files:</p>
                                @foreach($existingAttachments as $index => $path)
                                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center gap-2 truncate">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700 dark:text-gray-200 truncate">{{ basename($path) }}</span>
                                        </div>
                                        <button type="button" wire:click="removeAttachment({{ $index }})" class="text-red-500 hover:text-red-700 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- New Attachments Preview -->
                        @if($newAttachments)
                            <div class="mt-4 space-y-2">
                                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">New Files to Upload:</p>
                                @foreach($newAttachments as $file)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        {{ $file->getClientOriginalName() }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @error('newAttachments.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                                {{ $editMode ? 'Update Transaction' : 'Add Transaction' }}
                            </button>
                            <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-white rounded-lg font-semibold transition-all duration-200">
                                Cancel
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
