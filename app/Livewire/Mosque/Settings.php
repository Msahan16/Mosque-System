<?php

namespace App\Livewire\Mosque;

use App\Models\Mosque;
use App\Models\MosqueSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Settings extends Component
{
    public $mosque;
    public $setting;
    public $santha_amount;
    public $santha_collection_date;
    public $notes;
    public $editMode = false;

    public function mount()
    {
        $this->mosque = auth()->user()->mosque;
        $this->setting = MosqueSetting::where('mosque_id', $this->mosque->id)->first();
        
        if ($this->setting) {
            $this->santha_amount = $this->setting->santha_amount;
            $this->santha_collection_date = $this->setting->santha_collection_date;
            $this->notes = $this->setting->notes;
            $this->editMode = true;
        } else {
            $this->santha_amount = 500;
            $this->santha_collection_date = 25;
        }
    }

    protected function rules()
    {
        return [
            'santha_amount' => 'required|numeric|min:0',
            'santha_collection_date' => 'required|integer|min:1|max:31',
            'notes' => 'nullable|string',
        ];
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
                    'notes' => $this->notes,
                ]);
                $this->dispatch('swal:success', title: 'Success', text: 'Settings updated successfully');
            } else {
                // Create new setting
                $this->setting = MosqueSetting::create([
                    'mosque_id' => $this->mosque->id,
                    'santha_amount' => $this->santha_amount,
                    'santha_collection_date' => $this->santha_collection_date,
                    'notes' => $this->notes,
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

    public function render()
    {
        return view('livewire.mosque.settings');
    }
}
