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
    public $name, $arabic_name, $address, $state;
    public $phone, $email, $description, $logo, $is_active = true;
    public $country = 'Sri Lanka', $timezone = 'Asia/Colombo', $latitude = 6.9271, $longitude = 80.7744;
    public $selectedProvince = 'Colombo';

    // User credentials
    public $user_name, $user_email, $user_password;

    // Sri Lanka provinces with coordinates and timezone
    public $sriLankaProvinces = [
        'Colombo' => ['lat' => 6.9271, 'lng' => 80.7744, 'name' => 'Colombo (Western)', 'timezone' => 'Asia/Colombo'],
        'Kandy' => ['lat' => 6.9271, 'lng' => 80.6386, 'name' => 'Kandy (Central)', 'timezone' => 'Asia/Colombo'],
        'Galle' => ['lat' => 6.0535, 'lng' => 80.2170, 'name' => 'Galle (Southern)', 'timezone' => 'Asia/Colombo'],
        'Jaffna' => ['lat' => 9.6615, 'lng' => 80.7855, 'name' => 'Jaffna (Northern)', 'timezone' => 'Asia/Colombo'],
        'Trincomalee' => ['lat' => 8.5874, 'lng' => 81.2346, 'name' => 'Trincomalee (Eastern)', 'timezone' => 'Asia/Colombo'],
        'Matara' => ['lat' => 5.7489, 'lng' => 80.5375, 'name' => 'Matara (Southern)', 'timezone' => 'Asia/Colombo'],
        'Badulla' => ['lat' => 6.9906, 'lng' => 81.2680, 'name' => 'Badulla (Uva)', 'timezone' => 'Asia/Colombo'],
        'Kurunegala' => ['lat' => 7.4818, 'lng' => 80.6337, 'name' => 'Kurunegala (North Western)', 'timezone' => 'Asia/Colombo'],
        'Anuradhapura' => ['lat' => 8.3154, 'lng' => 80.7691, 'name' => 'Anuradhapura (North Central)', 'timezone' => 'Asia/Colombo'],
        'Ratnapura' => ['lat' => 6.6828, 'lng' => 80.7992, 'name' => 'Ratnapura (Sabaragamuwa)', 'timezone' => 'Asia/Colombo'],
    ];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'arabic_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'state' => 'required|string|max:255',
            'phone' => 'required|regex:/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/',
            'email' => $this->editMode ? 'required|email|unique:mosques,email,'.$this->mosqueId : 'required|email|unique:mosques,email',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'country' => 'required|string|max:255',
            'selectedProvince' => 'required|string|in:' . implode(',', array_keys($this->sriLankaProvinces)),
        ];

        if (!$this->editMode) {
            $rules['user_name'] = 'required|email|unique:users,email';
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

    public function updateProvinceLocation()
    {
        if (isset($this->sriLankaProvinces[$this->selectedProvince])) {
            $province = $this->sriLankaProvinces[$this->selectedProvince];
            $this->timezone = $province['timezone'];
            $this->latitude = $province['lat'];
            $this->longitude = $province['lng'];
            $this->state = $province['name']; // Auto-fill state with province name
        }
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
        $this->is_active = $mosque->is_active;
        $this->country = $mosque->country;
        $this->timezone = $mosque->timezone;
        $this->latitude = $mosque->latitude;
        $this->longitude = $mosque->longitude;
        
        // Find matching province based on coordinates
        foreach ($this->sriLankaProvinces as $key => $province) {
            if ($province['lat'] == $mosque->latitude && $province['lng'] == $mosque->longitude) {
                $this->selectedProvince = $key;
                break;
            }
        }
        
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
                    'state' => $this->state,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'description' => $this->description,
                    'logo' => $logoPath ?? $mosque->logo,
                    'is_active' => $this->is_active,
                    'country' => $this->country,
                    'timezone' => $this->timezone,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]);

                $this->dispatch('swal:success', title: 'Success', text: 'Mosque updated successfully!');
            } else {
                $mosque = Mosque::create([
                    'name' => $this->name,
                    'arabic_name' => $this->arabic_name,
                    'address' => $this->address,
                    'state' => $this->state,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'description' => $this->description,
                    'logo' => $logoPath,
                    'is_active' => $this->is_active,
                    'country' => $this->country,
                    'timezone' => $this->timezone,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]);

                // Create user for mosque
                User::create([
                    'name' => $this->user_name,
                    'email' => $this->user_name,
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
            'mosqueId', 'name', 'arabic_name', 'address', 'state', 
            'phone', 'email', 'description', 'logo', 
            'is_active', 'user_name', 'user_password', 'editMode',
            'country', 'timezone', 'latitude', 'longitude', 'selectedProvince'
        ]);
        $this->selectedProvince = 'Colombo';
        $this->timezone = 'Asia/Colombo';
        $this->country = 'Sri Lanka';
        $this->latitude = 6.9271;
        $this->longitude = 80.7744;
        $this->is_active = true;
        $this->state = 'Colombo (Western)';
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
            'mosques' => $mosques,
            'sriLankaProvinces' => $this->sriLankaProvinces
        ]);
    }
}
