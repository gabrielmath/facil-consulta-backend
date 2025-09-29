<?php

namespace App\Models;

use App\Models\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'time',
        'available',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'time' => TimeCast::class,
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
