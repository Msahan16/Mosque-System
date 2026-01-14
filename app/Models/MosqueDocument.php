<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueDocument extends Model
{
    protected $fillable = [
        'mosque_id',
        'title',
        'reference_no',
        'document_date',
        'recipient_name',
        'recipient_address',
        'recipient_id_no',
        'language',
        'content',
        'template_type',
        'signatory_ids',
        'created_by',
    ];

    protected $casts = [
        'document_date' => 'date',
        'signatory_ids' => 'array',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
