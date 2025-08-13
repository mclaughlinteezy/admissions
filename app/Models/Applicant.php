<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'surname',
        'first_names',
        'gender',
        'national_id',
        'dob',
        'place_of_birth',
        'marital_status',
        'country_id',
        'phone_number',
        'address',
        'citizenship',
        'applicant_type',
        'application_mode',
    ];

    // Define relationship to country (assuming Country model exists)
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
