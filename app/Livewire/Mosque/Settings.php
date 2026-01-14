<?php

namespace App\Livewire\Mosque;

use App\Models\Mosque;
use App\Models\MosqueSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Settings extends Component
{
    use WithFileUploads;

    public $mosque;
    public $setting;
    
    // Mosque Profile
    public $masjid_name;
    public $masjid_arabic_name;
    public $masjid_address;
    public $masjid_phone;
    public $masjid_email;
    public $masjid_logo;
    public $current_logo;

    // Settings
    public $santha_amount;
    public $santha_collection_date;
    public $porridge_amount;
    public $notes;
    public $fajr_iqamah_offset;
    public $dhuhr_iqamah_offset;
    public $asr_iqamah_offset;
    public $maghrib_iqamah_offset;
    public $isha_iqamah_offset;
    public $editMode = false;
    public $activeTab = 'profile';

    public function mount()
    {
        $this->mosque = Auth::user()->mosque;
        
        // Initialize Mosque Profile
        $this->masjid_name = $this->mosque->name;
        $this->masjid_arabic_name = $this->mosque->arabic_name;
        $this->masjid_address = $this->mosque->address;
        $this->masjid_phone = $this->mosque->phone;
        $this->masjid_email = $this->mosque->email;
        $this->current_logo = $this->mosque->logo;

        $this->setting = MosqueSetting::where('mosque_id', $this->mosque->id)->first();
        
        if ($this->setting) {
            $this->santha_amount = $this->setting->santha_amount;
            $this->santha_collection_date = $this->setting->santha_collection_date;
            $this->porridge_amount = $this->setting->porridge_amount;
            $this->notes = $this->setting->notes;
            $this->fajr_iqamah_offset = $this->setting->fajr_iqamah_offset;
            $this->dhuhr_iqamah_offset = $this->setting->dhuhr_iqamah_offset;
            $this->asr_iqamah_offset = $this->setting->asr_iqamah_offset;
            $this->maghrib_iqamah_offset = $this->setting->maghrib_iqamah_offset;
            $this->isha_iqamah_offset = $this->setting->isha_iqamah_offset;
            $this->editMode = true;
        } else {
            $this->santha_amount = 500;
            $this->santha_collection_date = 25;
            $this->porridge_amount = 10;
            $this->fajr_iqamah_offset = 20;
            $this->dhuhr_iqamah_offset = 10;
            $this->asr_iqamah_offset = 10;
            $this->maghrib_iqamah_offset = 5;
            $this->isha_iqamah_offset = 10;
        }
    }

    protected function rules()
    {
        return [
            'santha_amount' => 'required|numeric|min:0',
            'santha_collection_date' => 'required|integer|min:1|max:31',
            'porridge_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'fajr_iqamah_offset' => 'required|integer|min:0|max:60',
            'dhuhr_iqamah_offset' => 'required|integer|min:0|max:60',
            'asr_iqamah_offset' => 'required|integer|min:0|max:60',
            'maghrib_iqamah_offset' => 'required|integer|min:0|max:60',
            'isha_iqamah_offset' => 'required|integer|min:0|max:60',
        ];
    }

    public function updateProfile()
    {
        $this->validate([
            'masjid_name' => 'required|string|max:255',
            'masjid_arabic_name' => 'nullable|string|max:255',
            'masjid_address' => 'required|string',
            'masjid_phone' => 'nullable|string|max:20',
            'masjid_email' => 'nullable|email|max:255',
            'masjid_logo' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $data = [
            'name' => $this->masjid_name,
            'arabic_name' => $this->masjid_arabic_name,
            'address' => $this->masjid_address,
            'phone' => $this->masjid_phone,
            'email' => $this->masjid_email,
        ];

        if ($this->masjid_logo) {
            // Delete old logo if exists
            if ($this->mosque->logo) {
                Storage::delete('public/' . $this->mosque->logo);
            }
            $data['logo'] = $this->masjid_logo->store('logos', 'public');
            $this->current_logo = $data['logo'];
        }

        $this->mosque->update($data);
        $this->dispatch('swal:success', title: 'Success', text: 'Mosque profile updated successfully');
    }

    public function saveSetting()
    {
        $this->validate($this->rules());

        try {
            // Reload setting in case it was created elsewhere
            $this->setting = MosqueSetting::where('mosque_id', $this->mosque->id)->first();
            
            if ($this->setting) {
                // Update existing setting
                $this->setting->update([
                    'santha_amount' => $this->santha_amount,
                    'santha_collection_date' => $this->santha_collection_date,
                    'porridge_amount' => $this->porridge_amount,
                    'notes' => $this->notes,
                    'fajr_iqamah_offset' => $this->fajr_iqamah_offset,
                    'dhuhr_iqamah_offset' => $this->dhuhr_iqamah_offset,
                    'asr_iqamah_offset' => $this->asr_iqamah_offset,
                    'maghrib_iqamah_offset' => $this->maghrib_iqamah_offset,
                    'isha_iqamah_offset' => $this->isha_iqamah_offset,
                ]);
                $this->dispatch('swal:success', title: 'Success', text: 'Settings updated successfully');
            } else {
                // Create new setting
                $this->setting = MosqueSetting::create([
                    'mosque_id' => $this->mosque->id,
                    'santha_amount' => $this->santha_amount,
                    'santha_collection_date' => $this->santha_collection_date,
                    'porridge_amount' => $this->porridge_amount,
                    'notes' => $this->notes,
                    'fajr_iqamah_offset' => $this->fajr_iqamah_offset,
                    'dhuhr_iqamah_offset' => $this->dhuhr_iqamah_offset,
                    'asr_iqamah_offset' => $this->asr_iqamah_offset,
                    'maghrib_iqamah_offset' => $this->maghrib_iqamah_offset,
                    'isha_iqamah_offset' => $this->isha_iqamah_offset,
                ]);
                $this->dispatch('swal:success', title: 'Success', text: 'Settings saved successfully');
                $this->editMode = true;
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function getSuffix($day)
    {
        if ($day >= 11 && $day <= 13) return 'th';
        return match ($day % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th'
        };
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.mosque.settings');
    }
}
