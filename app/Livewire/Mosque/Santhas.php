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
    public $month;
    public $year;
    public $amount;
    public $payment_date;
    public $payment_method = 'cash';
    public $notes;

    // Receipt Modal
    public $showReceiptModal = false;
    public $viewingSantha = null;

    // Settings
    public $monthlyAmount = 0;

    protected function rules()
    {
        return [
            'family_id' => 'required|exists:families,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2050',
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

    public function openModal()
    {
        $this->resetForm();
        $this->month = now()->month;
        $this->year = now()->year;
        $this->amount = $this->monthlyAmount;
        $this->payment_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
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
        }
    }

    public function editSantha($id)
    {
        $santha = Santha::findOrFail($id);
        $this->santhaId = $santha->id;
        $this->family_id = $santha->family_id;
        $this->month = is_numeric($santha->month) ? $santha->month : Carbon::parse($santha->month)->month;
        $this->year = $santha->year;
        $this->amount = $santha->amount;
        $this->payment_date = $santha->payment_date->format('Y-m-d');
        $this->payment_method = $santha->payment_method;
        $this->notes = $santha->notes;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveSantha()
    {
        $this->validate();

        try {
            $mosqueId = Auth::user()->mosque_id;
            $monthName = Carbon::create()->month($this->month)->format('F');

            // Check if payment already exists for this family/month/year (unless editing same record)
            $existing = Santha::where('mosque_id', $mosqueId)
                ->where('family_id', $this->family_id)
                ->where('year', $this->year)
                ->where(function($q) use ($monthName) {
                    $q->where('month', $this->month)
                      ->orWhere('month', $monthName);
                })
                ->when($this->editMode, fn($q) => $q->where('id', '!=', $this->santhaId))
                ->first();

            if ($existing) {
                throw new \Exception("Payment already exists for {$monthName} {$this->year}");
            }

            // Generate receipt number for new records
            $receiptNumber = $this->editMode 
                ? Santha::find($this->santhaId)->receipt_number 
                : $this->generateReceiptNumber($mosqueId);

            $data = [
                'mosque_id' => $mosqueId,
                'family_id' => $this->family_id,
                'month' => $monthName,
                'year' => $this->year,
                'amount' => $this->amount,
                'payment_date' => $this->payment_date,
                'payment_method' => $this->payment_method,
                'receipt_number' => $receiptNumber,
                'is_paid' => true,
                'status' => 'paid',
                'notes' => $this->notes,
            ];

            if ($this->editMode) {
                Santha::findOrFail($this->santhaId)->update($data);
                $message = 'Payment updated successfully';
            } else {
                Santha::create($data);
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
        $this->reset(['santhaId', 'family_id', 'month', 'year', 'amount', 'payment_date', 'payment_method', 'notes', 'editMode']);
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
