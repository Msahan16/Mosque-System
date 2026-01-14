<?php

namespace App\Livewire\Mosque;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class StaffManagement extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteStaff' => 'deleteStaff'];

    public $mosqueId;
    public $showModal = false;
    public $editMode = false;
    public $staffId;
    public $showViewModal = false;
    public $viewStaffId;
    public $staffDetails = null;
    public $isEditingAdmin = false;

    // Form fields
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone;
    public $is_active = true;
    public $selectedPermissions = [];
    public $board_role = 'member';
    public $custom_board_role;
    public $term_year;
    public $selectedYear;

    public $boardRoles = [
        'admin' => 'Masjid Administrator',
        'president' => 'Head (President)',
        'secretary' => 'Secretary',
        'treasurer' => 'Treasurer',
        'member' => 'Other Member'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        'phone' => 'nullable|string|max:20',
        'is_active' => 'boolean',
        'selectedPermissions' => 'array',
        'board_role' => 'required|in:president,secretary,treasurer,member',
        'custom_board_role' => 'nullable|string|max:255',
        'term_year' => 'required|integer',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedIsActive($value)
    {
        if ($value && empty($this->selectedPermissions)) {
            $this->grantAllPermissions();
        } elseif (!$value) {
            $this->removeAllPermissions();
        }
    }

    public function mount($mosqueId = null)
    {
        // Get mosque ID from authenticated user
        if (Auth::check() && (Auth::user()->role === 'mosque' || Auth::user()->role === 'admin')) {
            $this->mosqueId = Auth::user()->mosque_id;
        } elseif ($mosqueId) {
            $this->mosqueId = $mosqueId;
        } else {
            abort(403, 'Unable to determine mosque.');
        }

        $this->term_year = date('Y');
        $this->selectedYear = date('Y');
    }

    public function render()
    {
        $staff = User::where('mosque_id', $this->mosqueId)
            ->where('role', 'staff')
            ->where('term_year', $this->selectedYear)
            ->orderByRaw("FIELD(board_role, 'president', 'secretary', 'treasurer', 'member')")
            ->orderBy('name', 'asc')
            ->paginate(10);

        // Fetch the main mosque administrator for this mosque
        $mosqueAdmin = User::where('mosque_id', $this->mosqueId)
            ->where('role', 'mosque')
            ->first();

        $availablePermissions = $this->getAvailablePermissions();
        
        $dbYears = User::where('mosque_id', $this->mosqueId)
            ->where('role', 'staff')
            ->whereNotNull('term_year')
            ->distinct()
            ->pluck('term_year')
            ->toArray();

        $currentYear = (int)date('Y');
        $rangeYears = [];
        for ($i = 0; $i <= 5; $i++) {
            $rangeYears[] = $currentYear - $i;
        }

        $years = collect(array_unique(array_merge($dbYears, $rangeYears)))->sortDesc();

        return view('livewire.mosque.staff-management', [
            'staff' => $staff,
            'mosqueAdmin' => $mosqueAdmin,
            'availablePermissions' => $availablePermissions,
            'years' => $years,
            'selectableYears' => $rangeYears,
        ]);
    }

    private function getAvailablePermissions()
    {
        return [
            'dashboard' => 'Dashboard',
            'santha' => 'Santha Management',
            'students' => 'Student Management',
            'donations' => 'Donation Management',
            'porridge' => 'Porridge Management',
            'baithulmal' => 'Baithulmal Management',
            'imam' => 'Imam Management',
            'ustad' => 'Ustad Management',
            'prayer_schedule' => 'Prayer Schedule',
            'families' => 'Family Management',
            'board' => 'Mosque Board',
            'documents' => 'Document Management',
            'settings' => 'Mosque Settings',
            'reports' => 'Reports & Analytics',
        ];
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function createStaff()
    {
        $this->validate();

        User::create([
            'mosque_id' => $this->mosqueId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'role' => 'staff',
            'is_active' => $this->is_active,
            'permissions' => $this->selectedPermissions,
            'board_role' => $this->board_role,
            'custom_board_role' => $this->board_role === 'member' ? $this->custom_board_role : null,
            'term_year' => $this->term_year,
        ]);

        $this->dispatch('swal:success', title: 'Success', text: 'Board member added successfully!');
        $this->closeModal();
    }

    public function editStaff($id)
    {
        $staff = User::findOrFail($id);
        
        $this->staffId = $staff->id;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->phone = $staff->phone;
        $this->is_active = $staff->is_active;
        $this->selectedPermissions = $staff->getPermissionKeys();
        $this->board_role = $staff->board_role ?? 'member';
        $this->custom_board_role = $staff->custom_board_role;
        $this->term_year = $staff->term_year;
        
        $this->isEditingAdmin = $staff->role === 'mosque';
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateStaff()
    {
        $rules = $this->rules;
        $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->staffId;
        $rules['password'] = 'nullable|string|min:6';

        $this->validate($rules);

        $staff = User::findOrFail($this->staffId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'permissions' => $this->selectedPermissions,
            'board_role' => $this->board_role,
            'custom_board_role' => $this->board_role === 'member' ? $this->custom_board_role : null,
            'term_year' => $this->term_year,
        ];

        // Only update password if provided
        if ($this->password) {
            $data['password'] = $this->password;
        }

        $staff->update($data);

        $this->dispatch('swal:success', title: 'Success', text: 'Board member updated successfully!');
        $this->closeModal();
    }

    public function deleteStaff($id)
    {
        try {
            User::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Board member deleted successfully!');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $staff = User::findOrFail($id);
            $staff->update(['is_active' => !$staff->is_active]);
            $this->dispatch('swal:success', title: 'Success', text: 'Staff status updated successfully!');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewStaff($id)
    {
        try {
            $this->staffDetails = User::findOrFail($id);
            $this->showViewModal = true;
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->staffDetails = null;
    }

    private function resetForm()
    {
        $this->reset([
            'staffId', 'name', 'email', 'password', 'password_confirmation',
            'phone', 'selectedPermissions', 'editMode', 'board_role', 'custom_board_role', 'isEditingAdmin'
        ]);
        $this->term_year = date('Y');
        $this->is_active = true;
    }

    public function togglePermission($permission)
    {
        if (in_array($permission, $this->selectedPermissions)) {
            $this->selectedPermissions = array_values(array_filter(
                $this->selectedPermissions,
                fn($p) => $p !== $permission
            ));
        } else {
            $this->selectedPermissions[] = $permission;
        }
    }

    public function grantAllPermissions()
    {
        $this->selectedPermissions = array_keys($this->getAvailablePermissions());
    }

    public function removeAllPermissions()
    {
        $this->selectedPermissions = [];
    }
}