@section('title', 'Mosque Board Management')

<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-4xl font-black text-white drop-shadow-lg uppercase tracking-tight">Mosque Restriction / Wakfs Board</h2>
                <p class="text-white font-bold mt-1 text-sm sm:text-base drop-shadow-md opacity-90">Official Committee records and Board history management</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex bg-white/10 backdrop-blur-md p-1 rounded-xl border border-white/20">
                    <select wire:model.live="selectedYear" class="bg-transparent text-white border-none focus:ring-0 text-sm font-bold cursor-pointer pr-8">
                        @foreach($years as $y)
                            <option value="{{ $y }}" class="text-gray-900">{{ $y }} Board</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Board Member
                </button>
            </div>
        </div>

        <!-- Board Table -->
        <div class="bg-white/95 dark:bg-slate-900/90 backdrop-blur-xl rounded-[2rem] shadow-2xl overflow-hidden border border-white/20 dark:border-slate-700/50">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-slate-200 dark:divide-slate-800">
                    <thead class="bg-slate-50 dark:bg-slate-950/50">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Board Position</th>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Member Details</th>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Contact info</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Access Status</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @if($mosqueAdmin)
                            <tr class="bg-indigo-50/30 dark:bg-indigo-900/10 border-l-4 border-indigo-500 transition-all duration-300 group">
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">
                                        System Administrator
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $mosqueAdmin->name }}</div>
                                    <div class="text-[10px] text-indigo-500 dark:text-indigo-400 font-medium mt-0.5">Primary System Access</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-300">
                                        <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $mosqueAdmin->email }}
                                    </div>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 dark:text-slate-500 font-bold mt-1">
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $mosqueAdmin->phone ?? 'Unlisted' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-4 py-1.5 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-full bg-indigo-500 text-white shadow-sm">
                                        Super User
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button wire:click="viewStaff({{ $mosqueAdmin->id }})" 
                                            class="p-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 text-slate-600 dark:text-slate-400 rounded-xl transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                        <button wire:click="editStaff({{ $mosqueAdmin->id }})" 
                                            class="p-2.5 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 rounded-xl transition-all border border-indigo-100 dark:border-indigo-500/20 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @forelse($staff as $member)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-all duration-300 group">
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider
                                        @if($member->board_role === 'president') bg-amber-100 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20
                                        @elseif($member->board_role === 'secretary') bg-blue-100 text-blue-700 border border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20
                                        @elseif($member->board_role === 'treasurer') bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20
                                        @else bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-700/30 dark:text-slate-400 dark:border-slate-700/50 @endif">
                                        {{ $member->board_role === 'member' && $member->custom_board_role ? $member->custom_board_role : ($boardRoles[$member->board_role] ?? 'Member') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $member->name }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $member->term_year }} Session</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-300">
                                        <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $member->email }}
                                    </div>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 dark:text-slate-500 font-bold mt-1">
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $member->phone ?? 'Unlisted' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button wire:click="toggleStatus({{ $member->id }})" 
                                        class="px-4 py-1.5 inline-flex text-[10px] font-bold uppercase tracking-widest rounded-full transition-all duration-300 shadow-sm
                                        {{ $member->is_active ? 'bg-emerald-500 text-white hover:bg-emerald-600' : 'bg-rose-500 text-white hover:bg-rose-600' }}">
                                        {{ $member->is_active ? 'Active' : 'Locked' }}
                                    </button>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button wire:click="viewStaff({{ $member->id }})" 
                                            class="p-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 text-slate-600 dark:text-slate-400 rounded-xl transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                        <button wire:click="editStaff({{ $member->id }})" 
                                            class="p-2.5 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 rounded-xl transition-all border border-blue-100 dark:border-blue-500/20 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button onclick="confirmDeleteStaff({{ $member->id }})" 
                                            class="p-2.5 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 text-rose-600 dark:text-rose-400 rounded-xl transition-all border border-rose-100 dark:border-rose-500/20 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <p class="text-slate-900 dark:text-white text-lg font-black uppercase tracking-widest">No board records</p>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm font-bold mt-1">No members found for the {{ $selectedYear }} session.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950/50 border-t border-slate-200 dark:border-slate-800">
                {{ $staff->links() }}
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editMode ? 'Edit Board Member' : 'Add New Board Member' }}</h3>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[85vh] overflow-y-auto">
                    <form wire:submit.prevent="{{ $editMode ? 'updateStaff' : 'createStaff' }}" class="space-y-4">
                        @if(!$isEditingAdmin)
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Term Session (Year)</label>
                                    <select wire:model="term_year" 
                                        class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                                        @foreach($selectableYears as $y)
                                            <option value="{{ $y }}">{{ $y }} Board</option>
                                        @endforeach
                                    </select>
                                    @error('term_year') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Board Position</label>
                                        <select wire:model.live="board_role" 
                                            class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                                            @foreach($boardRoles as $val => $lbl)
                                                @if($val !== 'admin')
                                                    <option value="{{ $val }}">{{ $lbl }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('board_role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    @if($board_role === 'member')
                                        <div class="animate-in slide-in-from-top-2 duration-300">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Specific Title (Optional)</label>
                                            <input type="text" wire:model="custom_board_role" placeholder="e.g. Spokesperson"
                                                class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none placeholder:text-gray-400">
                                            @error('custom_board_role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800 flex items-center gap-3">
                                <div class="bg-indigo-500 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 20.944a11.955 11.955 0 01-8.618-3.04m17.236 0a11.955 11.955 0 01-8.618 3.04"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-indigo-700 dark:text-indigo-300 uppercase">Primary Administrator Account</p>
                                    <p class="text-[10px] text-indigo-600 dark:text-indigo-400">This account has full control over the mosque system and permissions.</p>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name *</label>
                            <input type="text" wire:model="name" required placeholder="Member's Name"
                                class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email *</label>
                                <input type="email" wire:model="email" required placeholder="email@example.com"
                                    class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Phone</label>
                                <input type="text" wire:model="phone" placeholder="07XXXXXXXX"
                                    class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Login Password {{ $editMode ? '' : '*' }}</label>
                                <input type="password" wire:model="password" placeholder="••••••••"
                                    class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 outline-none">
                                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-center pt-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="is_active" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        </div>

                        @if(!$isEditingAdmin)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">System Permissions</label>
                                    @if($is_active)
                                        <div class="flex gap-2">
                                            <button type="button" wire:click="grantAllPermissions" class="text-[10px] font-bold text-blue-600 hover:text-blue-700 uppercase tracking-tighter">Grant All</button>
                                            <span class="text-gray-300">|</span>
                                            <button type="button" wire:click="removeAllPermissions" class="text-[10px] font-bold text-rose-600 hover:text-rose-700 uppercase tracking-tighter">Remove All</button>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-2 gap-2 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-200 dark:border-gray-700 max-h-48 overflow-y-auto {{ !$is_active ? 'opacity-50 grayscale' : '' }}">
                                    @foreach($availablePermissions as $key => $label)
                                        <label class="flex items-center gap-2 {{ $is_active ? 'cursor-pointer' : 'cursor-not-allowed' }} group">
                                            <input type="checkbox" 
                                                @if(!$is_active) disabled @endif
                                                @checked(in_array($key, $selectedPermissions ?? [])) 
                                                wire:click="togglePermission('{{ $key }}')"
                                                class="w-3.5 h-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-[10px] font-semibold text-gray-600 dark:text-gray-400 {{ $is_active ? 'group-hover:text-blue-600' : '' }} transition-colors">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @if(!$is_active)
                                    <p class="text-[10px] text-rose-500 mt-2 text-center font-bold italic">Enable "Active" above to assign permissions.</p>
                                @else
                                    <p class="text-[10px] text-blue-500 mt-2 text-center font-bold">Select the specific pages this member can manage.</p>
                                @endif
                            </div>
                        @else
                            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800 flex items-center gap-3">
                                <div class="bg-emerald-500 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 20.944a11.955 11.955 0 01-8.618-3.04m17.236 0a11.955 11.955 0 01-8.618 3.04"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-emerald-700 dark:text-emerald-300 uppercase">Full System Access</p>
                                    <p class="text-[10px] text-emerald-600 dark:text-emerald-400">This administrator account has full access to all system features and permissions.</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-6 py-3 text-sm font-bold text-gray-500 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-[2] px-6 py-3 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/20">
                                {{ $editMode ? 'Update Member' : 'Save Member' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Member Modal -->
    @if($showViewModal && $staffDetails)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeViewModal">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold">Board Member Profile</h3>
                    <button wire:click="closeViewModal" class="text-white/80 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex flex-col items-center pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-3xl font-black mb-3 shadow-lg">
                            {{ strtoupper(substr($staffDetails->name, 0, 1)) }}
                        </div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white">{{ $staffDetails->name }}</h4>
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-black uppercase tracking-widest mt-1">
                            {{ $staffDetails->board_role === 'member' && $staffDetails->custom_board_role ? $staffDetails->custom_board_role : ($boardRoles[$staffDetails->board_role] ?? 'Member') }} ({{ $staffDetails->term_year }})
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email Address</p>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate">{{ $staffDetails->email }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Phone Number</p>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $staffDetails->phone ?? 'Not Provided' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-center">Active Permissions</p>
                        <div class="flex flex-wrap justify-center gap-1.5">
                            @php
                                $userPermissions = $staffDetails->getPermissionKeys();
                                $isFullAccess = count($userPermissions) >= count($availablePermissions);
                            @endphp

                            @if($isFullAccess)
                                <span class="px-4 py-1.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200 dark:border-emerald-800 animate-pulse">
                                    Full System Access Granted
                                </span>
                            @else
                                @forelse($userPermissions as $perm)
                                    <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-[9px] font-black uppercase border border-blue-200 dark:border-blue-800">
                                        {{ str_replace('_', ' ', $perm) }}
                                    </span>
                                @empty
                                    <span class="text-xs font-bold text-gray-400 italic">No special permissions granted</span>
                                @endforelse
                            @endif
                        </div>
                    </div>

                    <button wire:click="closeViewModal" class="w-full py-3 bg-gray-900 text-white rounded-2xl font-bold text-sm hover:bg-gray-800 transition active:scale-95">
                        Close Profile
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function confirmDeleteStaff(staffId) {
    Swal.fire({
        title: 'Delete Board Member?',
        text: 'This will permanently remove the member and their history from this term session.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Remove!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('confirmDeleteStaff', { id: staffId });
        }
    });
}
</script>
