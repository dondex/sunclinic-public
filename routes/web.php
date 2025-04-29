<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('profile/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'index']);
    Route::get('profile/edit/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'edit']);
    Route::put('profile/update/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'update']);

    Route::get('medical/{user_id}', [App\Http\Controllers\Frontend\MedicalRecordController::class, 'index']);

    Route::get('lab-result/{user_id}', [App\Http\Controllers\Frontend\LabResultController::class, 'index']);

    Route::get('department/{department_id}', [App\Http\Controllers\Frontend\SingleDeptController::class, 'index']);

    Route::get('my-appointment/{user_id}', [App\Http\Controllers\Frontend\MyAppointmentController::class, 'index']);

    Route::get('set-appointment/{user_id}', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'create']);
    Route::get('/doc-by-dept', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'doctorsByDepartment']);
    Route::post('set-appointment/{user_id}', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'store']);

    // New Ticket Routes for Frontend
    Route::get('ticket/{id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'show'])->name('ticket.show');
    Route::get('my-tickets/{user_id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'currentUser'])->name('ticket.user');
});

// Public Queue Display - accessible without authentication
Route::get('queue-display', [App\Http\Controllers\Frontend\TicketQueueController::class, 'displayQueue'])->name('queue.display');

Route::prefix('admin')->middleware('is_admin')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::get('department', [App\Http\Controllers\Admin\DepartmentController::class, 'index']);
    Route::get('add-department', [App\Http\Controllers\Admin\DepartmentController::class, 'create']);
    Route::post('add-department', [App\Http\Controllers\Admin\DepartmentController::class, 'store']);
    Route::get('edit-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'edit']);
    Route::put('update-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'update']);
    Route::get('delete-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'destroy']);

    
    Route::get('doctor', [App\Http\Controllers\Admin\DoctorController::class, 'index']);
    Route::get('add-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'create']);
    Route::post('add-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'store']);
    Route::get('edit-doctor/{doctor_id}', [App\Http\Controllers\Admin\DoctorController::class, 'edit']);
    Route::put('update-doctor/{doctor_id}',[App\Http\Controllers\Admin\DoctorController::class, 'update']);
    Route::get('delete-doctor/{doctor_id}',[App\Http\Controllers\Admin\DoctorController::class, 'destroy']);

    Route::get('patients', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('edit-patient/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put('update-patient/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
    

    Route::get('appointments', [App\Http\Controllers\Admin\AppointmentController::class, 'index']);
    Route::get('add-appointment', [App\Http\Controllers\Admin\AppointmentController::class, 'create']);
    Route::post('add-appointment', [App\Http\Controllers\Admin\AppointmentController::class, 'store']);
    Route::get('appointment/{appointment_id}', [App\Http\Controllers\Admin\AppointmentController::class, 'edit']);
    Route::put('update-appointment/{appointment_id}', [App\Http\Controllers\Admin\AppointmentController::class, 'update']);

    Route::get('/doctors-by-department', [App\Http\Controllers\Admin\AppointmentController::class, 'getDoctorsByDepartment']);

    
    Route::get('records', [App\Http\Controllers\Admin\RecordController::class, 'index']);
    Route::get('add-record', [App\Http\Controllers\Admin\RecordController::class, 'create']);
    Route::post('add-record', [App\Http\Controllers\Admin\RecordController::class, 'store']);
    Route::get('view-record/{record_id}', [App\Http\Controllers\Admin\RecordController::class, 'view']);
    Route::get('records/{record_id}/edit', [App\Http\Controllers\Admin\RecordController::class, 'edit']);
    Route::put('records/{record_id}', [App\Http\Controllers\Admin\RecordController::class, 'update']);
    Route::get('delete-record/{record_id}',[App\Http\Controllers\Admin\RecordController::class, 'destroy']);

});