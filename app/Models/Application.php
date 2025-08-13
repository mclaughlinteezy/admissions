<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'period_id',
        'ref_code',
        'application_type',
        'status_id',
        // add other fillable fields here
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
