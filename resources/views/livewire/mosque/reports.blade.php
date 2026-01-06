<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-slate-900">
    {{-- Header Section --}}
    <div class="relative h-72 overflow-hidden" style="background-image: url('{{ asset('images/mosq1.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70 via-blue-800/80 to-blue-900/90"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white z-10 px-4">
                <div class="flex items-center justify-center gap-3 mb-3">
                    <svg class="w-14 h-14 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h1 class="text-5xl font-bold">Reports & Analytics</h1>
                </div>
                <p class="text-blue-100 text-lg">{{ $mosqueName }}</p>
                <p class="text-blue-200 text-sm mt-2">Comprehensive insights and data analysis</p>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-6 lg:px-8 py-8 -mt-16 relative z-10">
        {{-- Report Controls Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl p-6 mb-8 border border-slate-200 dark:border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Report Type Selection --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Report Type
                    </label>
                    <select wire:model.live="reportType" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="overview">📊 Overview Summary</option>
                        <option value="families">👨‍👩‍👧‍👦 Families Report</option>
                        <option value="donations-received">💰 Donations Received</option>
                        <option value="donations-given">🎁 Donations Given</option>
                        <option value="santhas">📅 Santha Payments</option>
                        <option value="madrasa">📚 Madrasa Report</option>
                        <option value="imam">🕌 Imam Management</option>
                        <option value="porridge">🍲 Ramadan Porridge</option>
                        <option value="financial">💵 Financial Summary</option>
                    </select>
                </div>

                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Start Date
                    </label>
                    <input type="date" wire:model.live="startDate" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        End Date
                    </label>
                    <input type="date" wire:model.live="endDate" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                <button wire:click="generateReport" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Report
                </button>
                <button onclick="window.print()" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Report
                </button>
            </div>
        </div>

        {{-- Report Content --}}
        @if($reportType === 'overview')
            @include('livewire.mosque.reports.overview')
        @elseif($reportType === 'families')
            @include('livewire.mosque.reports.families')
        @elseif($reportType === 'donations-received' || $reportType === 'donations-given')
            @include('livewire.mosque.reports.donations')
        @elseif($reportType === 'santhas')
            @include('livewire.mosque.reports.santhas')
        @elseif($reportType === 'madrasa')
            @include('livewire.mosque.reports.madrasa')
        @elseif($reportType === 'imam')
            @include('livewire.mosque.reports.imam')
        @elseif($reportType === 'porridge')
            @include('livewire.mosque.reports.porridge')
        @elseif($reportType === 'financial')
            @include('livewire.mosque.reports.financial')
        @endif
    </div>
</div>
