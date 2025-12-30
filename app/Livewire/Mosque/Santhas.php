<?php

namespace App\Livewire\Mosque;

use App\Models\Santha;
use App\Models\Family;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Santhas extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteSantha' => 'deleteSantha'];

    public $search = '';
    public $filterMonth = '';
    public $filterYear = '';
    public $filterStatus = '';
    public $showModal = false;
    public $editMode = false;
    public $santhaId;

    public $family_id, $amount, $month, $year, $payment_date, $payment_method;
    public $receipt_number, $is_paid = false, $notes;
    public $unpaidSanthas = [];
    public $selectedSanthaId = null;
    public $payment_type = 'this_month'; // 'this_month' or 'multiple_months'
    public $monthly_santha_amount = 0;
    // Receipt viewing
    public $showReceiptModal = false;
    public $viewingSantha = null;

    protected function rules()
    {
        $rules = [
            'family_id' => 'required|exists:families,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'year' => 'required|integer',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'is_paid' => 'boolean',
            'notes' => 'nullable|string',
        ];

        if (!$this->editMode) {
            $rules['receipt_number'] = 'required|string|unique:santhas,receipt_number';
        } else {
            $rules['receipt_number'] = 'required|string|unique:santhas,receipt_number,'.$this->santhaId;
        }

        return $rules;
    }

    public function mount()
    {
        $this->generateReceiptNumber();
    }

    public function generateReceiptNumber()
    {
        if (!$this->editMode) {
            $this->receipt_number = 'SAN-' . now()->format('Ym') . '-' . str_pad(Santha::where('mosque_id', auth()->user()->mosque_id)->count() + 1, 3, '0', STR_PAD_LEFT);
        }
    }

    public function openModal()
    {
        $this->resetForm();
        $this->payment_date = today()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->month = now()->format('F');
        $this->year = now()->year;
        $this->generateReceiptNumber();
        $this->unpaidSanthas = [];
        $this->selectedSanthaId = null;
        $this->payment_type = 'this_month';
        $this->monthly_santha_amount = 0;
        $this->showModal = true;
    }

    public function updatedFamilyId($value)
    {
        if ($value) {
            // Get mosque settings for monthly santha amount
            $mosqueSettings = \App\Models\MosqueSetting::where('mosque_id', auth()->user()->mosque_id)->first();
            $this->monthly_santha_amount = $mosqueSettings ? $mosqueSettings->santha_amount : 500;
            
            // Fetch unpaid santhas for this family
            $this->unpaidSanthas = Santha::where('family_id', $value)
                ->where('mosque_id', auth()->user()->mosque_id)
                ->where('is_paid', false)
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
                ->map(function($santha) {
                    return [
                        'id' => $santha->id,
                        'month' => $santha->month,
                        'year' => $santha->year,
                        'amount' => $santha->amount,
                        'receipt_number' => $santha->receipt_number,
                    ];
                })
                ->toArray();
            
            // If there are unpaid santhas, auto-select the oldest one
            if (count($this->unpaidSanthas) > 0) {
                $oldestSantha = $this->unpaidSanthas[0];
                $this->selectedSanthaId = $oldestSantha['id'];
                $this->loadSanthaDetails($oldestSantha['id']);
            }
        } else {
            $this->unpaidSanthas = [];
            $this->selectedSanthaId = null;
        }
    }

    public function updatedSelectedSanthaId($value)
    {
        if ($value) {
            $this->loadSanthaDetails($value);
        }
    }

    private function loadSanthaDetails($santhaId)
    {
        $santha = Santha::findOrFail($santhaId);
        $this->amount = $santha->amount;
        $this->month = $santha->month;
        $this->year = $santha->year;
        $this->receipt_number = $santha->receipt_number;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editSantha($id)
    {
        $santha = Santha::findOrFail($id);
        $this->santhaId = $santha->id;
        $this->family_id = $santha->family_id;
        $this->amount = $santha->amount;
        $this->month = $santha->month;
        $this->year = $santha->year;
        $this->payment_date = $santha->payment_date->format('Y-m-d');
        $this->payment_method = $santha->payment_method;
        $this->receipt_number = $santha->receipt_number;
        $this->is_paid = $santha->is_paid;
        $this->notes = $santha->notes;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveSantha()
    {
        $this->validate();

        try {
            if ($this->payment_type === 'this_month') {
                // Pay only the selected month with the entered amount
                $data = [
                    'mosque_id' => auth()->user()->mosque_id,
                    'family_id' => $this->family_id,
                    'amount' => $this->amount,
                    'month' => $this->month,
                    'year' => $this->year,
                    'payment_date' => $this->payment_date,
                    'payment_method' => $this->payment_method,
                    'receipt_number' => $this->receipt_number,
                    'is_paid' => true,
                    'status' => 'paid',
                    'notes' => $this->notes,
                ];

                if ($this->editMode) {
                    Santha::findOrFail($this->santhaId)->update($data);
                    $this->dispatch('swal:success', title: 'Success', text: 'Payment updated for ' . $this->month . ' ' . $this->year);
                } elseif ($this->selectedSanthaId) {
                    // Update existing unpaid santha
                    Santha::findOrFail($this->selectedSanthaId)->update($data);
                    $this->dispatch('swal:success', title: 'Success', text: 'Payment recorded for ' . $this->month . ' ' . $this->year);
                } else {
                    // Create new santha record
                    Santha::create($data);
                    $this->dispatch('swal:success', title: 'Success', text: 'Payment recorded for ' . $this->month . ' ' . $this->year);
                }
            } else {
                // Pay multiple months based on santha amount
                if ($this->monthly_santha_amount <= 0) {
                    throw new \Exception('Monthly santha amount not configured. Please update mosque settings.');
                }
                
                $monthsToPay = floor($this->amount / $this->monthly_santha_amount);
                $remainingAmount = $this->amount % $this->monthly_santha_amount;
                
                if ($monthsToPay == 0) {
                    throw new \Exception('Amount is less than monthly santha amount (₹' . $this->monthly_santha_amount . ')');
                }
                
                // Get unpaid santhas ordered by oldest first
                $unpaidSanthas = Santha::where('family_id', $this->family_id)
                    ->where('mosque_id', auth()->user()->mosque_id)
                    ->where('is_paid', false)
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->limit($monthsToPay)
                    ->get();
                
                $paidCount = 0;
                
                // Pay existing unpaid santhas first
                foreach ($unpaidSanthas as $santha) {
                    if ($paidCount >= $monthsToPay) break;
                    
                    $santha->update([
                        'is_paid' => true,
                        'status' => 'paid',
                        'amount' => $this->monthly_santha_amount,
                        'payment_date' => $this->payment_date,
                        'payment_method' => $this->payment_method,
                        'notes' => ($this->notes ? $this->notes . ' | ' : '') . 'Paid via bulk payment',
                    ]);
                    $paidCount++;
                }
                
                // If more months to pay, create new upcoming payment records
                if ($paidCount < $monthsToPay) {
                    $startDate = now(); // Start from current month
                    $remainingMonths = $monthsToPay - $paidCount;
                    
                    for ($i = 0; $i < $remainingMonths; $i++) {
                        $monthDate = $startDate->copy()->addMonths($i);
                        $receiptNumber = 'SAN-' . $monthDate->format('Ym') . '-' . str_pad(Santha::where('mosque_id', auth()->user()->mosque_id)->count() + 1, 3, '0', STR_PAD_LEFT);
                        
                        Santha::create([
                            'mosque_id' => auth()->user()->mosque_id,
                            'family_id' => $this->family_id,
                            'amount' => $this->monthly_santha_amount,
                            'month' => $monthDate->format('F'),
                            'year' => $monthDate->year,
                            'payment_date' => $this->payment_date,
                            'payment_method' => $this->payment_method,
                            'receipt_number' => $receiptNumber,
                            'is_paid' => true,
                            'status' => 'paid',
                            'notes' => ($this->notes ? $this->notes . ' | ' : '') . 'Paid via bulk payment (upcoming)',
                        ]);
                        $paidCount++;
                    }
                }
                
                $message = "Payment recorded for {$paidCount} month(s)";
                if ($remainingAmount > 0) {
                    $message .= ". Remaining ₹{$remainingAmount} not applied.";
                }
                
                $this->dispatch('swal:success', title: 'Success', text: $message);
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteSantha($id)
    {
        try {
            Santha::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Santha payment deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewReceipt($id)
    {
        $santha = Santha::with('family')->findOrFail($id);

        $this->viewingSantha = [
            'id' => $santha->id,
            'receipt_number' => $santha->receipt_number,
            'family_head_name' => $santha->family?->family_head_name,
            'family_phone' => $santha->family?->phone,
            'amount' => $santha->amount,
            'month' => $santha->month,
            'year' => $santha->year,
            'payment_date' => $santha->payment_date?->format('d M, Y'),
            'payment_method' => $santha->payment_method,
            'notes' => $santha->notes,
            'mosque_name' => optional($santha->mosque)->name ?? config('app.name'),
        ];

        $this->showReceiptModal = true;
    }

    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->viewingSantha = null;
    }

    public function markAsPaid($id)
    {
        try {
            $santha = Santha::findOrFail($id);
            $santha->update([
                'is_paid' => true,
                'status' => 'paid',
                'payment_date' => today(),
            ]);
            $this->dispatch('swal:success', title: 'Success', text: 'Payment marked as paid successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->reset([
            'santhaId', 'family_id', 'amount', 'month', 'year',
            'payment_date', 'payment_method', 'receipt_number',
            'is_paid', 'notes', 'editMode'
        ]);
        $this->is_paid = false;
    }

    public function render()
    {
        $mosqueeId = auth()->user()->mosque_id;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $santhas = Santha::where('mosque_id', $mosqueeId)
            ->when($this->search, function ($query) {
                $query->whereHas('family', function ($q) {
                    $q->where('family_head_name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('receipt_number', 'like', '%' . $this->search . '%')
                ->orWhere('month', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterMonth, function ($query) {
                $query->whereMonth('payment_date', $this->filterMonth);
            })
            ->when($this->filterYear, function ($query) {
                $query->whereYear('payment_date', $this->filterYear);
            })
            ->when($this->filterStatus === 'paid', function ($query) {
                $query->where('is_paid', true);
            })
            ->when($this->filterStatus === 'unpaid', function ($query) {
                $query->where('is_paid', false);
            })
            ->with('family')
            ->orderBy('year', 'desc')
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        $families = Family::where('mosque_id', $mosqueeId)
            ->where('is_active', true)
            ->orderBy('family_head_name')
            ->get();

        // Statistics
        $totalThisMonth = Santha::where('mosque_id', $mosqueeId)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('is_paid', true)
            ->sum('amount');

        $paidCount = Santha::where('mosque_id', $mosqueeId)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('is_paid', true)
            ->count();

        $unpaidCount = Santha::where('mosque_id', $mosqueeId)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('is_paid', false)
            ->count();

        $totalFamilies = Family::where('mosque_id', $mosqueeId)->count();
        $collectionRate = $totalFamilies > 0 ? round(($paidCount / $totalFamilies) * 100) : 0;

        return view('livewire.mosque.santhas', [
            'santhas' => $santhas,
            'families' => $families,
            'totalThisMonth' => $totalThisMonth,
            'paidCount' => $paidCount,
            'unpaidCount' => $unpaidCount,
            'collectionRate' => $collectionRate,
        ]);
    }
}
