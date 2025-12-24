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
    public $showModal = false;
    public $editMode = false;
    public $santhaId;

    public $family_id, $amount, $month, $year, $payment_date, $payment_method;
    public $receipt_number, $is_paid = false, $notes;

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
        $this->month = now()->format('F Y');
        $this->year = now()->year;
        $this->generateReceiptNumber();
        $this->showModal = true;
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
            $data = [
                'mosque_id' => auth()->user()->mosque_id,
                'family_id' => $this->family_id,
                'amount' => $this->amount,
                'month' => $this->month,
                'year' => $this->year,
                'payment_date' => $this->payment_date,
                'payment_method' => $this->payment_method,
                'receipt_number' => $this->receipt_number,
                'is_paid' => $this->is_paid,
                'notes' => $this->notes,
            ];

            if ($this->editMode) {
                Santha::findOrFail($this->santhaId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Santha payment updated successfully!');
            } else {
                Santha::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Santha payment recorded successfully!');
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
            $this->dispatch('swal:success', title: 'Success', text: 'Santha payment deleted successfully!');
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
