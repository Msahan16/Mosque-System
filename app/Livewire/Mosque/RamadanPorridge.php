<?php

namespace App\Livewire\Mosque;

use App\Models\MosqueSetting;
use App\Models\PorridgeSponsor;
use App\Models\BaithulmalTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class RamadanPorridge extends Component
{
    use WithPagination;

    // Event listeners for delete confirmations
    protected $listeners = [
        'deleteSponsor' => 'deleteSponsor'
    ];

    // Properties
    public $activeTab = 'overview';
    public $search = '';
    public $ramadanYear = 2025; // Default to current year
    public $selectedDay = null;
    public $porridgeAmount = 0; // Amount per porridge from settings

    // Modal properties
    public $showModal = false;
    public $editMode = false;
    public $sponsorId;

    // Form properties
    public $day_number;
    public $sponsor_name;
    public $sponsor_phone;
    public $sponsor_type = 'individual';
    public $porridge_count = 1;
    public $custom_amount_per_porridge; // Custom amount per porridge (optional, max = setting amount)
    public $is_anonymous = false; // New property for anonymous sponsors
    public $payment_status = 'pending';
    public $payment_method;
    public $distribution_status = 'pending';
    public $notes;

    protected function rules()
    {
        return [
            'day_number' => 'required|integer|min:1|max:30',
            'sponsor_name' => 'nullable|string|max:255',
            'sponsor_phone' => 'nullable|string|max:20',
            'sponsor_type' => 'required|in:individual,group',
            'porridge_count' => 'required|integer|min:1',
            'custom_amount_per_porridge' => 'nullable|numeric|min:0',
            'is_anonymous' => 'boolean',
            'payment_status' => 'required|in:pending,paid,cancelled',
            'payment_method' => 'nullable|in:cash,online,bank_transfer,other',
            'distribution_status' => 'required|in:pending,distributed,cancelled',
            'notes' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->ramadanYear = date('Y');
        $this->porridgeAmount = MosqueSetting::where('mosque_id', Auth::user()->mosque_id)->value('porridge_amount') ?? 10;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function openModal($day = null)
    {
        $this->resetForm();
        if ($day) {
            $this->day_number = $day;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editSponsor($id)
    {
        $sponsor = PorridgeSponsor::findOrFail($id);
        $this->sponsorId = $sponsor->id;
        $this->day_number = $sponsor->day_number;
        $this->sponsor_name = $sponsor->sponsor_name;
        $this->sponsor_phone = $sponsor->sponsor_phone;
        $this->sponsor_type = $sponsor->sponsor_type;
        $this->porridge_count = $sponsor->porridge_count;
        $this->custom_amount_per_porridge = $sponsor->amount_per_porridge;
        $this->is_anonymous = is_null($sponsor->sponsor_name);
        $this->payment_status = $sponsor->payment_status;
        $this->payment_method = $sponsor->payment_method;
        $this->distribution_status = $sponsor->distribution_status;
        $this->notes = $sponsor->notes;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveSponsor()
    {
        // Force porridge_count to 1 as per new requirement (1 day = 1 portion)
        $this->porridge_count = 1;

        // Convert empty string to null for custom_amount_per_porridge
        if ($this->custom_amount_per_porridge === '' || $this->custom_amount_per_porridge === null) {
            $this->custom_amount_per_porridge = null;
        } else {
            $this->custom_amount_per_porridge = (float) $this->custom_amount_per_porridge;
        }

        // Custom validation for anonymous sponsors
        if (!$this->is_anonymous && empty($this->sponsor_name)) {
            $this->addError('sponsor_name', 'Sponsor name is required unless marked as anonymous.');
            return;
        }

        if ($this->is_anonymous && !empty($this->sponsor_name)) {
            $this->addError('sponsor_name', 'Cannot specify a name for anonymous sponsors.');
            return;
        }

        $this->validate();

        try {
            // Check daily budget limit using porridge_amount as the daily limit
            $dailyBudgetLimit = (float) $this->porridgeAmount; // Use porridge_amount as daily limit
            $currentAmountForDay = PorridgeSponsor::where('mosque_id', Auth::user()->mosque_id)
                ->where('ramadan_year', $this->ramadanYear)
                ->where('day_number', $this->day_number)
                ->when($this->editMode, function ($query) {
                    return $query->where('id', '!=', $this->sponsorId);
                })
                ->sum('total_amount');

            $amountPerPorridge = $this->custom_amount_per_porridge ?? (float) $this->porridgeAmount;
            $newTotalAmount = (int) $this->porridge_count * $amountPerPorridge;

            if (($currentAmountForDay + $newTotalAmount) > $dailyBudgetLimit) {
                $remainingBudget = max(0, $dailyBudgetLimit - $currentAmountForDay);
                $errorMessage = "Cannot add this sponsorship. Daily budget limit for Day " . $this->day_number . " is LKR " . number_format($dailyBudgetLimit, 2) . ". Remaining budget: LKR " . number_format($remainingBudget, 2) . ". This sponsorship would cost: LKR " . number_format($newTotalAmount, 2) . ".";
                $this->dispatch('swal:error', title: 'Budget Limit Exceeded', text: $errorMessage);
                return;
            }
            
            $data = [
                'mosque_id' => Auth::user()->mosque_id,
                'ramadan_year' => $this->ramadanYear,
                'day_number' => $this->day_number,
                'sponsor_name' => $this->is_anonymous ? null : $this->sponsor_name,
                'sponsor_phone' => $this->sponsor_phone,
                'sponsor_type' => $this->sponsor_type,
                'porridge_count' => $this->porridge_count,
                'amount_per_porridge' => $amountPerPorridge,
                'total_amount' => (int) $this->porridge_count * $amountPerPorridge,
                'payment_status' => $this->payment_status,
                'payment_method' => $this->payment_method,
                'distribution_status' => $this->distribution_status,
                'notes' => $this->notes,
                'created_by' => Auth::id(),
            ];

            if ($this->editMode) {
                $sponsor = PorridgeSponsor::findOrFail($this->sponsorId);
                $sponsor->update($data);
                
                // Update associated Baithulmal transaction if exists
                if ($sponsor->baithulmalTransaction) {
                    $sponsor->baithulmalTransaction->update([
                        'amount' => $sponsor->total_amount,
                        'transaction_date' => now()->toDateString(),
                        'payment_method' => $this->payment_method,
                        'description' => 'Ramadan Porridge Sponsorship - Day ' . $this->day_number . ' (' . $this->porridge_count . ' portions)',
                        'received_from' => $this->is_anonymous ? 'Anonymous' : ($this->sponsor_name ?? 'Sponsor'),
                        'notes' => $this->notes,
                        'is_anonymous' => $this->is_anonymous ?? false,
                    ]);
                }
                
                $this->dispatch('swal:success', title: 'Success', text: 'Porridge sponsorship updated successfully');
            } else {
                $sponsor = PorridgeSponsor::create($data);
                
                // Create Baithulmal income transaction if sponsor is created with paid status
                if ($this->payment_status === 'paid') {
                    BaithulmalTransaction::create([
                        'mosque_id' => Auth::user()->mosque_id,
                        'type' => 'income',
                        'category' => 'porridge_sponsorship',
                        'description' => 'Ramadan Porridge Sponsorship - Day ' . $this->day_number . ' (' . $this->porridge_count . ' portions)',
                        'amount' => $sponsor->total_amount,
                        'transaction_date' => now()->toDateString(),
                        'payment_method' => $this->payment_method,
                        'reference_number' => 'PORD-' . now()->format('Ymd') . '-' . $sponsor->id,
                        'reference_porridge_id' => $sponsor->id,
                        'received_from' => $this->is_anonymous ? 'Anonymous' : ($this->sponsor_name ?? 'Sponsor'),
                        'notes' => $this->notes,
                        'is_anonymous' => $this->is_anonymous ?? false,
                        'created_by' => Auth::id(),
                    ]);
                }
                
                $this->dispatch('swal:success', title: 'Success', text: 'Porridge sponsorship added successfully');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteSponsor($id)
    {
        try {
            $sponsor = PorridgeSponsor::findOrFail($id);
            
            // Delete associated Baithulmal transaction if exists
            BaithulmalTransaction::where('reference_porridge_id', $id)->delete();
            
            $sponsor->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Porridge sponsorship deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function markAsDistributed($id)
    {
        try {
            $sponsor = PorridgeSponsor::findOrFail($id);
            $sponsor->update([
                'distribution_status' => 'distributed',
                'distributed_at' => now(),
            ]);
            $this->dispatch('swal:success', title: 'Success', text: 'Porridge marked as distributed');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function markAsPaid($id)
    {
        try {
            $sponsor = PorridgeSponsor::findOrFail($id);
            $sponsor->update(['payment_status' => 'paid']);
            
            // Check if Baithulmal transaction already exists
            $existingTransaction = BaithulmalTransaction::where('reference_porridge_id', $id)->first();
            
            if (!$existingTransaction) {
                // Create Baithulmal income transaction when marking as paid
                BaithulmalTransaction::create([
                    'mosque_id' => Auth::user()->mosque_id,
                    'type' => 'income',
                    'category' => 'porridge_sponsorship',
                    'description' => 'Ramadan Porridge Sponsorship - Day ' . $sponsor->day_number . ' (' . $sponsor->porridge_count . ' portions)',
                    'amount' => $sponsor->total_amount,
                    'transaction_date' => now()->toDateString(),
                    'payment_method' => $sponsor->payment_method,
                    'reference_number' => 'PORD-' . now()->format('Ymd') . '-' . $sponsor->id,
                    'reference_porridge_id' => $sponsor->id,
                    'received_from' => $sponsor->is_anonymous ? 'Anonymous' : ($sponsor->sponsor_name ?? 'Sponsor'),
                    'notes' => $sponsor->notes,
                    'is_anonymous' => $sponsor->is_anonymous ?? false,
                    'created_by' => Auth::id(),
                ]);
            }
            
            $this->dispatch('swal:success', title: 'Success', text: 'Payment marked as paid');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->reset([
            'sponsorId', 'day_number', 'sponsor_name', 'sponsor_phone',
            'sponsor_type', 'porridge_count', 'custom_amount_per_porridge', 'is_anonymous',
            'payment_status', 'payment_method', 'distribution_status', 'notes', 'editMode'
        ]);
        $this->sponsor_type = 'individual';
        $this->porridge_count = 1;
        $this->payment_status = 'pending';
        $this->distribution_status = 'pending';
        $this->is_anonymous = false;
    }

    public function render()
    {
        $mosqueId = Auth::user()->mosque_id;

        // Get sponsors for the current year
        $sponsors = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->where('ramadan_year', $this->ramadanYear)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('sponsor_name', 'like', '%' . $this->search . '%')
                      ->orWhere('sponsor_phone', 'like', '%' . $this->search . '%')
                      ->orWhere(function ($subQ) {
                          // Allow searching for "anonymous" to find null sponsor_name
                          if (strtolower($this->search) === 'anonymous' || str_contains(strtolower($this->search), 'anon')) {
                              $subQ->whereNull('sponsor_name');
                          }
                      });
                });
            })
            ->when($this->selectedDay, function ($query) {
                $query->where('day_number', $this->selectedDay);
            })
            ->latest()
            ->paginate(15);

        // Calculate statistics
        $totalSponsors = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->where('ramadan_year', $this->ramadanYear)
            ->count();

        $totalPorridges = PorridgeSponsor::where('mosque_id', $mosqueId)
        ->where('ramadan_year', $this->ramadanYear)
        ->distinct('day_number')
        ->count('day_number');

        $totalAmount = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->where('ramadan_year', $this->ramadanYear)
            ->sum('total_amount');

        $paidAmount = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->where('ramadan_year', $this->ramadanYear)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $distributedCount = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->where('ramadan_year', $this->ramadanYear)
            ->where('distribution_status', 'distributed')
            ->sum('porridge_count');

        // Get day-wise summary
        $daySummary = [];
        $dailyBudgetLimit = $this->porridgeAmount; // Use porridge_amount as daily budget limit
        
        for ($day = 1; $day <= 30; $day++) {
            $daySponsors = PorridgeSponsor::where('mosque_id', $mosqueId)
                ->where('ramadan_year', $this->ramadanYear)
                ->where('day_number', $day)
                ->get();

            $totalAmountForDay = $daySponsors->sum('total_amount');
            $remainingBudget = max(0, $dailyBudgetLimit - $totalAmountForDay);

            $daySummary[$day] = [
                'total_porridges' => $daySponsors->sum('porridge_count'),
                'sponsors_count' => $daySponsors->count(),
                'total_amount' => $totalAmountForDay,
                'is_distributed' => $daySponsors->where('distribution_status', 'distributed')->isNotEmpty(),
                'sponsors' => $daySponsors,
                'remaining_budget' => $remainingBudget,
                'daily_budget' => $dailyBudgetLimit,
                'is_budget_full' => $totalAmountForDay >= $dailyBudgetLimit,
            ];
        }

        return view('livewire.mosque.ramadan-porridge', [
            'sponsors' => $sponsors,
            'daySummary' => $daySummary,
            'totalSponsors' => $totalSponsors,
            'totalPorridges' => $totalPorridges,
            'totalAmount' => $totalAmount,
            'paidAmount' => $paidAmount,
            'distributedCount' => $distributedCount,
        ]);
    }
}
