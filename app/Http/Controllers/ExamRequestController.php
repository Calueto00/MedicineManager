<?php

namespace App\Http\Controllers;

use App\Models\Exam_Request;
use Illuminate\Http\Request;

class ExamRequestController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'appointment'=>'required|exists:appointments,id',
                'exam_type'=>'required|string',
                'archive'=>'nullable|string'
            ]);

            Exam_Request::create($data);
            return response()->json(['message'=>'operation completed'],201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
}
