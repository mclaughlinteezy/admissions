<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'payment_type',
        'amount',
        'reference',
        'payment_date',
        'verified',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'verified' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
