<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProgramme extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_id',
        'attendance_type_id',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class);
    }
}
