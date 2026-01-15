<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(){
        try {
            $data = Schedule::with('doctor.user')
                    ->where('is_available',true)
                    ->orderBy('day_weeks')
                    ->orderBy('start_time')->get();
            if(!$data){
                return response()->json(['message'=>'No schedules found'],200);
            }
            return response()->json($data,200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()],400);
        }
    }

    public function scheduleByDoctor($id){
        try {
            $data  = Schedule::where('doctor_id',$id)
                    ->where('is_available',true)->get();
                return response()->json($data,200);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()],400);
        }
    }

    public function show(Request $request, $id){
        try {
            $query = Schedule::query();
            if($request->has('doctor_id')){
                $query->where('doctor_id', $request->doctor_id);
            }

            return response()->json($query->orderBy('day_weeks')->get(),200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()],400);
        }
    }

    public function store(Request $request){
        try {
            $validate = $request->validate([
                'doctor_id'=>'required|exists:doctors,id',
                'day_weeks'=>'required|integer|min:1|max:7',
                'start_time'=>'required|date_format:H:i',
                'end_time'=>'required|date_format:H:i|after:start_time'
            ]);

            $exists = Schedule::where('doctor_id',$validate['doctor_id'])
                    ->where('day_weeks',$validate['day_weeks'])
                    ->where('start_time',$validate['start_time'])
                    ->where('end_time',$validate['end_time'])->exists();

                    if($exists){
                        return response()->json(['message'=>'This DateTime already exist'],400);
                    }
                $schedule = Schedule::create($validate);
                return response()->json($schedule,201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()],400);
        }
    }
}
