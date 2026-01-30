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
        return $this->belongsTo(Patients::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class,'schedule_id');
    }

    public function exams(){
        return $this->hasMany(Exam_Request::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }


}
