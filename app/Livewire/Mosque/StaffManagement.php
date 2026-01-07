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

    // Form fields
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone;
    public $is_active = true;
    public $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
        'is_active' => 'boolean',
        'selectedPermissions' => 'array',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
    }

    public function render()
    {
        $staff = User::where('mosque_id', $this->mosqueId)
            ->where('role', 'staff')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $availablePermissions = $this->getAvailablePermissions();

        return view('livewire.mosque.staff-management', [
            'staff' => $staff,
            'availablePermissions' => $availablePermissions,
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

        $data = [
            'mosque_id' => $this->mosqueId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => 'staff',
            'is_active' => $this->is_active,
            'permissions' => $this->selectedPermissions,
        ];

        // Only add password if provided (it will be auto-hashed due to 'hashed' cast)
        if ($this->password) {
            $data['password'] = $this->password;
        }

        User::create($data);

        $this->dispatch('swal:success', title: 'Success', text: 'Staff member created successfully!');
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
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateStaff()
    {
        $rules = $this->rules;
        $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->staffId;
        $rules['password'] = 'nullable|string|min:6|confirmed';

        $this->validate($rules);

        $staff = User::findOrFail($this->staffId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'permissions' => $this->selectedPermissions,
        ];

        // Only update password if provided
        if ($this->password) {
            $data['password'] = $this->password;
        }

        $staff->update($data);

        $this->dispatch('swal:success', title: 'Success', text: 'Staff member updated successfully!');
        $this->closeModal();
    }

    public function deleteStaff($id)
    {
        try {
            User::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Staff member deleted successfully!');
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
            'staffId',
            'name',
            'email',
            'password',
            'password_confirmation',
            'phone',
            'selectedPermissions',
            'editMode'
        ]);
        $this->is_active = true;
    }

    public function togglePermission($permission)
    {
        if (in_array($permission, $this->selectedPermissions)) {
            $this->selectedPermissions = array_filter(
                $this->selectedPermissions,
                fn($p) => $p !== $permission
            );
        } else {
            $this->selectedPermissions[] = $permission;
        }
    }
}