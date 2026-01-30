<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        try {
            $doctors = Doctor::with(['user','invoice'])->get();
            $invoice = Invoice::with('patient.user')->get();

            return response()->json([
                'doctor'=> $doctors,
                'invoice'=> $invoice
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=> 'Error getting data'
            ],400);
        }
    }
    public function store(Request $request, Appointment $appointment){

    //just for concluded appointments
        if($appointment->status !== 'concluded'){
            return response()->json([
                'error' => 'Appointment was not concluded'
            ],403);
        }

        //avoid duplicated appointment
        if($appointment->invoice){
            return response()->json([
                'error' => 'This appointment already has an invoice'
            ],409);
        }

        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,mobile_money',
        ]);

        $invoice = Invoice::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->schedule->doctor_id,
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'status' => 'paid',
        ]);

        return response()->json($invoice, 201);
    }

    public function generate($invoiceId){

        $invoice = Invoice::with(['appointment','doctor.user','patient.user'])
        ->findOrFail($invoiceId);
        if($invoice->status != 'paid') {
            abort(403, 'Payment not confirmed.');
        }
        //carregar relacionamento
        $pdf = Pdf::loadView('pdf.invoice',compact('invoice'))->setPaper('A4','portrait');

        //stream envia para navegador
        return $pdf->stream('recibo-consulta'.$invoice->id.'.pdf');
    }
}
