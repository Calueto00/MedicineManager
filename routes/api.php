<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExamRequestController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//===========================
// rotas de autenticação
//============================
Route::post('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    //====================================
    //Pacientes
    //=====================================
    Route::get('/patients',[PatientController::class, 'index']);
    Route::post('/patient',[PatientController::class, 'store']);
    Route::get('/patient/{id}',[PatientController::class, 'show']);
    Route::put('/patient/{id}',[PatientController::class, 'update']);
    Route::delete('/patient/{id}',[PatientController::class, 'delete']);
    Route::get('/patient/name/{name}',[PatientController::class, 'searchName']);

    //====================================
    //medicos
    //=====================================

    Route::get('/doctors',[DoctorController::class, 'index']);
    Route::post('/doctor',[DoctorController::class, 'store']);
    Route::get('/doctor/{id}',[DoctorController::class, 'show']);
    Route::put('/doctor/{id}',[DoctorController::class, 'update']);
    Route::delete('/doctor/{id}',[DoctorController::class, 'delete']);
    Route::get('/doctors_appointment',[DoctorController::class, 'appointment']);
    Route::get('/doctor/{id}/appointments',[DoctorController::class, 'doctorAppointment']);
    Route::get('/doctor/search/{name}',[DoctorController::class, 'searchName']);
    //====================================
    //horarário de medicos
    //=====================================
    Route::get('/schedules',[ScheduleController::class, 'index']);
    Route::get('/schedule/{id}',[ScheduleController::class, 'show']);
    Route::get('/schedule/doctor/{id}',[ScheduleController::class, 'scheduleByDoctor']);
    Route::post('/schedule',[ScheduleController::class, 'store']);
    Route::delete('/schedule/{id}',[ScheduleController::class, 'delete']);

    //====================================
    // consultas
    //=====================================

    Route::get('/appointments',[AppointmentController::class, 'index']);
    Route::get('/appointment/{id}',[AppointmentController::class, 'show']);
    Route::post('/appointment',[AppointmentController::class, 'store']);
    Route::put('/appointments/{id}',[AppointmentController::class, 'update']);
    Route::delete('/appointment/{id}',[AppointmentController::class, 'delete']);
    Route::get('/appointment/search/{name}',[AppointmentController::class, 'patientAppointmentSearch']);
    //====================================
    // prontuario medico
    //=====================================

    Route::post('/medical-record',[MedicalRecordController::class, 'store']);
    Route::put('/medical-record/{id}',[MedicalRecordController::class, 'update']);

    //====================================
    // pedido de exame
    //=====================================

    Route::post('/exam-request',[ExamRequestController::class, 'store']);

     //====================================
    //Invoice appointment
    //=====================================
    Route::post('/appointments/{appointment}/invoice',[InvoiceController::class, 'store']);
    Route::get('/appointments/invoice/{invoiceId}/pdf',[InvoiceController::class, 'generate']);
    Route::get('/invoices',[InvoiceController::class, 'index']);
});

