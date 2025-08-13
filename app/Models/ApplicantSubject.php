<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_record_id',
        'subject_name',
        'grade',
    ];

    // Relation to ApplicantAcademicRecord
    public function academicRecord()
    {
        return $this->belongsTo(ApplicantAcademicRecord::class);
    }
}
