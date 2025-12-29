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
    public $family_head_name, $family_head_profession, $phone, $email;
    public $address;
    public $total_members, $registration_date, $notes, $is_active = true;

    // Member fields
    public $members = [];
    public $memberName, $memberRelation, $memberDob, $memberGender;
    public $memberOccupation, $memberEducation, $memberPhone, $memberEmail;
    public $memberBloodGroup, $memberNotes;

    protected function familyRules()
    {
        return [
            'family_head_name' => 'required|string|max:255',
            'family_head_profession' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'total_members' => 'required|integer|min:1',
            'registration_date' => 'required|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
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
        $family = Family::findOrFail($id);
        $this->familyId = $family->id;
        $this->family_head_name = $family->family_head_name;
        $this->family_head_profession = $family->family_head_profession;
        $this->phone = $family->phone;
        $this->email = $family->email;
        $this->address = $family->address;
        $this->total_members = $family->total_members;
        $this->registration_date = $family->registration_date->format('Y-m-d');
        $this->notes = $family->notes;
        $this->is_active = $family->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveFamily()
    {
        $this->validate($this->familyRules());

        try {
            $data = [
                'mosque_id' => auth()->user()->mosque_id,
                'family_head_name' => $this->family_head_name,
                'family_head_profession' => $this->family_head_profession,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'total_members' => $this->total_members,
                'registration_date' => $this->registration_date,
                'notes' => $this->notes,
                'is_active' => $this->is_active,
            ];

            if ($this->editMode) {
                Family::findOrFail($this->familyId)->update($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Family updated successfully');
            } else {
                Family::create($data);
                $this->dispatch('swal:success', title: 'Success', text: 'Family registered successfully');
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
            'familyId', 'family_head_name', 'family_head_profession', 'phone', 'email',
            'address', 'total_members',
            'registration_date', 'notes', 'is_active', 'editMode'
        ]);
        $this->is_active = true;
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
