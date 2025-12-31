@section('title', 'Mosque Settings')

<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Mosque Settings</h2>
            <p class="text-white/80 dark:text-white-400 mt-1 text-sm sm:text-base">Configure mosque-specific settings</p>
        </div>

        <!-- Settings Card -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mosque Settings</h3>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="saveSetting" class="space-y-6">
                    <!-- Santha Settings Section -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Santha Collection Settings</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Santha Amount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Monthly Santha Amount <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 font-medium">LKR</span>
                                    <input wire:model="santha_amount" type="number" step="0.01" min="0" required
                                        class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                </div>
                                @error('santha_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Set the default monthly santha payment amount for families
                                </p>
                            </div>

                            <!-- Collection Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Last Collection Date of Month <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="santha_collection_date" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                    @for ($day = 1; $day <= 31; $day++)
                                        <option value="{{ $day }}">{{ $day }}{{ $this->getSuffix($day) }} of Month</option>
                                    @endfor
                                </select>
                                @error('santha_collection_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Deadline for collecting santha payments each month
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Ramadan Porridge Settings Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Ramadan Porridge Settings</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Porridge Amount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Amount per Porridge <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 font-medium">LKR</span>
                                    <input wire:model="porridge_amount" type="number" step="0.01" min="0" required
                                        class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                </div>
                                @error('porridge_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Set the default amount charged per porridge serving during Ramadan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Additional Notes
                        </label>
                        <textarea wire:model="notes" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"></textarea>
                        @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Info Boxes -->
                    <div class="space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-blue-900 dark:text-blue-200">Flexible Payments</h4>
                                    <p class="text-sm text-blue-800 dark:text-blue-300 mt-1">
                                        Families can pay multiple months at once, overpay, or underpay. The system will track the actual amount paid and remaining balance.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-amber-900 dark:text-amber-200">Ramadan Porridge</h4>
                                    <p class="text-sm text-amber-800 dark:text-amber-300 mt-1">
                                        Sponsors can pay custom amounts per porridge (up to the setting amount). Existing sponsors will keep their original amounts.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex pt-4">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold transition shadow-lg">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
