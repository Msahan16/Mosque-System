<?php

namespace App\Livewire\Mosque;

use App\Models\MosqueSetting;
use App\Models\PorridgeSponsor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class RamadanPorridge extends Component
{
    use WithPagination;

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
            'custom_amount_per_porridge' => 'nullable|numeric|min:0|max:' . $this->porridgeAmount,
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
        $this->porridgeAmount = MosqueSetting::where('mosque_id', auth()->user()->mosque_id)->value('porridge_amount') ?? 0;
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
            $dailyBudgetLimit = $this->porridgeAmount; // Use porridge_amount as daily limit
            $currentAmountForDay = PorridgeSponsor::where('mosque_id', auth()->user()->mosque_id)
                ->where('ramadan_year', $this->ramadanYear)
                ->where('day_number', $this->day_number)
                ->when($this->editMode, function ($query) {
                    return $query->where('id', '!=', $this->sponsorId);
                })
                ->sum('total_amount');

            $newTotalAmount = $this->porridge_count * ($this->custom_amount_per_porridge ?? $this->porridgeAmount);

            if (($currentAmountForDay + $newTotalAmount) > $dailyBudgetLimit) {
                $remainingBudget = $dailyBudgetLimit - $currentAmountForDay;
                $this->addError('porridge_count', "Cannot add this sponsorship. Daily budget limit: LKR " . number_format($dailyBudgetLimit, 2) . ". Remaining budget: LKR " . number_format($remainingBudget, 2) . ". This sponsorship would cost: LKR " . number_format($newTotalAmount, 2) . ".");
                return;
            }

            $amountPerPorridge = $this->custom_amount_per_porridge ?? $this->porridgeAmount;
            
            $data = [
                'mosque_id' => auth()->user()->mosque_id,
                'ramadan_year' => $this->ramadanYear,
                'day_number' => $this->day_number,
                'sponsor_name' => $this->is_anonymous ? null : $this->sponsor_name,
                'sponsor_phone' => $this->sponsor_phone,
                'sponsor_type' => $this->sponsor_type,
                'porridge_count' => $this->porridge_count,
                'amount_per_porridge' => $amountPerPorridge,
                'total_amount' => $this->porridge_count * $amountPerPorridge,
                'payment_status' => $this->payment_status,
                'payment_method' => $this->payment_method,
                'distribution_status' => $this->distribution_status,
                'notes' => $this->notes,
                'created_by' => auth()->id(),
            ];

            if ($this->editMode) {
                PorridgeSponsor::findOrFail($this->sponsorId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Porridge sponsorship updated successfully');
            } else {
                PorridgeSponsor::create($data);
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
            PorridgeSponsor::findOrFail($id)->delete();
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
            PorridgeSponsor::findOrFail($id)->update(['payment_status' => 'paid']);
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
        $mosqueId = auth()->user()->mosque_id;

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
            ->sum('porridge_count');

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
