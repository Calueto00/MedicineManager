<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class PatientController extends Controller
{
    public function index()
    {
        try {
            $patients = Patients::with('user')->get();
            return response()->json($patients, 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],401);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name'=>'required|string|min:3',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|string',
                'birth'=>'nullable|date',
                'phone'=>'required|max:10',
                'address'=>'nullable|string',
            ]);

            $user = User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=> Hash::make($data['password']),
            ]);

            $user->patient()->create([
                'user_id'=>$user->id,
                'birth'=>$data['birth'],
                'phone'=>$data['phone'],
                'address'=>$data['address'],
            ]);

            return response()->json([
                'data'=>$user,
                'message'=>'Patient created successfuly'
            ],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()],401);
        }
    }

    public function show(Patients $patients){
        try {
            return response()->json($patients->load('user'), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()],401);
        }
    }

    public function update(Request $request, $id){
        try {
                $user = User::findOrFail($id);
                $data = $request->validate([
                    'name'=>'same:name|required|string|min:3',
                    'email'=>'same:email|required|email|unique:users,email,'.$id,
                    'password'=>'same:password|string',
                    'birth'=>'same:birth|nullable|date',
                    'phone'=>'same:phone|required|max:10',
                    'address'=>'same:address|required|string'
                ]);
                $user->update([
                    'name'=>$data['name'],
                    'email'=>$data['email'],
                    'password'=>Hash::make($data['password'])
                ]);
                $user->patient()->update([
                    'user_id'=>$id,
                    'birth'=>$data['birth'],
                    'phone'=>$data['phone'],
                    'address'=>$data['address']
                ]);

                return response()->json([
                    'message'=>'User updated successfuly',
                    'data'=>$user->load('patient')
                ],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    public function delete($id){
        try {
            $user = Patients::findOrFail($id);
            $user->delete();
            return response()->json(['message'=>'user deleted successifully'],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
}
