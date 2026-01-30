<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patients;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(){
        try {
            $appointment = Appointment::with(['schedule.doctor.user','patient.user'])->get();
            return response()->json($appointment,200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    //search appointment by patient name
    public function patientAppointmentSearch($name) {
        try {
            $patient = $name;
            $appointments = Appointment::with(['patient.user'])
                    ->whereHas('patient.user',function ($query) use ($name) {
                        $query->where('name','LIKE',"%{$name}%");
                                    })->get();
                return response()->json($appointments,200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()]);
        }
    }

    public function store(Request $request){
        try {
            $data = $request->validate([
                'schedule_id' => 'required|exists:schedules,id',
                'patient_id'=>'required|exists:patients,id',
                'data'=>'required|date',
                'houra'=>'required',
                'status' => 'required|string',
            ]);

            // verfica se existe um medico com consulta
            $exists = Appointment::where('houra',$data['houra'])
                    ->exists();
                if($exists){
                    return response()->json([
                        'message'=>'Medico já possui consulta neste horário'
                    ],422);
                }
            $appointment = Appointment::create($data);
            return response()->json($appointment->load(['schedule.doctor.user','patient.user']),201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }



    public function show($id){
        try {
            $data = Appointment::with(['patient.user','invoice','schedule.doctor.user'])->findOrFail($id);
            return response()->json($data,200);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $data = Appointment::findOrFail($id);
            $data->update($request->all());
            return response()->json($data->load(['schedule','patient']),200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function delete($id){
        try {
            $data = Appointment::findOrFail($id);
            $data->delete();
            return response()->json(['message'=>'Appointment deleted']);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()],400);
        }
    }
}
