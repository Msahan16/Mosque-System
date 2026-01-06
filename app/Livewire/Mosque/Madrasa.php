<?php

namespace App\Livewire\Mosque;

use App\Models\Ustad;
use App\Models\Student;
use App\Models\StudentPayment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Madrasa extends Component
{
    use WithPagination;

    // Event listeners for delete confirmations
    protected $listeners = [
        'deleteUstad' => 'deleteUstad',
        'deleteStudent' => 'deleteStudent',
        'deletePayment' => 'deletePayment'
    ];

    // Active tab
    public $activeTab = 'ustads';

    // Search
    public $search = '';

    // Ustad management
    public $showUstadModal = false;
    public $editUstadMode = false;
    public $viewUstadMode = false;
    public $ustadId;
    public $ustad_name, $ustad_phone, $ustad_email, $ustad_address;
    public $ustad_specialization, $ustad_experience_years, $ustad_qualification;
    public $ustad_salary, $ustad_joining_date, $ustad_notes, $ustad_is_active = true;

    // Student management
    public $showStudentModal = false;
    public $editStudentMode = false;
    public $studentId;
    public $student_name, $student_date_of_birth, $student_gender;
    public $student_parent_name, $student_parent_phone, $student_address;
    public $student_enrollment_date, $student_class_level = 'Beginner';
    public $student_ustad_id, $student_notes, $student_is_active = true;

    // Payment management
    public $showPaymentModal = false;
    public $payment_student_id, $payment_amount, $payment_date;
    public $payment_method = 'Cash', $payment_transaction_id;
    public $payment_type = 'Monthly Fee', $payment_notes;
    public $payment_months = [], $payment_year;

    protected function ustadRules()
    {
        return [
            'ustad_name' => 'required|string|max:255',
            'ustad_phone' => 'nullable|string|max:20',
            'ustad_email' => 'nullable|email|max:255',
            'ustad_address' => 'nullable|string',
            'ustad_specialization' => 'nullable|string|max:255',
            'ustad_experience_years' => 'nullable|integer|min:0',
            'ustad_qualification' => 'nullable|string|max:255',
            'ustad_salary' => 'nullable|numeric|min:0',
            'ustad_joining_date' => 'required|date',
            'ustad_notes' => 'nullable|string',
            'ustad_is_active' => 'boolean',
        ];
    }

    protected function studentRules()
    {
        return [
            'student_name' => 'required|string|max:255',
            'student_date_of_birth' => 'nullable|date|before:today',
            'student_gender' => 'required|in:Male,Female,Other',
            'student_parent_name' => 'nullable|string|max:255',
            'student_parent_phone' => 'nullable|string|max:20',
            'student_address' => 'nullable|string',
            'student_enrollment_date' => 'required|date',
            'student_class_level' => 'required|in:Beginner,Intermediate,Advanced',
            'student_ustad_id' => 'nullable|exists:ustads,id',
            'student_notes' => 'nullable|string',
            'student_is_active' => 'boolean',
        ];
    }

    protected function paymentRules()
    {
        return [
            'payment_student_id' => 'required|exists:students,id',
            'payment_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,Online,Other',
            'payment_transaction_id' => 'nullable|string|max:255',
            'payment_type' => 'required|in:Monthly Fee,Registration,Books,Other',
            'payment_months' => 'nullable|array',
            'payment_months.*' => 'integer|between:1,12',
            'payment_year' => 'nullable|integer|min:2025|max:2027',
            'payment_notes' => 'nullable|string',
        ];
    }

    // Ustad methods
    public function openUstadModal()
    {
        $this->resetUstadForm();
        $this->ustad_joining_date = today()->format('Y-m-d');
        $this->showUstadModal = true;
    }

    public function closeUstadModal()
    {
        $this->showUstadModal = false;
        $this->resetUstadForm();
    }

    public function editUstad($id)
    {
        $ustad = Ustad::findOrFail($id);
        $this->ustadId = $ustad->id;
        $this->ustad_name = $ustad->name;
        $this->ustad_phone = $ustad->phone;
        $this->ustad_email = $ustad->email;
        $this->ustad_address = $ustad->address;
        $this->ustad_specialization = $ustad->specialization;
        $this->ustad_experience_years = $ustad->experience_years;
        $this->ustad_qualification = $ustad->qualification;
        $this->ustad_salary = $ustad->salary;
        $this->ustad_joining_date = $ustad->joining_date->format('Y-m-d');
        $this->ustad_notes = $ustad->notes;
        $this->ustad_is_active = $ustad->is_active;

        $this->editUstadMode = true;
        $this->showUstadModal = true;
    }

    public function viewUstad($id)
    {
        $ustad = Ustad::findOrFail($id);
        $this->ustadId = $ustad->id;
        $this->ustad_name = $ustad->name;
        $this->ustad_phone = $ustad->phone;
        $this->ustad_email = $ustad->email;
        $this->ustad_address = $ustad->address;
        $this->ustad_specialization = $ustad->specialization;
        $this->ustad_experience_years = $ustad->experience_years;
        $this->ustad_qualification = $ustad->qualification;
        $this->ustad_salary = $ustad->salary;
        $this->ustad_joining_date = $ustad->joining_date->format('Y-m-d');
        $this->ustad_notes = $ustad->notes;
        $this->ustad_is_active = $ustad->is_active;

        $this->viewUstadMode = true;
        $this->showUstadModal = true;
    }

    public function saveUstad()
    {
        $this->validate($this->ustadRules());

        try {
            $data = [
                'mosque_id' => Auth::user()->mosque_id,
                'name' => $this->ustad_name,
                'phone' => $this->ustad_phone,
                'email' => $this->ustad_email,
                'address' => $this->ustad_address,
                'specialization' => $this->ustad_specialization,
                'experience_years' => $this->ustad_experience_years,
                'qualification' => $this->ustad_qualification,
                'salary' => $this->ustad_salary,
                'joining_date' => $this->ustad_joining_date,
                'notes' => $this->ustad_notes,
                'is_active' => $this->ustad_is_active,
            ];

            if ($this->editUstadMode) {
                Ustad::findOrFail($this->ustadId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Ustad updated successfully');
            } else {
                Ustad::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Ustad added successfully');
            }

            $this->closeUstadModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteUstad($id)
    {
        try {
            Ustad::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Ustad deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Student methods
    public function openStudentModal()
    {
        $this->resetStudentForm();
        $this->student_enrollment_date = today()->format('Y-m-d');
        $this->showStudentModal = true;
    }

    public function closeStudentModal()
    {
        $this->showStudentModal = false;
        $this->resetStudentForm();
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $this->studentId = $student->id;
        $this->student_name = $student->name;
        $this->student_date_of_birth = $student->date_of_birth?->format('Y-m-d');
        $this->student_gender = $student->gender;
        $this->student_parent_name = $student->parent_name;
        $this->student_parent_phone = $student->parent_phone;
        $this->student_address = $student->address;
        $this->student_enrollment_date = $student->enrollment_date->format('Y-m-d');
        $this->student_class_level = $student->class_level;
        $this->student_ustad_id = $student->ustad_id;
        $this->student_notes = $student->notes;
        $this->student_is_active = $student->is_active;

        $this->editStudentMode = true;
        $this->showStudentModal = true;
    }

    public function saveStudent()
    {
        $this->validate($this->studentRules());

        try {
            $data = [
                'mosque_id' => Auth::user()->mosque_id,
                'name' => $this->student_name,
                'date_of_birth' => $this->student_date_of_birth,
                'gender' => $this->student_gender,
                'parent_name' => $this->student_parent_name,
                'parent_phone' => $this->student_parent_phone,
                'address' => $this->student_address,
                'enrollment_date' => $this->student_enrollment_date,
                'class_level' => $this->student_class_level,
                'ustad_id' => $this->student_ustad_id,
                'notes' => $this->student_notes,
                'is_active' => $this->student_is_active,
            ];

            if ($this->editStudentMode) {
                Student::findOrFail($this->studentId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Student updated successfully');
            } else {
                Student::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Student added successfully');
            }

            $this->closeStudentModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteStudent($id)
    {
        try {
            Student::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Student deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Payment methods
    public function openPaymentModal($studentId = null)
    {
        $this->resetPaymentForm();
        $this->payment_student_id = $studentId;
        $this->payment_date = today()->format('Y-m-d');
        $this->payment_year = date('Y');
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->resetPaymentForm();
    }

    public function savePayment()
    {
        $this->validate($this->paymentRules());

        try {
            StudentPayment::create([
                'student_id' => $this->payment_student_id,
                'mosque_id' => Auth::user()->mosque_id,
                'amount' => $this->payment_amount,
                'payment_date' => $this->payment_date,
                'payment_method' => $this->payment_method,
                'transaction_id' => $this->payment_transaction_id,
                'payment_type' => $this->payment_type,
                'payment_months' => $this->payment_months,
                'payment_year' => $this->payment_year,
                'notes' => $this->payment_notes,
            ]);

            $this->dispatch('swal:success', title: 'Success', text: 'Payment recorded successfully');
            $this->closePaymentModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deletePayment($id)
    {
        try {
            StudentPayment::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Payment deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    // Tab switching
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // Reset methods
    private function resetUstadForm()
    {
        $this->reset([
            'ustadId', 'ustad_name', 'ustad_phone', 'ustad_email', 'ustad_address',
            'ustad_specialization', 'ustad_experience_years', 'ustad_qualification',
            'ustad_salary', 'ustad_joining_date', 'ustad_notes', 'editUstadMode', 'viewUstadMode'
        ]);
        $this->ustad_is_active = true;
    }

    private function resetStudentForm()
    {
        $this->reset([
            'studentId', 'student_name', 'student_date_of_birth', 'student_gender',
            'student_parent_name', 'student_parent_phone', 'student_address',
            'student_enrollment_date', 'student_class_level', 'student_ustad_id',
            'student_notes', 'editStudentMode'
        ]);
        $this->student_is_active = true;
    }

    private function resetPaymentForm()
    {
        $this->reset([
            'payment_student_id', 'payment_amount', 'payment_date', 'payment_method',
            'payment_transaction_id', 'payment_type', 'payment_notes', 'payment_months', 'payment_year'
        ]);
    }

    public function render()
    {
        $mosqueId = Auth::user()->mosque_id;

        $ustads = Ustad::where('mosque_id', $mosqueId)
            ->when($this->search && $this->activeTab === 'ustads', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('specialization', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10, ['*'], 'ustads_page');

        $students = Student::where('mosque_id', $mosqueId)
            ->with('ustad')
            ->when($this->search && $this->activeTab === 'students', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('parent_name', 'like', '%' . $this->search . '%')
                      ->orWhere('parent_phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10, ['*'], 'students_page');

        $payments = StudentPayment::where('mosque_id', $mosqueId)
            ->with(['student'])
            ->when($this->search && $this->activeTab === 'payments', function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'payments_page');

        $availableUstads = Ustad::where('mosque_id', $mosqueId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.mosque.madrasa', [
            'ustads' => $ustads,
            'students' => $students,
            'payments' => $payments,
            'availableUstads' => $availableUstads,
        ]);
    }
}
