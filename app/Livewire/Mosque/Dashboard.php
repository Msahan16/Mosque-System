<?php

namespace App\Livewire\Mosque;

use App\Models\Family;
use App\Models\Donation;
use App\Models\Santha;
use App\Models\BaithulmalTransaction;
use App\Models\DashboardPreference;
use App\Models\Student;
use App\Models\PorridgeSponsor;
use App\Models\Imam;
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
    
    // Customization properties
    public $showCustomizeModal = false;
    public $availableCards = [];
    public $visibleCards = [];
    public $cardPositions = [];

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
        
        // Define all available dashboard cards
        $this->availableCards = $this->getAvailableCards();
        
        // Load user preferences
        $this->loadPreferences();
    }

    public function getAvailableCards()
    {
        return [
            'families' => ['name' => 'Total Families', 'icon' => 'users', 'color' => 'blue'],
            'members' => ['name' => 'Total Members', 'icon' => 'user-group', 'color' => 'emerald'],
            'donations' => ['name' => 'Total Donations', 'icon' => 'currency', 'color' => 'cyan'],
            'santhas_paid' => ['name' => 'This Month Paid', 'icon' => 'check', 'color' => 'purple'],
            'recent_families' => ['name' => 'Recent Families', 'icon' => 'list', 'color' => 'blue', 'type' => 'list'],
            'recent_donations' => ['name' => 'Recent Donations', 'icon' => 'list', 'color' => 'cyan', 'type' => 'list'],
            'recent_santhas' => ['name' => 'Recent Santha Collections', 'icon' => 'list', 'color' => 'purple', 'type' => 'list'],
            'baithulmal_summary' => ['name' => 'Baithulmal Summary', 'icon' => 'wallet', 'color' => 'emerald', 'type' => 'list'],
            'students_count' => ['name' => 'Madrasa Students', 'icon' => 'academic-cap', 'color' => 'indigo'],
            'porridge_sponsors' => ['name' => 'Porridge Sponsors', 'icon' => 'gift', 'color' => 'orange'],
            'active_imams' => ['name' => 'Active Imams', 'icon' => 'user', 'color' => 'teal'],
        ];
    }

    public function loadPreferences()
    {
        $user = auth()->user();
        $preference = DashboardPreference::where('user_id', $user->id)->first();
        
        if ($preference) {
            $this->visibleCards = $preference->visible_cards ?? $this->getDefaultVisibleCards();
            $savedPositions = $preference->card_positions ?? [];
            
            // Ensure any new available cards are added to the end of positions if not already there
            $allAvailableKeys = array_keys($this->availableCards);
            $newCards = array_diff($allAvailableKeys, $savedPositions);
            
            if (!empty($newCards)) {
                $this->cardPositions = array_merge($savedPositions, array_values($newCards));
            } else {
                $this->cardPositions = $savedPositions;
            }
        } else {
            // Default: show first 7 cards
            $this->visibleCards = $this->getDefaultVisibleCards();
            $this->cardPositions = array_keys($this->availableCards);
        }
    }

    public function getDefaultVisibleCards()
    {
        // Return first 7 cards by default
        return array_slice(array_keys($this->availableCards), 0, 7);
    }

    public function openCustomizeModal()
    {
        $this->showCustomizeModal = true;
    }

    public function closeCustomizeModal()
    {
        $this->showCustomizeModal = false;
    }

    public function toggleCard($cardId)
    {
        if (in_array($cardId, $this->visibleCards)) {
            // Remove card
            $this->visibleCards = array_values(array_diff($this->visibleCards, [$cardId]));
        } else {
            // Check if already at maximum (7 cards) - prevent action
            if (count($this->visibleCards) >= 7) {
                return; // Silently prevent - UI already shows disabled state
            }
            $this->visibleCards[] = $cardId;
        }
    }

    public function moveCardUp($cardId)
    {
        $index = array_search($cardId, $this->cardPositions);
        if ($index > 0) {
            $temp = $this->cardPositions[$index - 1];
            $this->cardPositions[$index - 1] = $this->cardPositions[$index];
            $this->cardPositions[$index] = $temp;
        }
    }

    public function moveCardDown($cardId)
    {
        $index = array_search($cardId, $this->cardPositions);
        if ($index < count($this->cardPositions) - 1) {
            $temp = $this->cardPositions[$index + 1];
            $this->cardPositions[$index + 1] = $this->cardPositions[$index];
            $this->cardPositions[$index] = $temp;
        }
    }

    public function savePreferences()
    {
        $user = auth()->user();
        
        DashboardPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'visible_cards' => $this->visibleCards,
                'card_positions' => $this->cardPositions,
            ]
        );
        
        $this->dispatch('swal:success', [
            'title' => 'Saved!',
            'text' => 'Dashboard preferences saved successfully.',
        ]);
        
        $this->closeCustomizeModal();
    }

    public function resetToDefault()
    {
        $this->visibleCards = $this->getDefaultVisibleCards(); // First 7 cards
        $this->cardPositions = array_keys($this->availableCards);
        $this->savePreferences();
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
        
        // Additional stats for new cards
        $studentsCount = Student::where('mosque_id', $user->mosque_id)->count();
        $porridgeSponsorsCount = PorridgeSponsor::where('mosque_id', $user->mosque_id)->count();
        $activeImamsCount = Imam::where('mosque_id', $user->mosque_id)->where('status', 'active')->count();

        $recentSanthas = Santha::with('family')
            ->where('mosque_id', $user->mosque_id)
            ->latest('payment_date')
            ->take(5)
            ->get();
        
        return view('livewire.mosque.dashboard', [
            'recentFamilies' => $recentFamilies,
            'recentDonations' => $recentDonations,
            'recentSanthas' => $recentSanthas,
            'recentBaithulmalTransactions' => $recentBaithulmalTransactions,
            'baithulmalSummary' => [
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'currentBalance' => $currentBalance,
            ],
            'studentsCount' => $studentsCount,
            'porridgeSponsorsCount' => $porridgeSponsorsCount,
            'activeImamsCount' => $activeImamsCount,
        ]);
    }
}
