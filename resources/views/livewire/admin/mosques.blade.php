<div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Mosque Management</h2>
                <p class="text-white/80 dark:text-gray-400 mt-1 text-sm sm:text-base">Manage all registered mosques in the system</p>
            </div>
            <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-lg text-sm sm:text-base">
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
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editMode ? 'Edit Mosque' : 'Add Mosque' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-xs font-semibold text-red-700 dark:text-red-400 mb-2">Please fix the following errors:</p>
                            <ul class="text-xs text-red-600 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form wire:submit.prevent="saveMosque" class="space-y-3">
                        <!-- Mosque Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="name" type="text" required placeholder="Mosque name"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                            @error('name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Arabic Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Arabic Name
                            </label>
                            <input wire:model="arabic_name" type="text" placeholder="Name in Arabic" 
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500 font-arabic text-lg">
                            @error('arabic_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone & Email -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="phone" type="tel" required placeholder="Phone"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                @error('phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="email" type="email" required placeholder="Email"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                @error('email') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <textarea wire:model="address" rows="2" placeholder="Address"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500"></textarea>
                            @error('address') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Country & Province -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Country <span class="text-red-500">*</span>
                                </label>
                                <input type="text" value="Sri Lanka" disabled
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Province <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="selectedProvince" wire:change="updateProvinceLocation" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                    @foreach($sriLankaProvinces as $key => $province)
                                        <option value="{{ $key }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('selectedProvince') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <!-- User Credentials (Only for new mosque) -->
                        @if(!$editMode)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                            <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Login Credentials</h4>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="user_name" type="email" required placeholder="sahan@gmail.com"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                                @error('user_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="mt-2">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="user_password" wire:model="user_password" type="password" required placeholder="Minimum 8 characters"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500 pr-10">
                                    <button type="button" onclick="togglePassword('user_password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                                        <svg id="user_password-eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('user_password') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        @endif

                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Logo
                            </label>
                            <input wire:model="logo" type="file" accept="image/*"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-emerald-500">
                            @error('logo') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input wire:model="is_active" type="checkbox" id="is_active"
                                class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-gray-600 rounded focus:ring-emerald-500">
                            <label for="is_active" class="ml-2 text-xs font-medium text-gray-700 dark:text-gray-300">
                                Active
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-4 py-1.5 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold text-xs transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 font-semibold text-xs transition shadow-lg">
                                {{ $editMode ? 'Update' : 'Create' }}
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

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-4.753 4.753m4.454-2.306a3.366 3.366 0 00-4.754-4.754"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</div>
