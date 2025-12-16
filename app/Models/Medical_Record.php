<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_Record extends Model
{
    /** @use HasFactory<\Database\Factories\MedicalRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'sintomas',
        'diagnostic',
        'prescription',
        'observation'
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
}
