<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'document_type',
        'file_path',
        'uploaded_at',
        'verified',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    // Relationship to Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
