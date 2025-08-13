<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'institution_name',
        'academic_board',
        'qualification_type',
        'year_completed',
        'document_file_path',
    ];

    // Relation to Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
