<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date_houra',
        'status'
    ];

    public function patient(){
        return $this->belongsTo(Patients::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord(){
        return $this->hasOne(Medical_Record::class);
    }

    public function examRequest(){
        return $this->hasMany(Exam_Request::class);
    }
}
