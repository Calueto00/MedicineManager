<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'day_weeks',
        'start_time',
        'end_time',
        'is_available'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
