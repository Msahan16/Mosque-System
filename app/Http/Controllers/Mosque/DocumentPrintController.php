<?php

namespace App\Http\Controllers\Mosque;

use App\Http\Controllers\Controller;
use App\Models\MosqueDocument;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class DocumentPrintController extends Controller
{
    public function print(MosqueDocument $document)
    {
        // Ensure the document belongs to the user's mosque
        if ($document->mosque_id !== auth()->user()->mosque_id) {
            abort(403);
        }

        $document->load('mosque');
        
        // Fetch signatory details
        $signatories = User::whereIn('id', $document->signatory_ids ?? [])->get();

        // Prepare some placeholders
        $replacements = [
            '{name}' => $document->recipient_name,
            '{date}' => $document->document_date->format('d M Y'),
            '{ref}' => $document->reference_no,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $document->content);
        $content = nl2br($content);

        $viewData = [
            'document' => $document,
            'signatories' => $signatories,
            'content' => $content,
            'autoprint' => request('autoprint') == 1,
            'download' => request('download') == 1,
        ];

        if (request('download') == 1) {
            $pdf = PDF::loadView('mosque.documents.download', $viewData)
                ->setPaper('a4', 'portrait')
                ->setWarnings(false);
            
            // Enabled remote images for the logo
            $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
            
            $filename = str_replace([' ', '/'], '_', $document->title . '_' . $document->reference_no) . '.pdf';
            return $pdf->download($filename);
        }

        return view('mosque.documents.print', $viewData);
    }
}
