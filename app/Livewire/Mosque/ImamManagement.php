<?php

namespace App\Livewire\Mosque;

use App\Models\Imam;
use App\Models\ImamAvailableDay;
use App\Models\ImamFinancialRecord;
use App\Models\Mosque;
use Livewire\Component;
use Livewire\WithPagination;

class ImamManagement extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteImam' => 'deleteImam', 'confirmDeleteRecord' => 'deleteRecord', 'confirmDeleteDay' => 'deleteDay'];

    public $activeTab = 'imams';
    public $search = '';
    public $perPage = 10;

    // Imam modal properties
    public $showImamModal = false;
    public $editingImam = false;
    public $imam_id;
    public $name, $email, $phone, $address, $date_of_birth, $qualification, $experience, $monthly_salary, $status = 'active', $notes;

    // Financial record modal properties
    public $showSalaryModal = false;
    public $showAdvanceModal = false;
    public $editingRecord = false;
    public $record_id;
    public $record_type; // 'salary' or 'advance'
    public $imam_id_record, $amount, $record_date, $payment_date, $payment_method, $transaction_id, $record_notes, $record_status = 'pending';
    // Salary specific
    public $basic_salary, $house_allowance = 0, $transport_allowance = 0, $medical_allowance = 0, $other_allowances = 0;
    // Advance specific
    public $purpose, $reason;

    // Available days modal properties
    public $showDaysModal = false;
    public $editingDay = false;
    public $day_id;
    public $imam_id_day, $is_available = true, $start_date, $end_date, $day_notes;

    // Payment modal properties
    public $showPaymentModal = false;
    public $paymentAdvance;
    public $payment_notes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'date_of_birth' => 'nullable|date|before:today',
        'qualification' => 'nullable|string|max:255',
        'experience' => 'nullable|string',
        'monthly_salary' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
        'notes' => 'nullable|string',

        // Financial record validation
        'imam_id_record' => 'required|exists:imams,id',
        'amount' => 'required|numeric|min:0',
        'record_date' => 'required|date',
        'payment_date' => 'nullable|date|after_or_equal:record_date',
        'payment_method' => 'nullable|string|max:255',
        'transaction_id' => 'nullable|string|max:255',
        'record_notes' => 'nullable|string',
        'record_status' => 'required|in:pending,paid,approved,rejected,cancelled',

        // Salary specific
        'basic_salary' => 'required_if:record_type,salary|numeric|min:0',
        'house_allowance' => 'nullable|numeric|min:0',
        'transport_allowance' => 'nullable|numeric|min:0',
        'medical_allowance' => 'nullable|numeric|min:0',
        'other_allowances' => 'nullable|numeric|min:0',

        // Advance specific
        'purpose' => 'nullable|string|max:255',
        'reason' => 'nullable|string',

        // Available days validation
        'imam_id_day' => 'required|exists:imams,id',
        'is_available' => 'required|boolean',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'day_notes' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'Imam name is required.',
        'monthly_salary.required' => 'Monthly salary is required.',
        'imam_id_record.required' => 'Please select an imam.',
        'amount.required' => 'Amount is required.',
        'record_date.required' => 'Record date is required.',
        'basic_salary.required_if' => 'Basic salary is required for salary records.',
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatedActiveTab()
    {
        $this->resetPage();
        $this->search = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Imam CRUD methods
    public function openImamModal($imamId = null)
    {
        $this->resetImamFields();
        $this->showImamModal = true;

        if ($imamId) {
            $this->editingImam = true;
            $imam = Imam::find($imamId);
            $this->fill($imam->toArray());
            $this->imam_id = $imam->id;
        }
    }

    public function closeImamModal()
    {
        $this->showImamModal = false;
        $this->editingImam = false;
        $this->resetImamFields();
    }

    public function saveImam()
    {
        $this->validate();

        try {
            $data = [
                'mosque_id' => auth()->user()->mosque->id,
                'name' => $this->name,
                'email' => $this->email ?: null,
                'phone' => $this->phone ?: null,
                'address' => $this->address ?: null,
                'date_of_birth' => $this->date_of_birth ?: null,
                'qualification' => $this->qualification ?: null,
                'experience' => $this->experience ?: null,
                'monthly_salary' => $this->monthly_salary ?: 0,
                'status' => $this->status,
                'notes' => $this->notes ?: null,
            ];

            if ($this->editingImam) {
                Imam::findOrFail($this->imam_id)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Imam updated successfully');
            } else {
                Imam::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Imam added successfully');
            }

            $this->closeImamModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteImam($imamId)
    {
        try {
            Imam::findOrFail($imamId)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Imam deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Financial record methods
    public function openSalaryModal($recordId = null)
    {
        $this->resetRecordFields();
        $this->showSalaryModal = true;
        $this->record_type = 'salary';

        if ($recordId) {
            $this->editingRecord = true;
            $record = ImamFinancialRecord::find($recordId);
            $this->fillRecordFields($record);
        }
    }

    public function openAdvanceModal($recordId = null)
    {
        $this->resetRecordFields();
        $this->showAdvanceModal = true;
        $this->record_type = 'advance';

        if ($recordId) {
            $this->editingRecord = true;
            $record = ImamFinancialRecord::find($recordId);
            $this->fillRecordFields($record);
        }
    }

    public function closeRecordModal()
    {
        $this->showSalaryModal = false;
        $this->showAdvanceModal = false;
        $this->editingRecord = false;
        $this->resetRecordFields();
    }

    public function saveRecord()
    {
        $rules = [
            'imam_id_record' => 'required|exists:imams,id',
            'record_date' => 'required|date',
            'payment_date' => 'nullable|date|after_or_equal:record_date',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'record_notes' => 'nullable|string',
            'record_status' => 'required|in:pending,paid,approved,rejected,cancelled',
        ];

        if ($this->record_type === 'salary') {
            $rules = array_merge($rules, [
                'basic_salary' => 'required|numeric|min:0',
                'house_allowance' => 'nullable|numeric|min:0',
                'transport_allowance' => 'nullable|numeric|min:0',
                'medical_allowance' => 'nullable|numeric|min:0',
                'other_allowances' => 'nullable|numeric|min:0',
            ]);
            $this->amount = ((float)($this->basic_salary ?? 0)) + ((float)($this->house_allowance ?? 0)) + ((float)($this->transport_allowance ?? 0)) + ((float)($this->medical_allowance ?? 0)) + ((float)($this->other_allowances ?? 0));
        } else {
            $rules['amount'] = 'required|numeric|min:0';
            $rules['purpose'] = 'nullable|string|max:255';
            $rules['reason'] = 'nullable|string';
        }

        $this->validate($rules);

        try {
            $data = [
                'imam_id' => $this->imam_id_record,
                'mosque_id' => auth()->user()->mosque->id,
                'type' => $this->record_type,
                'amount' => $this->amount,
                'record_date' => $this->record_date,
                'payment_date' => $this->payment_date ?: null,
                'payment_method' => $this->payment_method ?: null,
                'transaction_id' => $this->transaction_id ?: null,
                'notes' => $this->record_notes ?: null,
                'status' => $this->record_status,
            ];

            if ($this->record_type === 'salary') {
                $data = array_merge($data, [
                    'basic_salary' => $this->basic_salary,
                    'house_allowance' => $this->house_allowance ?: null,
                    'transport_allowance' => $this->transport_allowance ?: null,
                    'medical_allowance' => $this->medical_allowance ?: null,
                    'other_allowances' => $this->other_allowances ?: null,
                ]);
            } else {
                $data = array_merge($data, [
                    'purpose' => $this->purpose ?: null,
                    'reason' => $this->reason ?: null,
                ]);
            }

            if ($this->editingRecord) {
                ImamFinancialRecord::findOrFail($this->record_id)->update($data);
                $message = $this->record_type === 'salary' ? 'Salary record updated successfully' : 'Advance payment updated successfully';
            } else {
                ImamFinancialRecord::create($data);
                $message = $this->record_type === 'salary' ? 'Salary record added successfully' : 'Advance payment requested successfully';
            }

            $this->dispatch('swal:success', title: 'Success', text: $message);
            $this->closeRecordModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function getAvailableSalary($imamId)
    {
        $imam = Imam::find($imamId);
        if (!$imam) return 0;

        $currentMonth = now()->format('Y-m');
        
        // Get total advances for current month
        $monthlyAdvances = ImamFinancialRecord::where('imam_id', $imamId)
            ->where('type', 'advance')
            ->where('status', 'paid')
            ->whereRaw("DATE_FORMAT(record_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('amount');

        return (float)$imam->monthly_salary - (float)$monthlyAdvances;
    }

    public function deleteRecord($recordId)
    {
        try {
            $record = ImamFinancialRecord::findOrFail($recordId);
            $record->delete();
            $message = $record->type === 'salary' ? 'Salary record deleted successfully' : 'Advance record deleted successfully';
            $this->dispatch('swal:success', title: 'Success', text: $message);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Available days methods
    public function openDaysModal($dayId = null)
    {
        $this->resetDayFields();
        $this->showDaysModal = true;

        if ($dayId) {
            $this->editingDay = true;
            $day = ImamAvailableDay::find($dayId);
            $this->fill($day->toArray());
            $this->day_id = $day->id;
        }
    }

    public function closeDaysModal()
    {
        $this->showDaysModal = false;
        $this->editingDay = false;
        $this->resetDayFields();
    }

    public function saveDay()
    {
        $this->validate([
            'imam_id_day' => 'required|exists:imams,id',
            'is_available' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_notes' => 'nullable|string',
        ]);

        try {
            $data = [
                'imam_id' => $this->imam_id_day,
                'mosque_id' => auth()->user()->mosque->id,
                'day_of_week' => 'period', // Default value since it's required in DB
                'is_available' => $this->is_available,
                'specific_date' => null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'notes' => $this->day_notes ?: null,
            ];

            if ($this->editingDay) {
                ImamAvailableDay::findOrFail($this->day_id)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Availability updated successfully');
            } else {
                ImamAvailableDay::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Availability added successfully');
            }

            $this->closeDaysModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteDay($dayId)
    {
        try {
            ImamAvailableDay::findOrFail($dayId)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Availability deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Payment methods
    public function payAdvance($advanceId)
    {
        $this->paymentAdvance = ImamFinancialRecord::find($advanceId);
        $this->resetPaymentFields();
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->paymentAdvance = null;
        $this->resetPaymentFields();
    }

    public function processPayment()
    {
        $this->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string',
        ]);

        try {
            $this->paymentAdvance->update([
                'payment_date' => $this->payment_date,
                'payment_method' => $this->payment_method,
                'transaction_id' => $this->transaction_id ?: null,
                'notes' => $this->payment_notes ?: null,
                'status' => 'paid',
            ]);

            $this->dispatch('swal:success', title: 'Success', text: 'Advance payment processed successfully');
            $this->closePaymentModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Helper methods
    private function resetImamFields()
    {
        $this->imam_id = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->date_of_birth = '';
        $this->qualification = '';
        $this->experience = '';
        $this->monthly_salary = '';
        $this->status = 'active';
        $this->notes = '';
    }

    private function resetRecordFields()
    {
        $this->record_id = null;
        $this->imam_id_record = '';
        $this->amount = '';
        $this->record_date = '';
        $this->payment_date = '';
        $this->payment_method = '';
        $this->transaction_id = '';
        $this->record_notes = '';
        $this->record_status = 'pending';
        $this->basic_salary = '';
        $this->house_allowance = 0;
        $this->transport_allowance = 0;
        $this->medical_allowance = 0;
        $this->other_allowances = 0;
        $this->purpose = '';
        $this->reason = '';
    }

    private function resetDayFields()
    {
        $this->day_id = null;
        $this->imam_id_day = '';
        $this->is_available = true;
        $this->start_date = '';
        $this->end_date = '';
        $this->day_notes = '';
    }

    private function resetPaymentFields()
    {
        $this->payment_notes = '';
    }

    private function fillRecordFields($record)
    {
        $this->record_id = $record->id;
        $this->imam_id_record = $record->imam_id;
        $this->amount = $record->amount;
        $this->record_date = $record->record_date?->format('Y-m-d');
        $this->payment_date = $record->payment_date?->format('Y-m-d') ?: '';
        $this->payment_method = $record->payment_method ?: '';
        $this->transaction_id = $record->transaction_id ?: '';
        $this->record_notes = $record->notes ?: '';
        $this->record_status = $record->status;

        if ($record->type === 'salary') {
            $this->basic_salary = $record->basic_salary;
            $this->house_allowance = $record->house_allowance ?? 0;
            $this->transport_allowance = $record->transport_allowance ?? 0;
            $this->medical_allowance = $record->medical_allowance ?? 0;
            $this->other_allowances = $record->other_allowances ?? 0;
        } else {
            $this->purpose = $record->purpose ?: '';
            $this->reason = $record->reason ?: '';
        }
    }

    public function render()
    {
        $mosqueId = auth()->user()->mosque->id;
        $currentMonth = now()->format('Y-m');

        $imams = Imam::where('mosque_id', $mosqueId)
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        $salaries = ImamFinancialRecord::where('mosque_id', $mosqueId)
            ->where('type', 'salary')
            ->with('imam')
            ->when($this->search, function($query) {
                $query->whereHas('imam', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('record_date', 'desc')
            ->paginate($this->perPage);

        $advances = ImamFinancialRecord::where('mosque_id', $mosqueId)
            ->where('type', 'advance')
            ->with('imam')
            ->when($this->search, function($query) {
                $query->whereHas('imam', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('record_date', 'desc')
            ->paginate($this->perPage);

        $availableDays = ImamAvailableDay::where('mosque_id', $mosqueId)
            ->with('imam')
            ->when($this->search, function($query) {
                $query->whereHas('imam', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('start_date', 'desc')
            ->paginate($this->perPage);

        // Calculate financial summary for salaries tab
        $financialSummary = [];
        $allImams = Imam::where('mosque_id', $mosqueId)->where('status', 'active')->get();

        foreach ($allImams as $imam) {
            // Paid advances for current month
            $paidAdvances = ImamFinancialRecord::where('imam_id', $imam->id)
                ->where('type', 'advance')
                ->where('status', 'paid')
                ->whereRaw("DATE_FORMAT(record_date, '%Y-%m') = ?", [$currentMonth])
                ->sum('amount');

            // Pending/approved advances that need to be paid
            $pendingAdvances = ImamFinancialRecord::where('imam_id', $imam->id)
                ->where('type', 'advance')
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');

            // Available salary = monthly salary - paid advances
            $availableSalary = $imam->monthly_salary - $paidAdvances;

            $financialSummary[] = [
                'imam' => $imam,
                'monthly_salary' => $imam->monthly_salary,
                'paid_advances' => $paidAdvances,
                'pending_advances' => $pendingAdvances,
                'available_salary' => $availableSalary,
            ];
        }

        return view('livewire.mosque.imam-management', [
            'imams' => $imams,
            'salaries' => $salaries,
            'advances' => $advances,
            'availableDays' => $availableDays,
            'financialSummary' => $financialSummary,
        ]);
    }
}
