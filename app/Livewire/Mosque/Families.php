<?php

namespace App\Livewire\Mosque;

use App\Models\Family;
use App\Models\FamilyMember;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Families extends Component
{
    use WithPagination;

    protected $listeners = ['confirmDeleteFamily' => 'deleteFamily'];

    public $search = '';
    public $showModal = false;
    public $showMembersModal = false;
    public $editMode = false;
    public $familyId;
    public $selectedFamily;

    // Family fields
    public $family_id, $family_head_name, $family_head_profession, $phone, $email;
    public $address;
    public $total_members, $registration_date, $notes, $is_active = true, $family_income;

    // Member fields
    public $members = [];
    public $memberName, $memberRelation, $memberDob, $memberGender;
    public $memberOccupation, $memberPhone, $memberEmail;
    public $memberNotes, $memberEducation;

    protected function familyRules()
    {
        return [
            'family_id' => 'required|string|max:50|unique:families,family_id,' . ($this->familyId ?? 'NULL'),
            'family_head_name' => 'required|string|max:255',
            'family_head_profession' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'total_members' => 'required|integer|min:1',
            'registration_date' => 'required|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'family_income' => 'nullable|numeric|min:0',
        ];
    }

    protected function memberRules()
    {
        return [
            'memberName' => 'required|string|max:255',
            'memberRelation' => 'required|string|max:100',
            'memberDob' => 'nullable|date|before:today',
            'memberGender' => 'required|in:Male,Female,Other',
            'memberOccupation' => 'nullable|string|max:255',
            'memberEducation' => 'nullable|string|max:255',
            'memberPhone' => 'nullable|string|max:20',
            'memberEmail' => 'nullable|email|max:255',
            'memberNotes' => 'nullable|string',
        ];
    }

    public function addMember()
    {
        $this->validate($this->memberRules());

        // Validate that member data is not empty
        if (empty($this->memberName) || empty($this->memberRelation)) {
            $this->dispatch('swal:error', title: 'Validation Error', text: 'Name and Relation are required');
            return;
        }

        $this->members[] = [
            'name' => $this->memberName,
            'relation' => $this->memberRelation,
            'date_of_birth' => $this->memberDob,
            'gender' => $this->memberGender,
            'occupation' => $this->memberOccupation,
            'education' => $this->memberEducation,
            'phone' => $this->memberPhone,
            'email' => $this->memberEmail,
            'notes' => $this->memberNotes,
        ];

        // Reset member fields
        $this->reset([
            'memberName', 'memberRelation', 'memberDob', 'memberGender',
            'memberOccupation', 'memberEducation', 'memberPhone', 'memberEmail',
            'memberNotes'
        ]);

        $this->dispatch('swal:success', title: 'Success', text: 'Member added successfully');
    }

    public function removeMember($index)
    {
        unset($this->members[$index]);
        $this->members = array_values($this->members);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->registration_date = today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editFamily($id)
    {
        $family = Family::with('members')->findOrFail($id);
        $this->familyId = $family->id;
        $this->family_id = $family->family_id;
        $this->family_head_name = $family->family_head_name;
        $this->family_head_profession = $family->family_head_profession;
        $this->phone = $family->phone;
        $this->email = $family->email;
        $this->address = $family->address;
        $this->total_members = $family->total_members;
        $this->registration_date = $family->registration_date->format('Y-m-d');
        $this->notes = $family->notes;
        $this->is_active = $family->is_active;
        $this->family_income = $family->family_income;
        
        // Load existing members
        $this->members = $family->members->map(function($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'relation' => $member->relation,
                'date_of_birth' => $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : null,
                'gender' => $member->gender,
                'occupation' => $member->occupation,
                'education' => $member->education,
                'phone' => $member->phone,
                'email' => $member->email,
                'notes' => $member->notes,
            ];
        })->toArray();
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveFamily()
    {
        $this->validate($this->familyRules());

        try {
            $data = [
                'mosque_id' => auth()->user()->mosque_id,
                'family_id' => $this->family_id,
                'family_head_name' => $this->family_head_name,
                'family_head_profession' => $this->family_head_profession,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'total_members' => $this->total_members,
                'registration_date' => $this->registration_date,
                'notes' => $this->notes,
                'is_active' => $this->is_active,
                'family_income' => $this->family_income,
            ];

            if ($this->editMode) {
                $family = Family::findOrFail($this->familyId);
                $family->update($data);
                
                // Delete existing members and recreate
                $family->members()->delete();
                
                $this->dispatch('swal:success', title: 'Success', text: 'Family updated successfully');
            } else {
                $family = Family::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Family registered successfully');
            }

            // Save members
            // First, automatically add family head as a member
            FamilyMember::create([
                'family_id' => $family->id,
                'name' => $this->family_head_name,
                'relation' => 'Head',
                'date_of_birth' => null,
                'gender' => 'Male', // Default, can be updated separately
                'occupation' => $this->family_head_profession,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);

            // Then save any additional members
            foreach ($this->members as $memberData) {
                try {
                    FamilyMember::create([
                        'family_id' => $family->id,
                        'name' => $memberData['name'],
                        'relation' => $memberData['relation'],
                        'date_of_birth' => $memberData['date_of_birth'] ?? null,
                        'gender' => $memberData['gender'],
                        'occupation' => $memberData['occupation'] ?? null,
                        'education' => $memberData['education'] ?? null,
                        'phone' => $memberData['phone'] ?? null,
                        'email' => $memberData['email'] ?? null,
                        'notes' => $memberData['notes'] ?? null,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create family member: ' . $e->getMessage());
                    throw new \Exception('Failed to save member: ' . $memberData['name']);
                }
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function deleteFamily($id)
    {
        try {
            Family::findOrFail($id)->delete();
            $this->dispatch('swal:success', title: 'Success', text: 'Family deleted successfully');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Error', text: $e->getMessage());
        }
    }

    public function viewMembers($id)
    {
        $this->selectedFamily = Family::with('members')->findOrFail($id);
        $this->showMembersModal = true;
    }

    public function closeMembersModal()
    {
        $this->showMembersModal = false;
        $this->selectedFamily = null;
    }

    private function resetForm()
    {
        $this->reset([
            'familyId', 'family_id', 'family_head_name', 'family_head_profession', 'phone', 'email',
            'address', 'total_members',
            'registration_date', 'notes', 'is_active', 'editMode', 'members',
            'memberName', 'memberRelation', 'memberDob', 'memberGender',
            'memberOccupation', 'memberEducation', 'memberPhone', 'memberEmail',
            'memberNotes', 'family_income'
        ]);
        $this->is_active = true;
        $this->members = [];
    }

    public function render()
    {
        $families = Family::where('mosque_id', auth()->user()->mosque_id)
            ->when($this->search, function ($query) {
                $query->where('family_head_name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->with('members')
            ->latest()
            ->paginate(10);

        return view('livewire.mosque.families', [
            'families' => $families
        ]);
    }
}