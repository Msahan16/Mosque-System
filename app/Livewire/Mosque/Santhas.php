<?php

namespace App\Livewire\Mosque;

use App\Models\Santha;
use App\Models\Family;
use App\Models\MosqueSetting;
use App\Models\BaithulmalTransaction;
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
    public $monthsToPay = 1;
    public $selectedMonths = [];
    public $familyCredit = 0;      // Existing credit from overpayments
    public $newCredit = 0;         // Credit generated from this payment
    public $amountNeeded = 0;      // Amount needed for next month after credit
    public $overpaymentMode = 'credit'; // 'credit' = carry forward, 'single_month' = donation mode
    public $completingPartialId = null; // ID of partial payment being completed
    public $familyPartialPayments = []; // Store partial payments for selected family

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
        $this->showFamilyDropdown = strlen($this->familySearch) >= 1;
    }

    public function selectFamily($familyId, $familyName)
    {
        $this->family_id = $familyId;
        $this->familySearch = $familyName;
        $this->showFamilyDropdown = false;
        
        // Check if family has partial payments
        $mosqueId = Auth::user()->mosque_id;
        $this->familyPartialPayments = Santha::where('mosque_id', $mosqueId)
            ->where('family_id', $familyId)
            ->where('status', 'partial')
            ->where('balance_due', '>', 0)
            ->orderBy('payment_date', 'desc')
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'months' => $this->getPartialMonthsDisplay($s),
                'balance' => $s->balance_due,
                'amount_paid' => $s->amount
            ])
            ->toArray();
        
        // Set default amount and recalculate
        $this->calculateFamilyCredit();
        $this->calculatePayment();
    }

    public function clearFamily()
    {
        $this->family_id = null;
        $this->familySearch = '';
        $this->showFamilyDropdown = false;
        $this->familyCredit = 0;
        $this->newCredit = 0;
        $this->amountNeeded = $this->monthlyAmount;
        $this->selectedMonths = [];
        $this->monthsToPay = 1;
        $this->familyPartialPayments = [];
    }

    public function calculateFamilyCredit()
    {
        if (!$this->family_id) {
            $this->familyCredit = 0;
            $this->amountNeeded = $this->monthlyAmount;
            return;
        }

        $mosqueId = Auth::user()->mosque_id;
        
        // Get latest payment with credit (balance_due stores the credit)
        $lastPaymentWithCredit = Santha::where('mosque_id', $mosqueId)
            ->where('family_id', $this->family_id)
            ->where('payment_applies_to', 'credit')
            ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
            ->orderBy('payment_date', 'desc')
            ->first();
        
        // Credit is stored in balance_due field of the last credit-mode payment
        $this->familyCredit = $lastPaymentWithCredit ? ($lastPaymentWithCredit->balance_due ?? 0) : 0;
        
        // How much needed for next month (considering credit)
        $this->amountNeeded = max(0, $this->monthlyAmount - $this->familyCredit);
    }

    public function getFilteredFamiliesProperty()
    {
        if (empty($this->familySearch)) {
            return collect();
        }
        
        $mosqueId = Auth::user()->mosque_id;
        
        return Family::where('mosque_id', $mosqueId)
            ->where('is_active', true)
            ->where(function($query) {
                $query->where('family_head_name', 'like', '%' . $this->familySearch . '%')
                      ->orWhere('family_id', 'like', '%' . $this->familySearch . '%')
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
        $this->payment_method = 'cash';
        $this->overpaymentMode = 'credit';
        $this->monthsToPay = 1;
        $this->newCredit = 0;
        $this->generateMonthsArray();
        $this->showModal = true;
    }

    /**
     * Get only the partial/balance months from a payment
     */
    private function getPartialMonthsDisplay($santha)
    {
        $fullyPaidMonths = floor($santha->amount / $this->monthlyAmount);
        $allMonths = $santha->months_data ?? [[
            'month' => $santha->month,
            'year' => $santha->year,
            'monthName' => $santha->month
        ]];
        
        // Get only the partial months (skip fully paid ones)
        $partialMonths = array_slice($allMonths, $fullyPaidMonths);
        
        if (empty($partialMonths)) {
            return $santha->getMonthsCoveredDisplay();
        }
        
        // Format the partial months
        $formatted = [];
        foreach ($partialMonths as $month) {
            $formatted[] = $month['monthName'] . ' ' . $month['year'];
        }
        
        return implode(', ', $formatted);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function updatedAmount()
    {
        $this->calculatePayment();
    }

    public function updatedOverpaymentMode()
    {
        $this->calculatePayment();
    }

    /**
     * Calculate how many months this payment covers based on amount + credit
     */
    public function calculatePayment()
    {
        if (!$this->amount || $this->monthlyAmount <= 0) {
            $this->monthsToPay = 1;
            $this->newCredit = 0;
            $this->generateMonthsArray();
            return;
        }

        // Total effective amount = new payment + any existing family credit
        $effectiveAmount = floatval($this->amount) + floatval($this->familyCredit);
        
        if ($this->overpaymentMode === 'single_month') {
            // SINGLE MONTH MODE: Pay only 1 month, excess is a donation (no credit)
            $this->monthsToPay = 1;
            $this->newCredit = 0;
        } else {
            // CREDIT MODE: Calculate full months + apply remainder to next month as partial
            $fullMonths = floor($effectiveAmount / $this->monthlyAmount);
            $remainder = $effectiveAmount - ($fullMonths * $this->monthlyAmount);
            
            if ($remainder > 0) {
                // If there's a remainder, it goes to the next month as partial payment
                $this->monthsToPay = $fullMonths + 1; // Include the partial month
                $this->newCredit = $remainder; // This will be balance for the partial month
            } else {
                // Exact amount for full months
                $this->monthsToPay = max(1, $fullMonths);
                $this->newCredit = 0;
            }
            
            // If amount is less than monthly amount (partial payment for 1 month)
            if ($effectiveAmount < $this->monthlyAmount) {
                $this->monthsToPay = 1;
                $this->newCredit = $effectiveAmount; // Partial payment amount
            }
        }
        
        $this->generateMonthsArray();
    }

    /**
     * Generate array of months to be covered by this payment
     * Auto-skips already paid months
     */
    public function generateMonthsArray()
    {
        $this->selectedMonths = [];
        
        // Default to current month if no family selected
        if (!$this->family_id) {
            $this->selectedMonths[] = [
                'month' => now()->month,
                'year' => now()->year,
                'monthName' => now()->format('F')
            ];
            return;
        }

        $mosqueId = Auth::user()->mosque_id;
        $monthsNeeded = max(1, intval($this->monthsToPay));
        $monthsFound = 0;
        
        // Start from current month
        $checkMonth = now()->month;
        $checkYear = now()->year;
        $maxIterations = 36; // Check up to 3 years ahead
        $iterations = 0;
        
        while ($monthsFound < $monthsNeeded && $iterations < $maxIterations) {
            $monthName = Carbon::create($checkYear, $checkMonth, 1)->format('F');
            
            // Check if this month is already paid (including months_data)
            $isPaid = Santha::where('mosque_id', $mosqueId)
                ->where('family_id', $this->family_id)
                ->where(function($q) use ($checkMonth, $monthName, $checkYear) {
                    // Check main month field
                    $q->where(function($sq) use ($checkMonth, $monthName, $checkYear) {
                        $sq->where('year', $checkYear)
                           ->where(function($mq) use ($checkMonth, $monthName) {
                               $mq->where('month', $checkMonth)
                                  ->orWhere('month', $monthName);
                           });
                    })
                    // Also check months_data JSON for multi-month payments
                    ->orWhereJsonContains('months_data', [
                        'month' => $checkMonth,
                        'year' => $checkYear,
                        'monthName' => $monthName
                    ]);
                })
                ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                ->exists();
            
            if (!$isPaid) {
                $this->selectedMonths[] = [
                    'month' => $checkMonth,
                    'year' => $checkYear,
                    'monthName' => $monthName
                ];
                $monthsFound++;
            }
            
            // Move to next month
            $checkMonth++;
            if ($checkMonth > 12) {
                $checkMonth = 1;
                $checkYear++;
            }
            $iterations++;
        }
        
        // Adjust monthsToPay if we couldn't find enough unpaid months
        if (count($this->selectedMonths) < $this->monthsToPay) {
            $this->monthsToPay = count($this->selectedMonths);
        }
    }

    public function editSantha($id)
    {
        $santha = Santha::findOrFail($id);
        
        $this->santhaId = $santha->id;
        $this->editMode = true;
        $this->family_id = $santha->family_id;
        $this->familySearch = $santha->family?->family_head_name ?? '';
        $this->amount = $santha->amount;
        $this->payment_date = $santha->payment_date->format('Y-m-d');
        $this->payment_method = $santha->payment_method;
        $this->notes = $santha->notes;
        $this->monthsToPay = $santha->months_covered ?? 1;
        $this->selectedMonths = $santha->months_data ?? [];
        $this->overpaymentMode = $santha->payment_applies_to ?? 'credit';
        $this->newCredit = $santha->balance_due ?? 0;
        
        $this->calculateFamilyCredit();
        $this->showModal = true;
    }

    public function payBalance($id)
    {
        $santha = Santha::findOrFail($id);
        
        // Open modal with pre-filled balance amount
        $this->resetForm();
        $this->completingPartialId = $id; // Track which partial payment we're completing
        $this->family_id = $santha->family_id;
        $this->familySearch = $santha->family?->family_head_name ?? '';
        $this->amount = $santha->balance_due; // Pre-fill with remaining balance
        $this->payment_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->overpaymentMode = 'credit';
        
        // Calculate which months are fully paid and which are partial
        $fullyPaidMonths = floor($santha->amount / $this->monthlyAmount);
        $allMonths = $santha->months_data ?? [[
            'month' => $santha->month,
            'year' => $santha->year,
            'monthName' => $santha->month
        ]];
        
        // Only show the partial/unpaid months (skip fully paid ones)
        $partialMonths = array_slice($allMonths, $fullyPaidMonths);
        
        $this->monthsToPay = count($partialMonths);
        $this->selectedMonths = $partialMonths;
        
        $this->calculateFamilyCredit();
        // Don't call calculatePayment() - we're completing existing months
        $this->showModal = true;
    }

    public function saveSantha()
    {
        $this->validate();

        try {
            $mosqueId = Auth::user()->mosque_id;
            
            // If completing a partial payment, update the existing record
            if ($this->completingPartialId) {
                $partialPayment = Santha::findOrFail($this->completingPartialId);
                
                // Add new payment to existing amount
                $totalPaid = $partialPayment->amount + $this->amount;
                $totalCost = $partialPayment->months_covered * $this->monthlyAmount;
                $newBalance = max(0, $totalCost - $totalPaid);
                
                $partialPayment->update([
                    'amount' => $totalPaid,
                    'balance_due' => $newBalance,
                    'is_paid' => $newBalance <= 0,
                    'status' => $newBalance > 0 ? 'partial' : 'paid',
                    'notes' => ($partialPayment->notes ? $partialPayment->notes . "\n" : '') . 
                               "Balance payment: {$this->amount} on " . now()->format('Y-m-d')
                ]);
                
                $this->dispatch('swal:success', title: 'Success', text: 'Balance payment recorded successfully');
                $this->closeModal();
                return;
            }
            
            // Make sure months array is up to date
            if (empty($this->selectedMonths)) {
                $this->generateMonthsArray();
            }
            
            if (empty($this->selectedMonths)) {
                throw new \Exception("No unpaid months available for this family.");
            }
            
            $firstMonth = $this->selectedMonths[0];
            $monthName = $firstMonth['monthName'];
            $year = $firstMonth['year'];
            
            // Check for duplicate payment (only for new records)
            if (!$this->editMode) {
                // Check if ANY of the selected months are already paid
                foreach ($this->selectedMonths as $checkMonth) {
                    $monthName = $checkMonth['monthName'];
                    $month = $checkMonth['month'];
                    $year = $checkMonth['year'];
                    
                    $existing = Santha::where('mosque_id', $mosqueId)
                        ->where('family_id', $this->family_id)
                        ->where(function($q) use ($month, $monthName, $year) {
                            // Check main month field
                            $q->where(function($sq) use ($month, $monthName, $year) {
                                $sq->where('year', $year)
                                   ->where(function($mq) use ($month, $monthName) {
                                       $mq->where('month', $month)
                                          ->orWhere('month', $monthName);
                                   });
                            })
                            // Also check months_data JSON
                            ->orWhereJsonContains('months_data', [
                                'month' => $month,
                                'year' => $year,
                                'monthName' => $monthName
                            ]);
                        })
                        ->exists();

                    if ($existing) {
                        throw new \Exception("Payment already exists for {$monthName} {$year}");
                    }
                }
            }

            // If using family credit, update the previous payment's balance_due
            if ($this->familyCredit > 0 && !$this->editMode) {
                $creditUsed = min($this->familyCredit, $this->monthlyAmount * count($this->selectedMonths) - $this->amount);
                
                if ($creditUsed > 0) {
                    $lastPaymentWithCredit = Santha::where('mosque_id', $mosqueId)
                        ->where('family_id', $this->family_id)
                        ->where('payment_applies_to', 'credit')
                        ->where('balance_due', '>', 0)
                        ->orderBy('payment_date', 'desc')
                        ->first();
                    
                    if ($lastPaymentWithCredit) {
                        // Deduct the used credit
                        $remainingCredit = max(0, $lastPaymentWithCredit->balance_due - $creditUsed);
                        $lastPaymentWithCredit->update(['balance_due' => $remainingCredit]);
                    }
                }
            }

            // Generate receipt number
            $receiptNumber = $this->editMode 
                ? Santha::find($this->santhaId)->receipt_number 
                : $this->generateReceiptNumber($mosqueId);

            // Check if last month is partial (has remaining balance)
            $totalCost = count($this->selectedMonths) * $this->monthlyAmount;
            $totalPaid = $this->amount + ($this->familyCredit > 0 ? $this->familyCredit : 0);
            $balanceRemaining = $totalCost - $totalPaid;
            
            // Prepare data - unified for both single and multi-month
            $data = [
                'mosque_id' => $mosqueId,
                'family_id' => $this->family_id,
                'month' => $monthName,
                'year' => $year,
                'amount' => $this->amount,
                'months_covered' => count($this->selectedMonths),
                'months_data' => count($this->selectedMonths) > 1 ? $this->selectedMonths : null,
                'balance_due' => $balanceRemaining > 0 ? $balanceRemaining : 0, // Remaining balance for partial month
                'payment_applies_to' => $this->overpaymentMode,
                'payment_date' => $this->payment_date,
                'payment_method' => $this->payment_method,
                'receipt_number' => $receiptNumber,
                'is_paid' => $balanceRemaining <= 0,
                'status' => $balanceRemaining > 0 ? 'partial' : 'paid',
                'notes' => $this->notes,
            ];

            if ($this->editMode) {
                $santha = Santha::findOrFail($this->santhaId);
                $santha->update($data);
                
                // Update associated Baithulmal transaction if exists
                if ($santha->baithulmalTransaction) {
                    $santha->baithulmalTransaction->update([
                        'amount' => $this->amount,
                        'transaction_date' => $this->payment_date,
                        'payment_method' => $this->payment_method,
                        'description' => 'Santha Payment - ' . $monthName . ' ' . $year . ' (' . count($this->selectedMonths) . ' months)',
                        'notes' => $this->notes,
                    ]);
                }
                
                $message = 'Payment updated successfully';
            } else {
                $santha = Santha::create($data);
                
                // Create corresponding Baithulmal income transaction
                BaithulmalTransaction::create([
                    'mosque_id' => $mosqueId,
                    'type' => 'income',
                    'category' => 'santha',
                    'description' => 'Santha Payment - ' . $monthName . ' ' . $year . ' (' . count($this->selectedMonths) . ' months)',
                    'amount' => $this->amount,
                    'transaction_date' => $this->payment_date,
                    'payment_method' => $this->payment_method,
                    'reference_number' => $receiptNumber,
                    'reference_santha_id' => $santha->id,
                    'received_from' => $this->family_id ? Family::find($this->family_id)?->family_head_name : 'Unknown',
                    'notes' => $this->notes,
                    'created_by' => Auth::id(),
                ]);
                
                $message = 'Payment recorded successfully';
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
            $santha = Santha::findOrFail($id);
            
            // Delete associated Baithulmal transaction if exists
            if ($santha->baithulmalTransaction) {
                $santha->baithulmalTransaction->delete();
            }
            
            $santha->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Payment deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewReceipt($id)
    {
        $santha = Santha::with(['family', 'mosque'])->findOrFail($id);

        // Calculate if credit was used (by checking previous payments)
        $mosqueId = Auth::user()->mosque_id;
        $previousCredit = 0;
        
        // Get the previous payment with credit before this one
        $previousPayment = Santha::where('mosque_id', $mosqueId)
            ->where('family_id', $santha->family_id)
            ->where('payment_date', '<', $santha->payment_date)
            ->where('balance_due', '>', 0)
            ->where('payment_applies_to', 'credit')
            ->orderBy('payment_date', 'desc')
            ->first();
        
        if ($previousPayment && $previousPayment->balance_due > 0) {
            // This payment might have used credit
            $expectedForMonths = $santha->months_covered * $this->monthlyAmount;
            if ($santha->amount < $expectedForMonths) {
                $previousCredit = min($previousPayment->balance_due, $expectedForMonths - $santha->amount);
            }
        }

        // Determine which month has the balance (last month in the list)
        $balanceMonth = '';
        if ($santha->balance_due > 0 && $santha->status === 'partial') {
            $monthsData = $santha->months_data; // Assign to variable first
            if (!empty($monthsData)) {
                $lastMonth = end($monthsData);
                $balanceMonth = $lastMonth['monthName'] . ' ' . $lastMonth['year'];
            } else {
                $balanceMonth = $santha->month . ' ' . $santha->year;
            }
        }

        $this->viewingSantha = [
            'id' => $santha->id,
            'receipt_number' => $santha->receipt_number,
            'family_name' => $santha->family?->family_head_name ?? 'N/A',
            'family_phone' => $santha->family?->phone ?? 'N/A',
            'amount' => $santha->amount,
            'previous_credit_used' => $previousCredit,
            'total_applied' => $santha->amount + $previousCredit,
            'month' => $santha->month,
            'year' => $santha->year,
            'months_covered' => $santha->months_covered ?? 1,
            'months_display' => $santha->getMonthsCoveredDisplay(),
            'new_credit' => $santha->balance_due ?? 0,
            'balance_month' => $balanceMonth,
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
            'santhaId', 'family_id', 'familySearch', 'showFamilyDropdown', 
            'amount', 'payment_date', 'payment_method', 'notes', 'editMode', 
            'monthsToPay', 'selectedMonths', 'familyCredit', 'newCredit',
            'amountNeeded', 'overpaymentMode', 'completingPartialId', 'familyPartialPayments'
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
