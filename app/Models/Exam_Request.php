<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_Request extends Model
{
    /** @use HasFactory<\Database\Factories\ExamRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'appointment',
        'exam_type',
        'archive'
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
}
