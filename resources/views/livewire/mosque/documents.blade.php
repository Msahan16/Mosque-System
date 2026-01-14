<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="w-full sm:w-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white uppercase tracking-tight">Official Documents</h1>
                <p class="text-white/80 mt-1 text-sm sm:text-base">Generate and manage official mosque certificates and letters.</p>
            </div>
            <button wire:click="openModal" class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm transition-all shadow-lg active:scale-95 group">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                CREATE NEW DOCUMENT
            </button>
        </div>

        <!-- Document List -->
        <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Ref. No / Date</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Document Title</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Recipient</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Language / Template</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-all duration-300 group">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $doc->reference_no }}</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">{{ $doc->document_date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $doc->title }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $doc->recipient_name }}</div>
                                    @if($doc->recipient_id_no)
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">ID: {{ $doc->recipient_id_no }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider 
                                            @if($doc->language === 'en') bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400
                                            @elseif($doc->language === 'si') bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                            @else bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 @endif">
                                            {{ strtoupper($doc->language) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $doc->template_type }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="editDocument({{ $doc->id }})" class="p-2.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-600 hover:text-white transition-all border border-blue-100 dark:border-blue-500/20 shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button wire:click="openPrintModal({{ $doc->id }})" class="p-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Print & Download">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        </button>
                                        <button wire:click="openTranslateModal({{ $doc->id }})" class="p-2.5 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Quick Translation">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                        </button>
                                        <button onclick="confirmDeleteDocument({{ $doc->id }})" class="p-2.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-600 hover:text-white transition-all border border-rose-100 dark:border-rose-500/20 shadow-sm" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold tracking-tight">No documents generated yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($documents->hasPages())
                <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto" wire:click.self="closeModal">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl max-w-4xl w-full my-auto overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-8 py-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight">{{ $editMode ? 'Edit Document' : 'Generate New Official Document' }}</h3>
                        <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest mt-1">Official Mosque Letterhead System</p>
                    </div>
                    <button wire:click="closeModal" class="p-2 hover:bg-white/10 rounded-xl transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-8 max-h-[75vh] overflow-y-auto mosque-scrollbar">
                    <form wire:submit.prevent="openPreview" class="space-y-8">
                        <!-- Top Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Document Title *</label>
                                <input type="text" wire:model="title" placeholder="e.g. Identification Certificate" required
                                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                @error('title') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ref. No *</label>
                                <input type="text" wire:model="reference_no" placeholder="e.g. MSQ/001/2026" required
                                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                @error('reference_no') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Recipient Section -->
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 bg-blue-100 dark:bg-blue-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Recipient / Beneficiary Information</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Full Name *</label>
                                    <input type="text" wire:model="recipient_name" placeholder="Name of recipient" required
                                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                    @error('recipient_name') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Recipient ID (NIC/Passport)</label>
                                    <input type="text" wire:model="recipient_id_no" placeholder="Optional ID Number"
                                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Address</label>
                                    <textarea wire:model="recipient_address" placeholder="Recipient address" rows="2"
                                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 outline-none transition-all mosque-scrollbar"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Language & Template Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Document Language</label>
                                <select wire:model="language" class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold outline-none ring-offset-2 focus:ring-4 focus:ring-blue-500/10">
                                    <option value="en">English (Official)</option>
                                    <option value="si">Sinhala (Local)</option>
                                    <option value="ta">Tamil (Local)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Letterhead Template</label>
                                <select wire:model="template_type" class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold outline-none ring-offset-2 focus:ring-4 focus:ring-blue-500/10">
                                    <option value="classic">Islamic Premium (Centered)</option>
                                    <option value="modern">Islamic Modern (Minimalist)</option>
                                    <option value="sidebar">Islamic Sidebar (Left Layout)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Date *</label>
                                <input type="date" wire:model="document_date" required
                                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold outline-none focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Letter Content *</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase mr-2 self-center">Quick Templates:</span>
                                    <button type="button" wire:click="applyTemplate('identity')" class="text-[9px] font-bold bg-blue-50 dark:bg-blue-900/40 px-2 py-1 rounded-lg text-blue-600 border border-blue-100 dark:border-blue-800">Identity</button>
                                    <button type="button" wire:click="applyTemplate('marriage')" class="text-[9px] font-bold bg-blue-50 dark:bg-blue-900/40 px-2 py-1 rounded-lg text-blue-600 border border-blue-100 dark:border-blue-800">Marriage</button>
                                    <button type="button" wire:click="applyTemplate('travel')" class="text-[9px] font-bold bg-blue-50 dark:bg-blue-900/40 px-2 py-1 rounded-lg text-blue-600 border border-blue-100 dark:border-blue-800">Travel</button>
                                    <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1 self-center"></div>
                                    <span class="text-[9px] font-black text-indigo-500 uppercase self-center flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                        Translate:
                                    </span>
                                    <button type="button" wire:click="translateContent('en')" wire:loading.attr="disabled" class="text-[9px] font-black bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full text-slate-600 border border-slate-200 dark:border-slate-700 hover:bg-slate-200 transition-all flex items-center gap-1">
                                        EN
                                    </button>
                                    <button type="button" wire:click="translateContent('si')" wire:loading.attr="disabled" class="text-[9px] font-black bg-indigo-50 dark:bg-indigo-900/40 px-3 py-1 rounded-full text-indigo-600 border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-1">
                                        SINHALA
                                        <div wire:loading wire:target="translateContent('si')" class="w-2 h-2 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                                    </button>
                                    <button type="button" wire:click="translateContent('ta')" wire:loading.attr="disabled" class="text-[9px] font-black bg-emerald-50 dark:bg-emerald-900/40 px-3 py-1 rounded-full text-emerald-600 border border-emerald-100 dark:border-emerald-800 hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-1">
                                        TAMIL
                                        <div wire:loading wire:target="translateContent('ta')" class="w-2 h-2 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
                                    </button>
                                    <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1 self-center"></div>
                                    <button type="button" onclick="insertPlaceholder('{name}')" class="text-[9px] font-bold bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-lg text-slate-500">Insert Name</button>
                                    <button type="button" onclick="insertPlaceholder('{date}')" class="text-[9px] font-bold bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-lg text-slate-500">Insert Date</button>
                                </div>
                            </div>
                            <textarea wire:model="content" placeholder="Type your document content here..." rows="10" required
                                class="w-full px-6 py-5 rounded-[2rem] border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold tracking-tight leading-relaxed focus:ring-4 focus:ring-blue-500/10 outline-none mosque-scrollbar"></textarea>
                            @error('content') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Signatories Section -->
                        <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-700">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Select Authorized Signatories *</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($signatories as $signatory)
                                    <label class="relative flex flex-col p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-blue-500 transition-all group">
                                        <input type="checkbox" wire:model="selectedSignatories" value="{{ $signatory->id }}" class="absolute top-4 right-4 w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 font-black text-sm mb-2">
                                                {{ strtoupper(substr($signatory->name, 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-black text-slate-700 dark:text-white mb-0.5 text-center">{{ $signatory->name }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $signatory->board_role ? str_replace('_', ' ', $signatory->board_role) : 'Administrator' }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedSignatories') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4 pt-4">
                            <button type="button" wire:click="closeModal" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">Cancel</button>
                            <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all">
                                CONTINUE TO PREVIEW
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showTranslateModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto" wire:click.self="closeTranslateModal">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl max-w-2xl w-full my-auto overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-700 text-white px-8 py-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight">Quick AI Translation</h3>
                        <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mt-1">Translate existing document content</p>
                    </div>
                    <button wire:click="closeTranslateModal" class="p-2 hover:bg-white/10 rounded-xl transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-8">
                    <div class="mb-6 flex flex-wrap justify-center gap-3">
                        <button type="button" wire:click="translateContent('en', true)" wire:loading.attr="disabled" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-2">
                            ENGLISH
                        </button>
                        <button type="button" wire:click="translateContent('si', true)" wire:loading.attr="disabled" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 border border-indigo-100 dark:border-indigo-800 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-2">
                            SINHALA
                            <div wire:loading wire:target="translateContent('si', true)" class="w-3 h-3 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <button type="button" wire:click="translateContent('ta', true)" wire:loading.attr="disabled" class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 border border-emerald-100 dark:border-emerald-800 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-2">
                            TAMIL
                            <div wire:loading wire:target="translateContent('ta', true)" class="w-3 h-3 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Translated Content Preview</label>
                        <textarea wire:model="translatingContent" rows="12" class="w-full px-6 py-5 rounded-[2rem] border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold tracking-tight leading-relaxed focus:ring-4 focus:ring-indigo-500/10 outline-none mosque-scrollbar"></textarea>
                    </div>

                    <div class="flex gap-4 pt-8">
                        <button type="button" wire:click="closeTranslateModal" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">Cancel</button>
                        <button type="button" wire:click="saveTranslation" class="flex-[2] py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 active:scale-95 transition-all">
                            SAVE & UPDATE DOCUMENT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Document Preview Modal -->
    @if($showPreview)
        <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-md z-[60] flex items-center justify-center p-4 overflow-y-auto">
            <div class="max-w-5xl w-full my-auto space-y-6">
                <!-- Preview Header/Controls -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-2xl flex items-center justify-between border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-4 pl-4">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Final Document Preview</h3>
                            <p class="text-[10px] font-bold text-slate-500 uppercase">Review all details carefully before generating</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button wire:click="closePreview" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">Back to Edit</button>
                        <button wire:click="{{ $editMode ? 'updateDocument' : 'createDocument' }}" class="px-8 py-2.5 bg-emerald-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all active:scale-95">CONFIRM & SAVE DOCUMENT</button>
                    </div>
                </div>

                <!-- Actual A4 Representation -->
                <div class="bg-white mx-auto shadow-2xl overflow-hidden rounded-sm flex flex-col relative" style="width: 210mm; min-height: 297mm; font-family: 'Inter', sans-serif;">
                    @php
                        $previewContent = str_replace(
                            ['{name}', '{date}', '{ref}', '{recipient_id}'],
                            [$recipient_name, date('d M Y', strtotime($document_date)), $reference_no, $recipient_id_no],
                            $content
                        );
                        $previewContent = nl2br($previewContent);
                        
                        $selectedSigs = \App\Models\User::whereIn('id', $selectedSignatories)->get();
                        $selectedSigIds = $selectedSigs->pluck('id')->toArray();
                    @endphp

                    <!-- Watermark Pattern for Preview -->
                    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 0l15 35 35 15-35 15-15 35-15-35-35-15 35-15z' fill='%23064e3b'/%3E%3C/svg%3E&quot;); background-size: 80px 80px;"></div>

                    @php
                        $previewHeader = '
                        <div class="relative -mx-10 -mt-10 mb-6 border-b-2 border-[#064e3b]">
                            <div class="bg-white p-4 grid grid-cols-5 items-center gap-2 relative overflow-hidden">
                                <div class="col-span-1">
                                    '.($mosque->logo ? '
                                    <div class="bg-slate-50 p-1 rounded-lg inline-block border border-slate-100">
                                        <img src="'.asset('storage/' . $mosque->logo).'" class="h-8 w-8 object-contain">
                                    </div>
                                    ' : '').'
                                </div>

                                <div class="col-span-3 text-center px-2">
                                    <h1 class="text-base font-black uppercase leading-tight tracking-[0.05em] text-[#064e3b]">
                                        '.$mosque->name.'
                                    </h1>
                                    <div class="h-0.5 w-6 bg-slate-100 mx-auto mt-1 rounded-full"></div>
                                </div>

                                <div class="col-span-1 text-right relative z-10">
                                    <p class="text-[5px] font-black uppercase tracking-widest text-[#064e3b] opacity-20 mb-1">Contact</p>
                                    <div class="text-[7px] font-bold text-slate-300 leading-tight">
                                        <p>'.$mosque->phone.'</p>
                                        <p class="text-[6px] text-slate-200 uppercase">'.$mosque->city.'</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    @endphp

                    @if($template_type === 'classic')
                        <!-- SIMPLE CLASSIC PREVIEW -->
                        <div class="relative flex flex-col flex-grow p-10 bg-white">
                            {!! $previewHeader !!}

                            <!-- Meta Info -->
                            <div class="flex justify-between items-end mb-8 w-full font-black text-slate-300">
                                <div class="text-[7px]">
                                    <p class="uppercase mb-0.5">Ref No.</p>
                                    <p class="text-slate-900">{{ $reference_no }}</p>
                                </div>
                                <div class="text-right text-[7px]">
                                    <p class="uppercase mb-0.5">Dated</p>
                                    <p class="text-slate-900">{{ date('d M, Y', strtotime($document_date)) }}</p>
                                </div>
                            </div>

                            <!-- Recipient -->
                            <div class="mb-10 pl-4 border-l-2 border-slate-100 w-full">
                                <p class="text-[8px] font-black text-slate-300 uppercase mb-1">Recipient:</p>
                                <p class="text-lg font-black text-slate-900 uppercase leading-none">{{ $recipient_name }}</p>
                                <p class="text-xs text-slate-400 font-bold whitespace-pre-line mt-2">{{ $recipient_address }}</p>
                            </div>

                            <!-- Body -->
                            <div class="flex-grow w-full">
                                <h2 class="text-sm font-black border-b border-slate-50 pb-2 mb-6 uppercase">
                                    Document Title: {{ $title }}
                                </h2>
                                <div class="text-xs leading-relaxed text-slate-800 space-y-4 font-medium mb-12">
                                    {!! $previewContent !!}
                                </div>
                            </div>

                            <!-- Signatories -->
                            <div class="w-full flex flex-wrap @if(count($selectedSigs) > 1) justify-between @else justify-end @endif gap-8 border-t pt-6 border-slate-50">
                                @foreach($selectedSigs as $sig)
                                    <div class="min-w-[40mm] text-center">
                                        <div class="h-6 border-b border-slate-100 mb-2"></div>
                                        <p class="text-xs font-black text-slate-900 uppercase leading-none">{{ $sig->name }}</p>
                                        <p class="text-[8px] font-bold text-slate-300 mt-1 uppercase">{{ $sig->board_role ? str_replace('_', ' ', $sig->board_role) : 'Administrator' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($template_type === 'modern')
                        <!-- SIMPLE MODERN PREVIEW -->
                        <div class="relative flex flex-col p-10 bg-white flex-grow">
                            {!! $previewHeader !!}

                            <div class="grid grid-cols-2 gap-8 mb-10">
                                <div>
                                    <p class="text-[8px] font-black text-slate-300 uppercase mb-2">To</p>
                                    <p class="text-xl font-black text-slate-900 uppercase">{{ $recipient_name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold whitespace-pre-line mt-1">{{ $recipient_address }}</p>
                                </div>
                                <div class="text-right flex flex-col justify-end text-[8px] font-black text-slate-300">
                                    <p><span class="uppercase mr-2">Ref:</span> <span class="text-slate-900">{{ $reference_no }}</span></p>
                                    <p><span class="uppercase mr-2">Date:</span> <span class="text-slate-900">{{ date('d M Y', strtotime($document_date)) }}</span></p>
                                </div>
                            </div>

                            <div class="flex-grow">
                                <h2 class="text-base font-black text-slate-900 mb-8 border-b border-slate-100 inline-block uppercase">
                                    {{ $title }}
                                </h2>
                                <div class="text-xs leading-relaxed text-slate-800 space-y-4 font-medium min-h-[100mm]">
                                    {!! $previewContent !!}
                                </div>
                            </div>

                            <div class="mt-12 flex gap-12 justify-start">
                                @foreach($selectedSigs as $sig)
                                    <div class="min-w-[40mm]">
                                        <p class="text-[7px] font-black text-slate-300 uppercase mb-6">Authorization</p>
                                        <div class="border-t border-slate-900 pt-2">
                                            <p class="text-xs font-black text-slate-900 uppercase">{{ $sig->name }}</p>
                                            <p class="text-[8px] font-bold text-slate-400 mt-0.5 uppercase">{{ $sig->board_role ? str_replace('_', ' ', $sig->board_role) : 'Administrator' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @else
                        <!-- SIMPLE SIDEBAR PREVIEW -->
                        <div class="flex flex-col flex-grow relative bg-white">
                            {!! $previewHeader !!}
                            
                            <div class="flex flex-grow px-10">
                                <!-- Sidebar -->
                                <div class="w-[50mm] border-r border-slate-50 flex-shrink-0 flex flex-col pt-4 bg-slate-50/10">
                                    <div class="space-y-10 px-4">
                                        <div>
                                            <p class="text-[7px] font-black text-slate-300 uppercase tracking-widest mb-4">Registry</p>
                                            <div class="space-y-6">
                                                @foreach($selectedSigs as $sig)
                                                    <div>
                                                        <p class="text-[9px] font-black text-slate-900 uppercase leading-none">{{ $sig->name }}</p>
                                                        <p class="text-[7px] font-bold text-slate-300 uppercase mt-0.5">{{ $sig->board_role ? str_replace('_', ' ', $sig->board_role) : 'Admin' }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content -->
                                <div class="flex-grow p-6 flex flex-col">
                                    <div class="flex justify-between items-start mb-10 border-b border-slate-50 pb-4 text-[7px] font-black text-slate-300">
                                        <div>REF: <span class="text-slate-900">{{ $reference_no }}</span></div>
                                        <div>DATE: <span class="text-slate-900">{{ date('d M, Y', strtotime($document_date)) }}</span></div>
                                    </div>

                                    <div class="mb-10">
                                        <p class="text-[8px] font-black text-slate-300 uppercase mb-2">Recipient</p>
                                        <p class="text-lg font-black text-slate-900 uppercase leading-none">{{ $recipient_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold whitespace-pre-line mt-1">{{ $recipient_address }}</p>
                                    </div>

                                    <div class="flex-grow">
                                        <h2 class="text-sm font-black border-b border-slate-50 pb-2 mb-6 uppercase">
                                            {{ $title }}
                                        </h2>
                                        <div class="text-[11px] leading-relaxed text-slate-700 space-y-4 font-medium">
                                            {!! $previewContent !!}
                                        </div>
                                    </div>

                                    <div class="mt-10 border-t border-slate-50 pt-4 text-right">
                                        <p class="text-[8px] font-black text-slate-100 uppercase">Official Record</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="h-10"></div> <!-- Spacer -->
            </div>
        </div>
    @endif

    <!-- Print/Download Modal -->
    @if($showPrintModal)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[70] flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-[3rem] shadow-2xl w-[90vw] h-[95vh] overflow-hidden flex flex-col">
                <!-- Modal Header -->
                <div class="px-10 py-6 border-b border-slate-100 dark:border-slate-700 flex flex-wrap items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 rounded-[1.25rem] flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Print & Export Center</h3>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Document Fidelity Control</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button onclick="frames['print_frame'].print()" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Print
                        </button>
                        <a href="{{ route('mosque.documents.print', ['document' => $printingDocumentId, 'download' => 1]) }}" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download PDF
                        </a>
                        <div class="w-px h-8 bg-slate-200 dark:bg-slate-700 mx-2"></div>
                        <button wire:click="closePrintModal" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">
                            Close
                        </button>
                    </div>
                </div>

                <!-- Iframe Viewer -->
                <div class="flex-grow bg-[#f1f5f9] dark:bg-slate-900 overflow-hidden relative">
                    @if($printingDocumentId)
                        <iframe name="print_frame" src="{{ route('mosque.documents.print', ['document' => $printingDocumentId, 'autoprint' => 0]) }}" class="w-full h-full border-none shadow-inner bg-transparent" onload="document.getElementById('iframe_loader').classList.add('opacity-0', 'pointer-events-none')"></iframe>
                    @endif
                    
                    <!-- Loading Overlay (Initial) -->
                    <div id="iframe_loader" class="absolute inset-0 bg-white dark:bg-slate-800 flex flex-col items-center justify-center transition-opacity duration-300">
                        <div class="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin mb-4"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-bold">Preparing High-Fidelity Preview...</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function insertPlaceholder(tag) {
            const textarea = document.querySelector('textarea[wire\\:model="content"]');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const before = text.substring(0, start);
            const after = text.substring(end, text.length);
            textarea.value = before + tag + after;
            @this.set('content', textarea.value);
            textarea.focus();
        }

        function confirmDeleteDocument(id) {
            Swal.fire({
                title: 'Delete Document?',
                text: 'This will permanently remove this generated document. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteDocument', id);
                }
            });
        }

        function printDocument(id) {
            window.open(`/mosque/documents/${id}/print`, '_blank');
        }
    </script>
    </div>
</div>
