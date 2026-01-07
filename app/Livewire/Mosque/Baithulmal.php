<?php

namespace App\Livewire\Mosque;

use App\Models\BaithulmalTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class Baithulmal extends Component
{
    use WithPagination, WithFileUploads;

    // Event listeners for delete confirmations
    protected $listeners = [
        'deleteTransaction' => 'deleteTransaction'
    ];

    // Properties
    public $activeTab = 'overview';
    public $search = '';
    public $filterType = 'all'; // all, income, expense
    public $filterCategory = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $reportType = '1'; // 1 = overview, 2 = expense, 3 = income

    // Modal properties
    public $showModal = false;
    public $editMode = false;
    public $viewMode = false;
    public $transactionId;

    // Form properties
    public $type = 'income';
    public $category = '';
    public $description = '';
    public $amount = '';
    public $transaction_date;
    public $payment_method = 'cash';
    public $reference_number = '';
    public $paid_to = '';
    public $received_from = '';
    public $is_anonymous = false;
    public $notes = '';
    public $newAttachments = [];
    public $existingAttachments = [];

    // Predefined categories
    public $incomeCategories = [
        'jumma_collection' => 'Jumma Collection',
        'donation' => 'General Donation',
        'zakat' => 'Zakat',
        'sadaqah' => 'Sadaqah',
        'rental_income' => 'Rental Income',
        'event_income' => 'Event Income',
        'other_income' => 'Other Income',
    ];

    public $expenseCategories = [
        'water_bill' => 'Water Bill',
        'electricity_bill' => 'Electricity Bill',
        'internet_bill' => 'Internet Bill',
        'phone_bill' => 'Phone Bill',
        'jumma_expense' => 'Jumma Expense',
        'maintenance' => 'Maintenance',
        'cleaning' => 'Cleaning',
        'security' => 'Security',
        'staff_salary' => 'Staff Salary',
        'imam_salary' => 'Imam Salary',
        'utilities' => 'Utilities',
        'supplies' => 'Supplies',
        'repairs' => 'Repairs',
        'event_expense' => 'Event Expense',
        'charity' => 'Charity Distribution',
        'other_expense' => 'Other Expense',
    ];

    protected function rules()
    {
        return [
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|in:cash,bank_transfer,online,cheque,other',
            'reference_number' => 'nullable|string|max:255',
            'paid_to' => 'nullable|string|max:255',
            'received_from' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'newAttachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function mount()
    {
        $this->transaction_date = date('Y-m-d');
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->category = '';
    }

    public function openModal($type = 'income')
    {
        $this->resetForm();
        $this->type = $type;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editTransaction($id)
    {
        $transaction = BaithulmalTransaction::findOrFail($id);
        $this->transactionId = $transaction->id;
        $this->type = $transaction->type;
        $this->category = $transaction->category;
        $this->description = $transaction->description;
        $this->amount = $transaction->amount;
        $this->transaction_date = $transaction->transaction_date->format('Y-m-d');
        $this->payment_method = $transaction->payment_method;
        $this->reference_number = $transaction->reference_number;
        $this->paid_to = $transaction->paid_to;
        $this->received_from = $transaction->received_from;
        $this->is_anonymous = $transaction->is_anonymous ?? false;
        $this->notes = $transaction->notes;
        $this->existingAttachments = $transaction->attachments ?? [];

        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewTransaction($id)
    {
        $transaction = BaithulmalTransaction::findOrFail($id);
        $this->transactionId = $transaction->id;
        $this->type = $transaction->type;
        $this->category = $transaction->category;
        $this->description = $transaction->description;
        $this->amount = $transaction->amount;
        $this->transaction_date = $transaction->transaction_date->format('Y-m-d');
        $this->payment_method = $transaction->payment_method;
        $this->reference_number = $transaction->reference_number;
        $this->paid_to = $transaction->paid_to;
        $this->received_from = $transaction->received_from;
        $this->is_anonymous = $transaction->is_anonymous ?? false;
        $this->notes = $transaction->notes;
        $this->existingAttachments = $transaction->attachments ?? [];

        $this->viewMode = true;
        $this->showModal = true;
    }

    public function saveTransaction()
    {
        // Custom validation for anonymous transactions
        if ($this->type === 'income') {
            if (!$this->is_anonymous && empty($this->received_from)) {
                $this->addError('received_from', 'Received from is required unless marked as anonymous.');
                return;
            }
            if ($this->is_anonymous && !empty($this->received_from)) {
                $this->addError('received_from', 'Cannot specify received from for anonymous transactions.');
                return;
            }
        } else {
            if (!$this->is_anonymous && empty($this->paid_to)) {
                $this->addError('paid_to', 'Paid to is required unless marked as anonymous.');
                return;
            }
            if ($this->is_anonymous && !empty($this->paid_to)) {
                $this->addError('paid_to', 'Cannot specify paid to for anonymous transactions.');
                return;
            }
        }

        $this->validate();

        try {
            $data = [
                'mosque_id' => Auth::user()->mosque_id,
                'type' => $this->type,
                'category' => $this->category,
                'description' => $this->description,
                'amount' => $this->amount,
                'transaction_date' => $this->transaction_date,
                'payment_method' => $this->payment_method,
                'reference_number' => $this->reference_number,
                'paid_to' => $this->is_anonymous ? null : $this->paid_to,
                'received_from' => $this->is_anonymous ? null : $this->received_from,
                'is_anonymous' => $this->is_anonymous,
                'notes' => $this->notes,
                'created_by' => Auth::id(),
            ];

            // Handle file uploads
            $finalAttachments = $this->existingAttachments;

            foreach ($this->newAttachments as $file) {
                $finalAttachments[] = $file->store('baithulmal-attachments', 'public');
            }
            
            $data['attachments'] = !empty($finalAttachments) ? $finalAttachments : null;

            if ($this->editMode) {
                BaithulmalTransaction::findOrFail($this->transactionId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Transaction updated successfully');
            } else {
                BaithulmalTransaction::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Transaction added successfully');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteTransaction($id)
    {
        try {
            $transaction = BaithulmalTransaction::findOrFail($id);
            
            // Delete attachments if exists
            if (!empty($transaction->attachments)) {
                foreach ($transaction->attachments as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
            
            $transaction->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Transaction deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function removeAttachment($index)
    {
        if (isset($this->existingAttachments[$index])) {
            // We'll delete the file when the transaction is saved/updated to reflect changes? 
            // Or delete immediately? Let's just remove from the array for now and let the user save.
            // Actually, for better UX/Cleanliness, we should probably only remove reference 
            // and actually delete file if needed, but since we are replacing the array on save, 
            // the file would become orphaned if we don't delete. 
            // However, cleaning up orphaned files is a separate task. 
            // For now, removing from the list is sufficient for the UI update.
            // If we want to be strict, we can delete the file from storage if the user Saves.
            
            // Let's mark it as removed from UI array.
            unset($this->existingAttachments[$index]);
            $this->existingAttachments = array_values($this->existingAttachments); // Reindex
        }
    }

    private function resetForm()
    {
        $this->reset([
            'transactionId', 'type', 'category', 'description', 'amount',
            'transaction_date', 'payment_method', 'reference_number',
            'paid_to', 'received_from', 'is_anonymous', 'notes', 'newAttachments', 'existingAttachments', 'editMode', 'viewMode'
        ]);
        $this->type = 'income';
        $this->payment_method = 'cash';
        $this->is_anonymous = false;
        $this->transaction_date = date('Y-m-d');
    }

    public function render()
    {
        $mosqueId = Auth::user()->mosque_id;

        // Build query
        $query = BaithulmalTransaction::where('mosque_id', $mosqueId);

        // Apply filters
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo]);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $this->search . '%')
                  ->orWhere('paid_to', 'like', '%' . $this->search . '%')
                  ->orWhere('received_from', 'like', '%' . $this->search . '%');
            });
        }

        $transactions = $query->latest('transaction_date')->latest('id')->paginate(15);

        // Calculate statistics for the filtered period
        $statsQuery = BaithulmalTransaction::where('mosque_id', $mosqueId);
        
        if ($this->dateFrom && $this->dateTo) {
            $statsQuery->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo]);
        }

        $totalIncome = (clone $statsQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $statsQuery)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Category-wise breakdown
        $incomeByCategory = (clone $statsQuery)->where('type', 'income')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category');

        $expenseByCategory = (clone $statsQuery)->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category');

        // Recent transactions for overview
        $recentTransactions = BaithulmalTransaction::where('mosque_id', $mosqueId)
            ->latest('transaction_date')
            ->latest('id')
            ->take(10)
            ->get();

        return view('livewire.mosque.baithulmal', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'incomeByCategory' => $incomeByCategory,
            'expenseByCategory' => $expenseByCategory,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
