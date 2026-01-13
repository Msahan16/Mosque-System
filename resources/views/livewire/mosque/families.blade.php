@section('title', 'Families Management')

<div class="py-6 min-h-screen">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="w-full sm:w-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-white dark:text-white">Families Management</h2>
                <p class="text-white/80 dark:text-white-400 mt-1 text-sm sm:text-base">Manage registered families and their members</p>
            </div>
            <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-900 transition shadow-lg text-sm sm:text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Family
            </button>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input wire:model.live="search" type="text" placeholder="Search families by name, phone, or address..." 
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
        </div>

        <!-- Families Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm sm:text-base">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Family Head</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Address</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($families as $family)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($family->family_head_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $family->family_head_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $family->family_head_profession }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $family->phone }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $family->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $family->total_members }} Members
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white line-clamp-2">{{ $family->address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:justify-center sm:space-x-1">
                                        <button wire:click="viewMembers({{ $family->id }})" title="View Members" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Members</span>
                                        </button>
                                        <button wire:click="editFamily({{ $family->id }})" title="Edit Family" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button onclick="confirmDelete('confirmDeleteFamily', {{ $family->id }}, 'Delete Family?', 'This will permanently delete the family and all associated data. This action cannot be undone.')" title="Delete" class="w-full sm:w-auto px-2 sm:px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium flex items-center justify-center sm:justify-start gap-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">No families registered yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Click "Add New Family" to register a family</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($families->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $families->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-3 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editMode ? 'Edit Family' : 'Add Family' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="saveFamily" class="space-y-3">
                        <!-- Family ID (Required) -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Family ID <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="family_id" type="text" required placeholder="e.g., FAM001, F-2024-001"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                            @error('family_id') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Unique identifier for this family</p>
                        </div>

                        <!-- Family Head Name & Profession -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Head Name <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="family_head_name" type="text" required placeholder="Full name"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('family_head_name') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Profession
                                </label>
                                <input wire:model="family_head_profession" type="text" placeholder="Job/profession"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('family_head_profession') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Phone & Email -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="phone" type="tel" required placeholder="Phone"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('phone') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input wire:model="email" type="email" placeholder="Email"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('email') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="address" required rows="2" placeholder="Address"
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('address') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Members & Income -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Members <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="total_members" type="number" required min="1" placeholder="No. of members"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('total_members') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Income (LKR)
                                </label>
                                <input wire:model="family_income" type="number" step="0.01" placeholder="Monthly income"
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('family_income') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Registration Date & Active -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Reg. Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="registration_date" type="date" required
                                    class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500">
                                @error('registration_date') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-end">
                                <label class="flex items-center gap-2">
                                    <input wire:model="is_active" type="checkbox"
                                        class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="notes" rows="1" placeholder="Optional notes..."
                                class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                            @error('notes') <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Family Members Section -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-5 mt-5">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                <p class="text-sm text-blue-800 dark:text-blue-300">
                                    <strong>✓ Family Head</strong> will be automatically added as the first member when you click "Add Family"
                                </p>
                            </div>

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Additional Family Members</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Add other family members (wife, children, parents, etc.)</p>
                            
                            <!-- Add Member Form -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 mb-4">
                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Add Additional Member</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <input wire:model="memberName" type="text" placeholder="Full Name *"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                        @error('memberName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <input wire:model="memberRelation" type="text" placeholder="Relation (Wife, Son, Daughter, etc.) *"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                        @error('memberRelation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <select wire:model="memberGender"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                            <option value="">Select Gender *</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('memberGender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <input wire:model="memberDob" type="date" placeholder="Date of Birth"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                        @error('memberDob') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <input wire:model="memberOccupation" type="text" placeholder="Occupation"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                    </div>
                                    <div>
                                        <input wire:model="memberEducation" type="text" placeholder="Education"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                    </div>
                                    <div>
                                        <input wire:model="memberPhone" type="tel" placeholder="Phone"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                    </div>
                                    <div>
                                        <input wire:model="memberEmail" type="email" placeholder="Email"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                    </div>
                                    <div>
                                        <input wire:model="memberNotes" type="text" placeholder="Notes"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 text-sm">
                                    </div>
                                </div>
                                <button type="button" wire:click="addMember"
                                    class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                    + Add Additional Member
                                </button>
                            </div>

                            <!-- Members List -->
                            @if(count($members) > 0)
                                <div class="space-y-2">
                                    <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Members ({{ count($members) }})</h5>
                                    @foreach($members as $index => $member)
                                        <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $member['name'] }} 
                                                    <span class="text-gray-500 dark:text-gray-400">({{ $member['relation'] }})</span>
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $member['gender'] }}
                                                    @if($member['date_of_birth'])
                                                        • {{ \Carbon\Carbon::parse($member['date_of_birth'])->age }} years
                                                    @endif
                                                    @if($member['occupation'])
                                                        • {{ $member['occupation'] }}
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeMember({{ $index }})"
                                                class="ml-3 px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No additional members added yet</p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2 pt-1">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-4 py-1.5 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold text-xs transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-1.5 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 font-semibold text-xs transition shadow-lg">
                                {{ $editMode ? 'Update' : 'Add Family' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Members Modal -->
    @if($showMembersModal && $selectedFamily)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeMembersModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">Family Members</h3>
                            <p class="text-blue-100 text-sm mt-1">{{ $selectedFamily->family_head_name }} - {{ $selectedFamily->phone }}</p>
                        </div>
                        <button wire:click="closeMembersModal" class="text-white hover:text-gray-200 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    @if($selectedFamily->members->count() > 0)
                        <div class="space-y-4">
                            @foreach($selectedFamily->members as $member)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $member->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $member->relation }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                            @if($member->gender === 'Male')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @else
                                                bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @endif">
                                            {{ $member->gender }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        @if($member->dob)
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Date of Birth:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->dob->format('d M, Y') }}</p>
                                            </div>
                                        @endif
                                        @if($member->occupation)
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Occupation:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->occupation }}</p>
                                            </div>
                                        @endif
                                       
                                        @if($member->blood_group)
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Blood Group:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->blood_group }}</p>
                                            </div>
                                        @endif
                                        @if($member->phone)
                                            <div class="col-span-2">
                                                <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->phone }}</p>
                                            </div>
                                        @endif
                                        @if($member->email)
                                            <div class="col-span-2">
                                                <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->email }}</p>
                                            </div>
                                        @endif
                                        @if($member->notes)
                                            <div class="col-span-2">
                                                <span class="text-gray-600 dark:text-gray-400">Notes:</span>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">No members registered for this family</p>
                        </div>
                    @endif

                    <!-- Close Button -->
                    <div class="flex justify-end mt-6">
                        <button wire:click="closeMembersModal" class="px-6 py-3 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-semibold transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
