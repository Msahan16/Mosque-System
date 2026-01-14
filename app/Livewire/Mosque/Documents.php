<?php

namespace App\Livewire\Mosque;

use App\Models\MosqueDocument;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Documents extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showPreview = false;
    public $showPrintModal = false;
    public $editMode = false;
    public $documentId;
    public $printingDocumentId;
    public $mosqueId;

    // Form fields
    public $title;
    public $reference_no;
    public $document_date;
    public $recipient_name;
    public $recipient_address;
    public $recipient_id_no;
    public $language = 'en';
    public $content;
    public $template_type = 'classic';
    public $selectedSignatories = [];

    public $contentTemplates = [
        'identity' => "TO WHOM IT MAY CONCERN,\n\nThis is to certify that Mr./Ms. {name} (NIC: {recipient_id}) is a regular congregant of our mosque. To the best of our knowledge, he/she is a person of good character and is known to our community.\n\nThis certificate is issued at the request of the above person for identification purposes.\n\nYours faithfully,",
        'marriage' => "CERTIFICATE OF MARRIAGE\n\nThis is to certify that the marriage between {name} and [SPOUSE NAME] was solemnized on [DATE] at [MOSQUE NAME] according to Islamic rites.\n\nWitnesses:\n1. [WITNESS 1]\n2. [WITNESS 2]\n\nRegistrar Signature:",
        'travel' => "TRAVEL AUTHORIZATION\n\nWe hereby confirm that {name} is authorized to represent our mosque for [PURPOSE] during the period [DATES]. We request all relevant authorities to provide necessary assistance.\n\nReference: {ref}",
    ];

    public function applyTemplate($type)
    {
        if (isset($this->contentTemplates[$type])) {
            $content = $this->contentTemplates[$type];
            $this->content = str_replace(
                ['{name}', '{recipient_id}', '{ref}'], 
                [$this->recipient_name ?? '[NAME]', $this->recipient_id_no ?? '[ID]', $this->reference_no], 
                $content
            );
        }
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'reference_no' => 'required|string|max:100',
        'document_date' => 'required|date',
        'recipient_name' => 'required|string|max:255',
        'recipient_address' => 'nullable|string',
        'recipient_id_no' => 'nullable|string|max:100',
        'language' => 'required|in:en,si,ta',
        'content' => 'required|string',
        'template_type' => 'required|in:classic,modern,sidebar',
        'selectedSignatories' => 'required|array|min:1',
    ];

    public function mount()
    {
        $this->mosqueId = Auth::user()->mosque_id;
        $this->document_date = date('Y-m-d');
        if (!$this->reference_no) {
            $this->generateReferenceNo();
        }
    }

    public function generateReferenceNo()
    {
        $count = MosqueDocument::where('mosque_id', $this->mosqueId)->count() + 1;
        $year = date('Y');
        $this->reference_no = "MSQ/{$this->mosqueId}/{$year}/" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->generateReferenceNo();
        $this->showModal = true;
    }

    public function openPreview()
    {
        $this->validate();
        $this->showPreview = true;
    }

    public function closePreview()
    {
        $this->showPreview = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'documentId', 'title', 'reference_no', 'recipient_name', 
            'recipient_address', 'recipient_id_no', 'language', 
            'content', 'template_type', 'selectedSignatories'
        ]);
        $this->document_date = date('Y-m-d');
        $this->editMode = false;
        $this->showPreview = false;
    }

    public function createDocument()
    {
        $this->validate();

        MosqueDocument::create([
            'mosque_id' => $this->mosqueId,
            'title' => $this->title,
            'reference_no' => $this->reference_no,
            'document_date' => $this->document_date,
            'recipient_name' => $this->recipient_name,
            'recipient_address' => $this->recipient_address,
            'recipient_id_no' => $this->recipient_id_no,
            'language' => $this->language,
            'content' => $this->content,
            'template_type' => $this->template_type,
            'signatory_ids' => $this->selectedSignatories,
            'created_by' => Auth::id(),
        ]);

        $this->dispatch('swal:success', title: 'Success', text: 'Document generated successfully!');
        $this->closeModal();
    }

    public function editDocument($id)
    {
        $doc = MosqueDocument::findOrFail($id);
        $this->documentId = $doc->id;
        $this->title = $doc->title;
        $this->reference_no = $doc->reference_no;
        $this->document_date = $doc->document_date->format('Y-m-d');
        $this->recipient_name = $doc->recipient_name;
        $this->recipient_address = $doc->recipient_address;
        $this->recipient_id_no = $doc->recipient_id_no;
        $this->language = $doc->language;
        $this->content = $doc->content;
        $this->template_type = $doc->template_type;
        $this->selectedSignatories = $doc->signatory_ids;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateDocument()
    {
        $this->validate();

        $doc = MosqueDocument::findOrFail($this->documentId);
        $doc->update([
            'title' => $this->title,
            'reference_no' => $this->reference_no,
            'document_date' => $this->document_date,
            'recipient_name' => $this->recipient_name,
            'recipient_address' => $this->recipient_address,
            'recipient_id_no' => $this->recipient_id_no,
            'language' => $this->language,
            'content' => $this->content,
            'template_type' => $this->template_type,
            'signatory_ids' => $this->selectedSignatories,
        ]);

        $this->dispatch('swal:success', title: 'Success', text: 'Document updated successfully!');
        $this->closeModal();
    }

    public function deleteDocument($id)
    {
        MosqueDocument::findOrFail($id)->delete();
        $this->dispatch('swal:success', title: 'Deleted', text: 'Document removed successfully!');
    }

    public function openPrintModal($id)
    {
        $this->printingDocumentId = $id;
        $this->showPrintModal = true;
    }

    public function closePrintModal()
    {
        $this->showPrintModal = false;
        $this->printingDocumentId = null;
    }

    public function translateContent($targetLanguage)
    {
        if (empty($this->content)) {
            $this->dispatch('swal:error', title: 'Error', text: 'Please enter some content first.');
            return;
        }

        try {
            $tr = new GoogleTranslate();
            $tr->setTarget($targetLanguage);
            
            // Translate the content
            $translated = $tr->translate($this->content);
            
            if ($translated) {
                $this->content = $translated;
                $this->language = $targetLanguage;
                $this->dispatch('swal:success', title: 'Translated', text: 'Content translated' . ($targetLanguage == 'ta' ? ' to Tamil' : ' to Sinhala') . ' successfully!');
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:error', title: 'Translation Error', text: 'Could not translate at this moment.');
        }
    }

    public function render()
    {
        $documents = MosqueDocument::where('mosque_id', $this->mosqueId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $signatories = User::where('mosque_id', $this->mosqueId)
            ->where(function($query) {
                $query->where('role', 'staff')
                      ->orWhere('role', 'mosque');
            })
            ->where('is_active', true)
            ->get();

        return view('livewire.mosque.documents', [
            'documents' => $documents,
            'signatories' => $signatories,
            'mosque' => Auth::user()->mosque,
        ]);
    }
}
