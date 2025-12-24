<?php

namespace App\Livewire\Admin;

use App\Models\Mosque;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.app')]
class Mosques extends Component
{
    use WithFileUploads;

    protected $listeners = ['confirmDeleteMosque' => 'deleteMosque'];

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $mosqueId;

    // Mosque fields
    public $name, $arabic_name, $address, $city, $state, $postal_code;
    public $phone, $email, $description, $imam_name, $logo, $is_active = true;

    // User credentials
    public $user_name, $user_email, $user_password;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'arabic_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => $this->editMode ? 'required|email|unique:mosques,email,'.$this->mosqueId : 'required|email|unique:mosques,email',
            'description' => 'nullable|string',
            'imam_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];

        if (!$this->editMode) {
            $rules['user_name'] = 'required|string|max:255';
            $rules['user_email'] = 'required|email|unique:users,email';
            $rules['user_password'] = 'required|string|min:8';
        }

        return $rules;
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

    public function editMosque($id)
    {
        $mosque = Mosque::findOrFail($id);
        $this->mosqueId = $mosque->id;
        $this->name = $mosque->name;
        $this->arabic_name = $mosque->arabic_name;
        $this->address = $mosque->address;
        $this->city = $mosque->city;
        $this->state = $mosque->state;
        $this->postal_code = $mosque->postal_code;
        $this->phone = $mosque->phone;
        $this->email = $mosque->email;
        $this->description = $mosque->description;
        $this->imam_name = $mosque->imam_name;
        $this->is_active = $mosque->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveMosque()
    {
        $this->validate();

        try {
            $logoPath = null;
            if ($this->logo) {
                $logoPath = $this->logo->store('mosques', 'public');
            }

            if ($this->editMode) {
                $mosque = Mosque::findOrFail($this->mosqueId);
                $mosque->update([
                    'name' => $this->name,
                    'arabic_name' => $this->arabic_name,
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'postal_code' => $this->postal_code,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'description' => $this->description,
                    'imam_name' => $this->imam_name,
                    'logo' => $logoPath ?? $mosque->logo,
                    'is_active' => $this->is_active,
                ]);

                $this->dispatch('swal:success', title: 'Success', text: 'Mosque updated successfully!');
            } else {
                $mosque = Mosque::create([
                    'name' => $this->name,
                    'arabic_name' => $this->arabic_name,
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'postal_code' => $this->postal_code,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'description' => $this->description,
                    'imam_name' => $this->imam_name,
                    'logo' => $logoPath,
                    'is_active' => $this->is_active,
                ]);

                // Create user for mosque
                User::create([
                    'name' => $this->user_name,
                    'email' => $this->user_email,
                    'password' => Hash::make($this->user_password),
                    'role' => 'mosque',
                    'mosque_id' => $mosque->id,
                    'is_active' => true,
                ]);

                $this->dispatch('swal:success', title: 'Success', text: 'Mosque and user created successfully!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteMosque($id)
    {
        try {
            $mosque = Mosque::findOrFail($id);
            $mosque->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Mosque deleted successfully!');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->reset([
            'mosqueId', 'name', 'arabic_name', 'address', 'city', 'state', 
            'postal_code', 'phone', 'email', 'description', 'imam_name', 'logo', 
            'is_active', 'user_name', 'user_email', 'user_password', 'editMode'
        ]);
        $this->is_active = true;
    }

    public function render()
    {
        $mosques = Mosque::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.admin.mosques', [
            'mosques' => $mosques
        ]);
    }
}
