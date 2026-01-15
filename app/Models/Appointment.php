<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'patient_id',
        'data',
        'houra',
        'status'
    ];

    public function patient(){
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class,'schedule_id');
    }
}
