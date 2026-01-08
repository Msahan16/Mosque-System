<?php

namespace App\Livewire\Mosque;

use App\Models\Family;
use App\Models\Donation;
use App\Models\Santha;
use App\Models\BaithulmalTransaction;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $mosqueName;
    public $totalFamilies;
    public $totalMembers;
    public $totalDonations;
    public $todaySanthas;

    public function mount()
    {
        $user = auth()->user();
        $this->mosqueName = $user->mosque->name ?? 'Mosque';
        
        $this->totalFamilies = Family::where('mosque_id', $user->mosque_id)->count();
        $this->totalMembers = Family::where('mosque_id', $user->mosque_id)->sum('total_members');
        $this->totalDonations = Donation::where('mosque_id', $user->mosque_id)->sum('amount');
        $this->todaySanthas = Santha::where('mosque_id', $user->mosque_id)
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->where('is_paid', true)
            ->count();
    }

    public function render()
    {
        $user = auth()->user();
        $recentFamilies = Family::where('mosque_id', $user->mosque_id)
            ->latest()
            ->take(5)
            ->get();
        
        $recentDonations = Donation::where('mosque_id', $user->mosque_id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent Baithulmal transactions
        $recentBaithulmalTransactions = BaithulmalTransaction::where('mosque_id', $user->mosque_id)
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Calculate Baithulmal summary
        $totalIncome = BaithulmalTransaction::where('mosque_id', $user->mosque_id)
            ->where('type', 'income')
            ->sum('amount');
        
        $totalExpense = BaithulmalTransaction::where('mosque_id', $user->mosque_id)
            ->where('type', 'expense')
            ->sum('amount');
        
        $currentBalance = $totalIncome - $totalExpense;
        
        return view('livewire.mosque.dashboard', [
            'recentFamilies' => $recentFamilies,
            'recentDonations' => $recentDonations,
            'recentBaithulmalTransactions' => $recentBaithulmalTransactions,
            'baithulmalSummary' => [
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'currentBalance' => $currentBalance,
            ],
        ]);
    }
}
