<?php

namespace App\Livewire\Mosque;

use App\Models\Santha;
use App\Models\Family;
use App\Models\MosqueSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class Santhas extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteSantha' => 'deleteSantha'];

    // Filters
    public $search = '';
    public $filterMonth = '';
    public $filterYear = '';

    // Modal
    public $showModal = false;
    public $editMode = false;
    public $santhaId;

    // Form fields
    public $family_id;
    public $familySearch = '';
    public $showFamilyDropdown = false;
    public $amount;
    public $payment_date;
    public $payment_method = 'cash';
    public $notes;
    
    // Multi-month payment fields
    public $calculatedMonths = 0;
    public $manualMonthsOverride = false;
    public $monthsToPay = 1;
    public $selectedMonths = [];
    public $balanceDue = 0;

    // Receipt Modal
    public $showReceiptModal = false;
    public $viewingSantha = null;

    // Settings
    public $monthlyAmount = 0;

    protected function rules()
    {
        return [
            'family_id' => 'required|exists:families,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:500',
            'monthsToPay' => 'required|integer|min:1|max:24',
        ];
    }

    public function mount()
    {
        $mosqueId = Auth::user()->mosque_id;
        $settings = MosqueSetting::where('mosque_id', $mosqueId)->first();
        $this->monthlyAmount = $settings->santha_amount ?? 500;
        $this->filterYear = now()->year;
    }

    public function updatedFamilySearch()
    {
        $this->showFamilyDropdown = !empty($this->familySearch);
    }

    public function selectFamily($familyId, $familyName)
    {
        $this->family_id = $familyId;
        $this->familySearch = $familyName;
        $this->showFamilyDropdown = false;
        $this->amount = $this->monthlyAmount;
        $this->calculateMonths();
    }

    public function clearFamily()
    {
        $this->family_id = null;
        $this->familySearch = '';
        $this->showFamilyDropdown = false;
    }

    public function getFilteredFamiliesProperty()
    {
        $mosqueId = Auth::user()->mosque_id;
        
        if (empty($this->familySearch)) {
            return collect();
        }
        
        return Family::where('mosque_id', $mosqueId)
            ->where('is_active', true)
            ->where(function($query) {
                $query->where('family_head_name', 'like', '%' . $this->familySearch . '%')
                      ->orWhere('id', 'like', '%' . $this->familySearch . '%')
                      ->orWhere('phone', 'like', '%' . $this->familySearch . '%');
            })
            ->orderBy('family_head_name')
            ->limit(10)
            ->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->amount = $this->monthlyAmount;
        $this->payment_date = now()->format('Y-m-d');
        $this->payment_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->monthsToPay = 1;
        $this->manualMonthsOverride = false;
        $this->calculateMonths();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function updatedFamilyId($value)
    {
        if ($value) {
            $this->amount = $this->monthlyAmount;
            $this->calculateMonths();
        }
    }

    public function updatedAmount($value)
    {
        $this->calculateMonths();
    }

    public function calculateMonths()
    {
        if (!$this->manualMonthsOverride && $this->amount && $this->monthlyAmount > 0) {
            $fullMonths = floor($this->amount / $this->monthlyAmount);
            $remainder = $this->amount - ($fullMonths * $this->monthlyAmount);
            
            $this->calculatedMonths = $fullMonths;
            $this->balanceDue = $remainder;
            
            if (!$this->manualMonthsOverride) {
                $this->monthsToPay = max(1, $fullMonths);
            }
            
            // If paying less than one full month, show as partial
            if ($fullMonths == 0 && $remainder > 0) {
                $this->monthsToPay = 0;
                $this->balanceDue = $this->monthlyAmount - $remainder;
            }
            
            $this->generateMonthsArray();
        }
    }

    public function toggleManualOverride()
    {
        $this->manualMonthsOverride = !$this->manualMonthsOverride;
        if (!$this->manualMonthsOverride) {
            $this->calculateMonths();
        }
    }

    public function updatedMonthsToPay($value)
    {
        if ($this->manualMonthsOverride) {
            $this->generateMonthsArray();
            // Recalculate balance based on manual months
            $expectedAmount = $value * $this->monthlyAmount;
            $this->balanceDue = max(0, $expectedAmount - $this->amount);
        }
    }

    public function generateMonthsArray()
    {
        $this->selectedMonths = [];
        
        // Start from current month by default
        $startMonth = now()->month;
        $startYear = now()->year;
        
        // Always check and skip already paid months
        if ($this->family_id) {
            $mosqueId = Auth::user()->mosque_id;
            $tempMonth = $startMonth;
            $tempYear = $startYear;
            
            // Find the first unpaid month starting from selected month
            $maxChecks = 24; // Check up to 24 months ahead
            $checksCount = 0;
            
            while ($checksCount < $maxChecks) {
                $monthName = Carbon::create()->month($tempMonth)->format('F');
                
                $isPaid = Santha::where('mosque_id', $mosqueId)
                    ->where('family_id', $this->family_id)
                    ->where('year', $tempYear)
                    ->where(function($q) use ($tempMonth, $monthName) {
                        $q->where('month', $tempMonth)
                          ->orWhere('month', $monthName);
                    })
                    ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                    ->exists();
                
                if (!$isPaid) {
                    // Found first unpaid month
                    $startMonth = $tempMonth;
                    $startYear = $tempYear;
                    break;
                }
                
                // Move to next month
                $tempMonth++;
                if ($tempMonth > 12) {
                    $tempMonth = 1;
                    $tempYear++;
                }
                $checksCount++;
            }
        }
        
        $monthsToGenerate = $this->monthsToPay > 0 ? $this->monthsToPay : 1;
        $generatedCount = 0;
        $currentMonth = $startMonth;
        $currentYear = $startYear;
        
        // Generate months, skipping any that are already paid
        while ($generatedCount < $monthsToGenerate) {
            if ($this->family_id) {
                $mosqueId = Auth::user()->mosque_id;
                $monthName = Carbon::create()->month($currentMonth)->format('F');
                
                $isPaid = Santha::where('mosque_id', $mosqueId)
                    ->where('family_id', $this->family_id)
                    ->where('year', $currentYear)
                    ->where(function($q) use ($currentMonth, $monthName) {
                        $q->where('month', $currentMonth)
                          ->orWhere('month', $monthName);
                    })
                    ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                    ->exists();
                
                if (!$isPaid) {
                    // Add this unpaid month
                    $this->selectedMonths[] = [
                        'month' => $currentMonth,
                        'year' => $currentYear,
                        'monthName' => Carbon::create()->month($currentMonth)->format('F')
                    ];
                    $generatedCount++;
                }
            } else {
                // No family selected yet, just generate sequentially
                $this->selectedMonths[] = [
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'monthName' => Carbon::create()->month($currentMonth)->format('F')
                ];
                $generatedCount++;
            }
            
            // Move to next month
            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                $currentYear++;
            }
        }
    }

    public function editSantha($id)
    {
        $santha = Santha::findOrFail($id);
        $this->santhaId = $santha->id;
        $this->family_id = $santha->family_id;
        $this->familySearch = $santha->family?->family_head_name ?? '';
        $this->amount = $santha->amount;
        $this->payment_date = $santha->payment_date->format('Y-m-d');
        $this->payment_method = $santha->payment_method;
        $this->notes = $santha->notes;
        $this->monthsToPay = $santha->months_covered ?? 1;
        $this->balanceDue = $santha->balance_due ?? 0;
        $this->selectedMonths = $santha->months_data ?? [];
        $this->manualMonthsOverride = $santha->months_covered != floor($santha->amount / $this->monthlyAmount);
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveSantha()
    {
        $this->validate();

        try {
            $mosqueId = Auth::user()->mosque_id;
            
            // Regenerate months array to ensure it's up to date
            $this->generateMonthsArray();
            
            if (empty($this->selectedMonths)) {
                throw new \Exception("No unpaid months available for this family.");
            }
            
            // For multi-month payments, create separate records or update primary with months_data
            if ($this->monthsToPay > 1 && !empty($this->selectedMonths)) {
                // Save as single record with months_data
                $firstMonth = $this->selectedMonths[0];
                $monthName = $firstMonth['monthName'];
                
                // Check if payment already exists for first month
                $existing = Santha::where('mosque_id', $mosqueId)
                    ->where('family_id', $this->family_id)
                    ->where('year', $firstMonth['year'])
                    ->where(function($q) use ($monthName, $firstMonth) {
                        $q->where('month', $firstMonth['month'])
                          ->orWhere('month', $monthName);
                    })
                    ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                    ->first();

                if ($existing && !$this->editMode) {
                    throw new \Exception("Payment already exists for {$monthName} {$firstMonth['year']}");
                }

                $receiptNumber = $this->editMode 
                    ? Santha::find($this->santhaId)->receipt_number 
                    : $this->generateReceiptNumber($mosqueId);

                $data = [
                    'mosque_id' => $mosqueId,
                    'family_id' => $this->family_id,
                    'month' => $monthName,
                    'year' => $firstMonth['year'],
                    'amount' => $this->amount,
                    'months_covered' => $this->monthsToPay,
                    'months_data' => $this->selectedMonths,
                    'balance_due' => $this->balanceDue,
                    'payment_applies_to' => 'auto_skip_paid',
                    'payment_date' => $this->payment_date,
                    'payment_method' => $this->payment_method,
                    'receipt_number' => $receiptNumber,
                    'is_paid' => true,
                    'status' => $this->balanceDue > 0 ? 'partial' : 'paid',
                    'notes' => $this->notes,
                ];

                if ($this->editMode) {
                    Santha::findOrFail($this->santhaId)->update($data);
                    $message = 'Payment updated successfully';
                } else {
                    Santha::create($data);
                    $message = 'Payment recorded successfully';
                }
            } else {
                // Single month or partial payment
                $monthName = Carbon::create()->month($this->month)->format('F');

                // Check if payment already exists
                $existing = Santha::where('mosque_id', $mosqueId)
                    ->where('family_id', $this->family_id)
                    ->where('year', $this->year)
                    ->where(function($q) use ($monthName) {
                        $q->where('month', $this->month)
                          ->orWhere('month', $monthName);
                    })
                    ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                    ->first();

                if ($existing && !$this->editMode) {
                    throw new \Exception("Payment already exists for {$monthName} {$this->year}");
                }

                $receiptNumber = $this->editMode 
                    ? Santha::find($this->santhaId)->receipt_number 
                    : $this->generateReceiptNumber($mosqueId);

                $data = [
                    'mosque_id' => $mosqueId,
                    'family_id' => $this->family_id,
                    'month' => $monthName,
                    'year' => $this->year,
                    'amount' => $this->amount,
                    'months_covered' => $this->monthsToPay > 0 ? $this->monthsToPay : 0,
                    'months_data' => !empty($this->selectedMonths) ? $this->selectedMonths : null,
                    'balance_due' => $this->balanceDue,
                    'payment_applies_to' => 'auto_skip_paid',
                    'payment_date' => $this->payment_date,
                    'payment_method' => $this->payment_method,
                    'receipt_number' => $receiptNumber,
                    'is_paid' => $this->balanceDue <= 0,
                    'status' => $this->balanceDue > 0 ? 'partial' : 'paid',
                    'notes' => $this->notes,
                ];

                if ($this->editMode) {
                    Santha::findOrFail($this->santhaId)->update($data);
                    $message = 'Payment updated successfully';
                } else {
                    Santha::create($data);
                    $message = 'Payment recorded successfully';
                }
            }

            $this->dispatch('swal:success', title: 'Success', text: $message);
            $this->closeModal();

        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    private function generateReceiptNumber($mosqueId)
    {
        $count = Santha::where('mosque_id', $mosqueId)->count() + 1;
        return 'SAN-' . now()->format('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function deleteSantha($id)
    {
        try {
            Santha::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Payment deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewReceipt($id)
    {
        $santha = Santha::with(['family', 'mosque'])->findOrFail($id);

        $this->viewingSantha = [
            'id' => $santha->id,
            'receipt_number' => $santha->receipt_number,
            'family_name' => $santha->family?->family_head_name ?? 'N/A',
            'family_phone' => $santha->family?->phone ?? 'N/A',
            'amount' => $santha->amount,
            'month' => $santha->month,
            'year' => $santha->year,
            'months_covered' => $santha->months_covered ?? 1,
            'months_display' => $santha->getMonthsCoveredDisplay(),
            'balance_due' => $santha->balance_due ?? 0,
            'payment_date' => $santha->payment_date->format('d M, Y'),
            'payment_method' => $santha->payment_method,
            'notes' => $santha->notes,
            'mosque_name' => $santha->mosque?->name ?? config('app.name'),
        ];

        $this->showReceiptModal = true;
    }

    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->viewingSantha = null;
    }

    private function resetForm()
    {
        $this->reset([
            'santhaId', 'family_id', 'familySearch', 'showFamilyDropdown', 'amount', 'payment_date', 
            'payment_method', 'notes', 'editMode', 'monthsToPay', 'selectedMonths',
            'balanceDue', 'manualMonthsOverride', 'calculatedMonths'
        ]);
    }

    public function render()
    {
        $mosqueId = Auth::user()->mosque_id;
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $currentMonthName = now()->format('F');

        // Get all payments
        $santhas = Santha::where('mosque_id', $mosqueId)
            ->when($this->search, function ($query) {
                $query->whereHas('family', function ($q) {
                    $q->where('family_head_name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('receipt_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterMonth, function ($query) {
                $monthName = Carbon::create()->month($this->filterMonth)->format('F');
                $query->where(function($q) use ($monthName) {
                    $q->where('month', $this->filterMonth)
                      ->orWhere('month', $monthName);
                });
            })
            ->when($this->filterYear, fn($q) => $q->where('year', $this->filterYear))
            ->with('family')
            ->orderBy('payment_date', 'desc')
            ->paginate(15);

        // Get families
        $families = Family::where('mosque_id', $mosqueId)
            ->where('is_active', true)
            ->orderBy('family_head_name')
            ->get();

        // Statistics for current month
        $totalFamilies = Family::where('mosque_id', $mosqueId)->where('is_active', true)->count();
        
        $paidThisMonth = Santha::where('mosque_id', $mosqueId)
            ->where('year', $currentYear)
            ->where(function($q) use ($currentMonth, $currentMonthName) {
                $q->where('month', $currentMonth)
                  ->orWhere('month', $currentMonthName);
            })
            ->count();

        $totalCollectedThisMonth = Santha::where('mosque_id', $mosqueId)
            ->where('year', $currentYear)
            ->where(function($q) use ($currentMonth, $currentMonthName) {
                $q->where('month', $currentMonth)
                  ->orWhere('month', $currentMonthName);
            })
            ->sum('amount');

        $pendingThisMonth = max(0, $totalFamilies - $paidThisMonth);
        $collectionRate = $totalFamilies > 0 ? round(($paidThisMonth / $totalFamilies) * 100) : 0;

        return view('livewire.mosque.santhas', [
            'santhas' => $santhas,
            'families' => $families,
            'totalFamilies' => $totalFamilies,
            'paidThisMonth' => $paidThisMonth,
            'pendingThisMonth' => $pendingThisMonth,
            'totalCollectedThisMonth' => $totalCollectedThisMonth,
            'collectionRate' => $collectionRate,
            'currentMonthName' => now()->format('F Y'),
        ]);
    }
}
