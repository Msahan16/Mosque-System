<div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white dark:text-white">Mosque Management</h2>
                <p class="text-white/80 dark:text-gray-400 mt-1">Manage all registered mosques in the system</p>
            </div>
            <button wire:click="openModal" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Mosque
            </button>
        </div>

        <!-- Mosques Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($mosques as $mosque)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Mosque Header with Background -->
                    <div class="relative h-32 bg-gradient-to-r from-emerald-500 to-teal-600 overflow-hidden">
                        <div class="absolute inset-0 opacity-20">
                            <div class="absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1591604466107-ec97de577aff?q=80&w=500'); background-size: cover; background-position: center;"></div>
                        </div>
                        <div class="absolute bottom-4 left-4 flex items-center space-x-3">
                            @if($mosque->logo)
                                <img src="{{ Storage::url($mosque->logo) }}" alt="{{ $mosque->name }}" class="w-16 h-16 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                <div class="w-16 h-16 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                    <img src="{{ asset('images/mosque.png') }}" alt="Mosque Logo" class="w-12 h-12 object-contain">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mosque Info -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $mosque->name }}</h3>
                                @if($mosque->arabic_name)
                                    <p class="text-lg text-emerald-600 dark:text-emerald-400 mb-2 font-arabic">{{ $mosque->arabic_name }}</p>
                                @endif
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $mosque->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                {{ $mosque->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4 text-sm">
                            @if($mosque->imam_name)
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Imam:</span>&nbsp;{{ $mosque->imam_name }}
                                </div>
                            @endif
                            @if($mosque->phone)
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $mosque->phone }}
                                </div>
                            @endif
                            @if($mosque->address)
                                <div class="flex items-start text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="line-clamp-2">{{ $mosque->address }}</span>
                                </div>
                            @endif>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button wire:click="editMosque({{ $mosque->id }})" class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium">
                                Edit
                            </button>
                            <button 
                                wire:click="$dispatch('swal:confirm', {
                                    title: 'Delete Mosque?',
                                    text: 'This will permanently delete the mosque and all associated data. This action cannot be undone.',
                                    icon: 'warning',
                                    confirmButtonText: 'Yes, Delete',
                                    cancelButtonText: 'Cancel',
                                    eventName: 'confirmDeleteMosque',
                                    eventParams: [{{ $mosque->id }}]
                                })" 
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No mosques registered yet</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add New Mosque" to get started</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">{{ $editMode ? 'Edit Mosque' : 'Add New Mosque' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form wire:submit.prevent="saveMosque" class="space-y-5">
                        <!-- Mosque Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mosque Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="name" type="text" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Arabic Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arabic Name (Optional)
                            </label>
                            <input wire:model="arabic_name" type="text"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-arabic text-lg">
                            @error('arabic_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Address
                            </label>
                            <textarea wire:model="address" rows="3"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Contact Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="phone" type="tel" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="email" type="email" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Imam Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Imam Name
                            </label>
                            <input wire:model="imam_name" type="text"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('imam_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        @if(!$editMode)
                        <!-- Password (Only for new mosque) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Login Password <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="password" type="password" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mosque Logo
                            </label>
                            <input wire:model="logo" type="file" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input wire:model="is_active" type="checkbox" id="is_active"
                                class="w-5 h-5 text-emerald-600 border-gray-300 dark:border-gray-600 rounded focus:ring-emerald-500">
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Active Status
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex space-x-3 pt-4">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-6 py-3 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold transition shadow-lg">
                                {{ $editMode ? 'Update Mosque' : 'Create Mosque' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <style>
        .font-arabic {
            font-family: 'Traditional Arabic', 'Arabic Typesetting', 'Amiri', 'Scheherazade', serif;
            direction: rtl;
        }
    </style>
</div>
