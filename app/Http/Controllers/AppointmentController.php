<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(){
        try {
            $appointment = Appointment::with(['doctor.user','patient.user'])->get();
            return response()->json($appointment,200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function store(Request $request){
        try {
            $data = $request->validate([
                'patient_id'=>'required|exists:patients,id',
                'doctor_id'=>'required|exists:doctors,id',
                'date_houra'=>'required|date'
            ]);

            // verfica se existe um medico com consulta
            $exists = Appointment::where('doctor_id',$data['doctor_id'])
                    ->where('date_houra',$data['date_houra'])->exists();
                if($exists){
                    return response()->json([
                        'message'=>'Medico já possui consulta neste horário'
                    ],422);
                }
            $appointment = Appointment::create($data);
            return response()->json($appointment->load(['doctor.user','patient.user']),201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function show($id){
        try {
            $data = Appointment::findOrFail($id);
            return response()->json($data->load(['medicalRecord','examRequest']),200);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $data = Appointment::findOrFail($id);
            $data->update($request->all());
            return response()->json($data->load(['doctor','patient']),200);
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
