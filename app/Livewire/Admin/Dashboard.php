<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Mosque;
use App\Models\Family;
use App\Models\Donation;
use App\Models\Santha;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $mosqueCount = 0;
    public $familyCount = 0;
    public $donationTotal = 0;
    public $santhaCount = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->mosqueCount = Mosque::count();
        $this->familyCount = Family::count();
        $this->donationTotal = Donation::sum('amount');
        $this->santhaCount = Santha::count();
    }

    public function render()
    {
        $recentMosques = Mosque::latest()->take(5)->get();
        
        return view('livewire.admin.dashboard', [
            'recentMosques' => $recentMosques
        ]);
    }
}
