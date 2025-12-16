<?php

namespace App\Http\Controllers;

use App\Models\Schedule_Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'doctor_id'=>'required|exists:doctors,id',
                'days_week'=>'required|integer|min:0|max:6',
                'houra_begin'=>'required',
                'houra_finsih'=>'required'
            ]);
            $schedule = Schedule_Doctor::create($data);
            return response()->json($schedule,201);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function delete($id){
        try {
            $data = Schedule_Doctor::findOrFail($id);
            $data->delete();
            return response()->json(['message'=>'Operation completed'],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
}
