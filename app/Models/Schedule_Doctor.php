<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule_Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleDoctorFactory> */
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'days_week',
        'houra_begin',
        'houre_finish'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
