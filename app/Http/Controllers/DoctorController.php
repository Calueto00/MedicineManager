<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        try {
            $doctor = Doctor::with('user')->orderByDesc('created_at')->get();
            return response()->json($doctor,200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
    public function appointment(){
        try {
            $data = Appointment::where('schedule_id','!=',null)
                    ->with('schedule.doctor.user')->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th->getMessage()], 200);
        }
    }

    public function show($id)
    {
        try {
            $data = Doctor::with([
                'appointments.patient.user',
                'appointments',
                'schedules'
            ])->findOrFail($id);
            return response()->json([
                'doctor'=>$data->load('user'),

            ],200);
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function searchName($name){
        $data = Doctor::with('user')->whereHas('user', function($query) use ($name){
            $query->where('name','like',"%{$name}%");
        })->get();

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name'=>'required|string|min:3',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|string',
                'especiality'=>'required|string|min:3',
                'c'=>'nullable|string|min:3',
                'bio'=>'nullable|string|min:3'
            ]);
            $user = User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password']),
                'role' => 'doctor'
            ]);
            $user->doctor()->create([
                'user_id'=>$user->id,
                'especiality'=>$data['especiality'],
                'crm'=>$data['crm'],
                'bio'=>$data['bio']
            ]);

            return response()->json([
                'message'=>'Doctor created successifully',
                'data'=> $user->load('doctor')
            ],201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            $data = $request->validate([
                'name'=>'same:name|required|string|min:3',
                'email'=>'same:email|required|unique:users,email,'.$id,
                'password'=>'same:password|required|string',
                'especiality'=>'same:especiality|required|string|min:3',
                'crm'=>'same:crm|nullable|string|min:3',
                'bio'=>'same:bio|string|nullable|min:3'
            ]);
            $user->update([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password'])
            ]);
            $user->doctor()->update([
                'user_id'=>$user->id,
                'especiality'=>$data['especiality'],
                'crm'=>$data['crm'],
                'bio'=>$data['bio']
            ]);

            return response()->json([
                'message'=>'Doctor updated successifully',
                'data'=>$user->load('doctor')
            ],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function delete($id){
        try {
            $data = User::findOrFail($id);
            $data->delete();
            return response()->json(['message'=>'Doctor deleted successifully'],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
}
