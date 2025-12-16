<?php

namespace App\Http\Controllers;

use App\Models\Medical_Record;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'appointment_id'=>'required|exists:appointments,id',
                'sintomas'=>'nullable|string',
                'diagnostic'=>'nullable|string',
                'prescription'=>'nullable|string',
                'observation'=>'nullable|string'
            ]);
            $record = Medical_Record::create($data);
            return response()->json($record,201);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);;
        }
    }

    public function delete($id){
        try {
            $data = Medical_Record::findOrFail($id);
            $data->delete();
            return response()->json(['message'=>'Operation completed'],200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
}
