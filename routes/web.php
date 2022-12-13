<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/all-patients', [PatientController::class, 'listing'])->name('listing');
Route::get('/all-patients-ajax', [PatientController::class, 'getPatients'])->name('getPatients');


Route::get('/add-patients/{id?}', [PatientController::class, 'addPatient'])->name('addPatient');
Route::post('/action-patients', [PatientController::class, 'insertPatient'])->name('insertPatient');
Route::get('/destroy-patients/{id}', [PatientController::class, 'destroyPatient'])->name('destroyPatient');

//Route::post('/destroy-patientsdocuments/{id}', [PatientController::class, 'deletePatientDocument'])->name('deletePatientDocument');