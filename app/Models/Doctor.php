<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'especiality',
        'crm',
        'bio'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function appointments(){
        return $this->hasManyThrough(
            Appointment::class,
            Schedule::class,
            'doctor_id',
            'schedule_id',
            'id',
            'id'
        );
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }


}
