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
            </div>

            <!-- Tabs Navigation -->
            <div class="p-6 pb-0 overflow-x-auto scrollbar-hide">
                <div class="flex p-1.5 bg-gray-100/50 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-gray-200 dark:border-white/10 w-fit min-w-max mx-auto">
                    <button wire:click="setActiveTab('profile')"
                        class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'profile' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Mosque Profile
                    </button>
                    <button wire:click="setActiveTab('santha')"
                        class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'santha' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Santha Collection
                    </button>
                    <button wire:click="setActiveTab('porridge')"
                        class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'porridge' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Ramadan Porridge
                    </button>
                    <button wire:click="setActiveTab('iqamah')"
                        class="flex items-center gap-2.5 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $activeTab === 'iqamah' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/5' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Iqamah Times
                    </button>
                </div>
            </div>

            <div class="p-6">
                <!-- Mosque Profile Tab -->
                @if($activeTab === 'profile')
                    <form wire:submit.prevent="updateProfile" class="space-y-8">
                        <div>
                            <h4 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight mb-6">Mosque Branding & Identity</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                                <!-- Logo Upload -->
                                <div class="space-y-4">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Official Mosque Logo</label>
                                    <div class="relative group">
                                        <div class="w-full aspect-square rounded-[2rem] bg-slate-50 dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-500">
                                            @if($masjid_logo)
                                                <img src="{{ $masjid_logo->temporaryUrl() }}" class="w-full h-full object-contain p-4">
                                            @elseif($current_logo)
                                                <img src="{{ asset('storage/' . $current_logo) }}" class="w-full h-full object-contain p-4">
                                            @else
                                                <div class="text-center p-6">
                                                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <p class="text-xs font-bold text-slate-400">Upload PNG/JPG</p>
                                                </div>
                                            @endif
                                            
                                            <!-- Overlay -->
                                            <label class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                                <span class="text-white text-[10px] font-black uppercase tracking-widest bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl">Change Logo</span>
                                                <input type="file" wire:model="masjid_logo" class="hidden" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="masjid_logo" class="text-[10px] font-bold text-indigo-500 animate-pulse">Uploading logo...</div>
                                    @error('masjid_logo') <p class="mt-1 text-[10px] text-red-500 font-bold uppercase">{{ $message }}</p> @enderror
                                </div>

                                <!-- Mosque Details -->
                                <div class="md:col-span-2 space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Mosque Name (English) *</label>
                                            <input wire:model="masjid_name" type="text" required placeholder="e.g. Masjid Al-Noor"
                                                class="w-full px-5 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                                            @error('masjid_name') <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Arabic Name (Optional)</label>
                                            <input wire:model="masjid_arabic_name" type="text" dir="rtl" placeholder="مسجد النور"
                                                class="w-full px-5 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-right">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Official Address *</label>
                                            <textarea wire:model="masjid_address" required rows="2" placeholder="Full physical address for letterheads"
                                                class="w-full px-5 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all"></textarea>
                                            @error('masjid_address') <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                                            <input wire:model="masjid_phone" type="text" placeholder="+94 77 XXX XXXX"
                                                class="w-full px-5 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                                            <input wire:model="masjid_email" type="email" placeholder="mosque@example.com"
                                                class="w-full px-5 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex pt-4">
                            <button type="submit"
                                class="px-10 py-4 bg-indigo-600 text-white rounded-[1.5rem] hover:bg-indigo-700 font-extrabold text-xs uppercase tracking-widest transition shadow-xl shadow-indigo-500/20 active:scale-95">
                                Update Mosque Profile
                            </button>
                        </div>
                    </form>
                @endif

                <form wire:submit.prevent="saveSetting" class="space-y-6">
                    <!-- Santha Collection Tab -->
                    @if($activeTab === 'santha')
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

                            <!-- Info Box -->
                            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
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
                        </div>
                    @endif

                    <!-- Ramadan Porridge Tab -->
                    @if($activeTab === 'porridge')
                        <div>
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

                            <!-- Info Box -->
                            <div class="mt-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
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
                    @endif

                    <!-- Iqamah Times Tab -->
                    @if($activeTab === 'iqamah')
                        <div>
                            <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Iqamah Time Settings</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Configure the time delay (in minutes) between Azan and Iqamah for each prayer.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Fajr Offset -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fajr Iqamah Delay <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input wire:model="fajr_iqamah_offset" type="number" min="0" max="60" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                        <span class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 text-sm">minutes</span>
                                    </div>
                                    @error('fajr_iqamah_offset') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Dhuhr Offset -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Dhuhr Iqamah Delay <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input wire:model="dhuhr_iqamah_offset" type="number" min="0" max="60" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                        <span class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 text-sm">minutes</span>
                                    </div>
                                    @error('dhuhr_iqamah_offset') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Asr Offset -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Asr Iqamah Delay <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input wire:model="asr_iqamah_offset" type="number" min="0" max="60" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                        <span class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 text-sm">minutes</span>
                                    </div>
                                    @error('asr_iqamah_offset') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Maghrib Offset -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Maghrib Iqamah Delay <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input wire:model="maghrib_iqamah_offset" type="number" min="0" max="60" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                        <span class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 text-sm">minutes</span>
                                    </div>
                                    @error('maghrib_iqamah_offset') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Isha Offset -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Isha Iqamah Delay <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input wire:model="isha_iqamah_offset" type="number" min="0" max="60" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                        <span class="absolute right-4 top-3 text-gray-500 dark:text-gray-400 text-sm">minutes</span>
                                    </div>
                                    @error('isha_iqamah_offset') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="mt-6 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-medium text-indigo-900 dark:text-indigo-200">About Iqamah Times</h4>
                                        <p class="text-sm text-indigo-800 dark:text-indigo-300 mt-1">
                                            Iqamah is the second call to prayer, signaling the start of congregation prayer. These settings determine how many minutes after the Azan the Iqamah will be called. Common values: Fajr (15-20 min), Maghrib (5-7 min), others (10-15 min).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                  

                    <!-- Submit Button -->
                    @if($activeTab !== 'profile')
                        <div class="flex pt-4">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold transition shadow-lg">
                                Save Settings
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
