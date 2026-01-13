<?php

namespace App\Livewire\Mosque;

use App\Models\Donation;
use App\Models\Family;
use App\Models\BaithulmalTransaction;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Donations extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteDonation' => 'deleteDonation'];

    #[Livewire\Attributes\Computed]
    public function filteredFamilies()
    {
        if (empty($this->familySearch)) {
            return [];
        }

        return Family::where('mosque_id', auth()->user()->mosque_id)
            ->where(function ($query) {
                $query->where('family_head_name', 'like', '%' . $this->familySearch . '%')
                      ->orWhere('family_id', 'like', '%' . $this->familySearch . '%')
                      ->orWhere('phone', 'like', '%' . $this->familySearch . '%');
            })
            ->limit(10)
            ->get();
    }

    public function selectFamily($familyId, $familyName)
    {
        $this->family_id = $familyId;
        $this->familySearch = $familyName;
        $this->showFamilyDropdown = false;
        
        // Check if family has partial Santha payments
        $mosqueId = auth()->user()->mosque_id;
        $this->familyPartialPayments = [];
    }

    public function clearFamily()
    {
        $this->family_id = null;
        $this->familySearch = '';
        $this->showFamilyDropdown = false;
        $this->familyPartialPayments = [];
    }

    public $search = '';
    public $filterPurpose = '';
    public $filterMethod = '';
    public $filterType = 'received'; // received or given
    public $showModal = false;
    public $editMode = false;
    public $donationId;

    public $family_id, $donor_name, $donor_phone, $donor_email, $amount;
    public $donation_type, $payment_method, $receipt_number, $donation_date;
    public $purpose, $notes, $is_anonymous = false, $transaction_type = 'received';
    
    // Family search properties
    public $familySearch = '';
    public $showFamilyDropdown = false;
    public $familyPartialPayments = [];
    
    // Receipt viewing
    public $showReceiptModal = false;
    public $viewingDonation = null;

    protected function rules()
    {
        $rules = [
            'family_id' => 'nullable|exists:families,id',
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:0',
            'donation_type' => 'required|string',
            'payment_method' => 'required|string',
            'donation_date' => 'required|date',
            'purpose' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_anonymous' => 'boolean',
            'transaction_type' => 'required|in:received,given',
        ];

        if (!$this->editMode) {
            $rules['receipt_number'] = 'required|string|unique:donations,receipt_number';
        } else {
            $rules['receipt_number'] = 'required|string|unique:donations,receipt_number,'.$this->donationId;
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
            $this->receipt_number = 'DON-' . strtoupper(uniqid());
        }
    }

    public function openModal($type = 'received')
    {
        $this->resetForm();
        $this->transaction_type = $type;
        $this->donation_date = today()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->generateReceiptNumber();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $this->donationId = $donation->id;
        $this->family_id = $donation->family_id;
        $this->donor_name = $donation->donor_name;
        $this->donor_phone = $donation->donor_phone;
        $this->donor_email = $donation->donor_email;
        $this->amount = $donation->amount;
        $this->donation_type = $donation->donation_type;
        $this->payment_method = $donation->payment_method;
        $this->receipt_number = $donation->receipt_number;
        $this->donation_date = $donation->donation_date->format('Y-m-d');
        $this->purpose = $donation->purpose;
        $this->notes = $donation->notes;
        $this->is_anonymous = $donation->is_anonymous;
        $this->transaction_type = $donation->transaction_type ?? 'received';
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveDonation()
    {
        $this->validate();

        try {
            $data = [
                'mosque_id' => auth()->user()->mosque_id,
                'family_id' => $this->family_id,
                'donor_name' => $this->donor_name,
                'donor_phone' => $this->donor_phone,
                'donor_email' => $this->donor_email,
                'amount' => $this->amount,
                'donation_type' => $this->donation_type,
                'payment_method' => $this->payment_method,
                'receipt_number' => $this->receipt_number,
                'donation_date' => $this->donation_date,
                'purpose' => $this->purpose,
                'notes' => $this->notes,
                'is_anonymous' => $this->is_anonymous,
                'transaction_type' => $this->transaction_type,
            ];

            if ($this->editMode) {
                $donation = Donation::findOrFail($this->donationId);
                $donation->update($data);
                
                // Update associated Baithulmal transaction if exists
                if ($donation->baithulmalTransaction) {
                    $donation->baithulmalTransaction->update([
                        'amount' => $this->amount,
                        'transaction_date' => $this->donation_date,
                        'payment_method' => $this->payment_method,
                        'description' => $this->purpose,
                        'notes' => $this->notes,
                    ]);
                }
                
                $this->dispatch('swal:success', title: 'Success', text: 'Donation updated successfully');
            } else {
                $donation = Donation::create($data);
                
                // Create corresponding Baithulmal transaction
                // Received donations = income, Given donations = expense
                $transactionType = $this->transaction_type === 'received' ? 'income' : 'expense';
                
                BaithulmalTransaction::create([
                    'mosque_id' => auth()->user()->mosque_id,
                    'type' => $transactionType,
                    'category' => 'donation',
                    'description' => $this->purpose ?: 'Donation - ' . $this->donation_type,
                    'amount' => $this->amount,
                    'transaction_date' => $this->donation_date,
                    'payment_method' => $this->payment_method,
                    'reference_number' => $donation->receipt_number ?: $donation->id,
                    'reference_donation_id' => $donation->id,
                    'received_from' => $this->transaction_type === 'received' ? ($this->is_anonymous ? 'Anonymous' : $this->donor_name) : null,
                    'paid_to' => $this->transaction_type === 'given' ? ($this->is_anonymous ? 'Anonymous' : $this->donor_name) : null,
                    'notes' => $this->notes,
                    'is_anonymous' => $this->is_anonymous,
                    'created_by' => auth()->id(),
                ]);
                
                $message = $this->transaction_type === 'received' ? 'Donation received successfully' : 'Donation given successfully';
                $this->dispatch('swal:success', title: 'Success', text: $message);
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteDonation($id)
    {
        try {
            $donation = Donation::findOrFail($id);
            
            // Delete associated Baithulmal transaction if exists
            if ($donation->baithulmalTransaction) {
                $donation->baithulmalTransaction->delete();
            }
            
            $donation->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Donation deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewReceipt($id)
    {
        $donation = Donation::with('family')->findOrFail($id);

        $this->viewingDonation = [
            'id' => $donation->id,
            'receipt_number' => $donation->receipt_number,
            'donor_name' => $donation->donor_name,
            'donor_phone' => $donation->donor_phone,
            'donor_email' => $donation->donor_email,
            'amount' => $donation->amount,
            'purpose' => $donation->purpose,
            'donation_date' => $donation->donation_date?->format('d M, Y'),
            'payment_method' => $donation->payment_method,
            'notes' => $donation->notes,
            'mosque_name' => optional($donation->mosque)->name ?? config('app.name'),
            'family_name' => $donation->family?->family_head_name,
        ];

        $this->showReceiptModal = true;
    }

    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->viewingDonation = null;
    }

    private function resetForm()
    {
        $this->reset([
            'donationId', 'family_id', 'donor_name', 'donor_phone', 'donor_email',
            'amount', 'donation_type', 'payment_method', 'receipt_number',
            'donation_date', 'purpose', 'notes', 'is_anonymous', 'editMode', 'transaction_type',
            'familySearch', 'showFamilyDropdown', 'familyPartialPayments'
        ]);
        $this->is_anonymous = false;
        $this->transaction_type = 'received';
    }

    public function render()
    {
        $user = auth()->user();
        
        $donations = Donation::where('mosque_id', $user->mosque_id)
            ->when($this->filterType, function ($query) {
                $query->where('transaction_type', $this->filterType);
            })
            ->when($this->search, function ($query) {
                $query->where('donor_name', 'like', '%' . $this->search . '%')
                      ->orWhere('receipt_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterPurpose, function ($query) {
                $query->where('purpose', $this->filterPurpose);
            })
            ->when($this->filterMethod, function ($query) {
                $query->where('payment_method', $this->filterMethod);
            })
            ->with('family')
            ->latest('donation_date')
            ->paginate(10);

        // Calculate statistics - Received
        $totalReceivedDonations = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'received')
            ->sum('amount');
        $thisMonthReceivedDonations = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'received')
            ->whereMonth('donation_date', now()->month)
            ->whereYear('donation_date', now()->year)
            ->sum('amount');
        $totalReceivedDonors = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'received')
            ->distinct('donor_name')
            ->count('donor_name');
        $averageReceivedDonation = $totalReceivedDonors > 0 ? round($totalReceivedDonations / $totalReceivedDonors, 0) : 0;

        // Calculate statistics - Given
        $totalGivenDonations = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'given')
            ->sum('amount');
        $thisMonthGivenDonations = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'given')
            ->whereMonth('donation_date', now()->month)
            ->whereYear('donation_date', now()->year)
            ->sum('amount');
        $totalGivenFamilies = Donation::where('mosque_id', $user->mosque_id)
            ->where('transaction_type', 'given')
            ->distinct('family_id')
            ->whereNotNull('family_id')
            ->count('family_id');
        $averageGivenDonation = $totalGivenFamilies > 0 ? round($totalGivenDonations / $totalGivenFamilies, 0) : 0;

        $families = Family::where('mosque_id', $user->mosque_id)
            ->where('is_active', true)
            ->orderBy('family_head_name')
            ->get();

        return view('livewire.mosque.donations', [
            'donations' => $donations,
            'families' => $families,
            'totalReceivedDonations' => $totalReceivedDonations,
            'thisMonthReceivedDonations' => $thisMonthReceivedDonations,
            'totalReceivedDonors' => $totalReceivedDonors,
            'averageReceivedDonation' => $averageReceivedDonation,
            'totalGivenDonations' => $totalGivenDonations,
            'thisMonthGivenDonations' => $thisMonthGivenDonations,
            'totalGivenFamilies' => $totalGivenFamilies,
            'averageGivenDonation' => $averageGivenDonation,
        ]);
    }
}
