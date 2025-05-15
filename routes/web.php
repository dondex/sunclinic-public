<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\TicketQueueController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('profile/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'index']);
    Route::get('profile/edit/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'edit']);
    Route::put('profile/update/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'update']);
    Route::post('profile/add/{user_id}', [App\Http\Controllers\Frontend\ProfileController::class, 'store']);

    Route::get('medical/{user_id}', [App\Http\Controllers\Frontend\MedicalRecordController::class, 'index']);
    Route::get('lab-result/{user_id}', [App\Http\Controllers\Frontend\LabResultController::class, 'index']);

    Route::get('department/{department_id}', [App\Http\Controllers\Frontend\SingleDeptController::class, 'index']);
    Route::get('my-appointment/{user_id}', [App\Http\Controllers\Frontend\MyAppointmentController::class, 'index']);

    Route::get('set-appointment/{user_id}', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'create']);
    Route::get('/doc-by-dept', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'doctorsByDepartment']);
    Route::post('set-appointment/{user_id}', [App\Http\Controllers\Frontend\SetAppointmentController::class, 'store']);

    // Ticket Routes
    Route::get('ticket/{id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'show'])->name('ticket.show');
    Route::get('my-tickets/{user_id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'currentUser'])->name('ticket.user');
    Route::get('check-ticket-status/{id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'checkStatus'])->name('ticket.check-status');
    Route::get('tickets/restart', [App\Http\Controllers\Frontend\TicketQueueController::class, 'restart'])->name('tickets.restart');
    Route::get('tickets/show/{id}', [App\Http\Controllers\Frontend\TicketQueueController::class, 'showSpecific'])->name('tickets.show-specific');
});

// Public Queue Display
Route::get('queue-display', [App\Http\Controllers\Frontend\TicketQueueController::class, 'displayQueue'])->name('queue.display');

// About & Departments
Route::get('about', [App\Http\Controllers\Frontend\AboutController::class, 'index']);
Route::get('all-department', [App\Http\Controllers\Frontend\AllDepartmentController::class, 'index']);

// Monitor Routes
Route::middleware(['auth', 'is_monitor'])->group(function () {
    Route::get('/monitor', [App\Http\Controllers\MonitorController::class, 'index'])->name('monitor.dashboard');
    Route::get('/monitor/current-ticket', [App\Http\Controllers\MonitorController::class, 'currentTicket'])->name('monitor.current');
});

// Admin Routes
Route::prefix('admin')->middleware(['web', 'is_admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Department
    Route::get('department', [App\Http\Controllers\Admin\DepartmentController::class, 'index']);
    Route::get('add-department', [App\Http\Controllers\Admin\DepartmentController::class, 'create']);
    Route::post('add-department', [App\Http\Controllers\Admin\DepartmentController::class, 'store']);
    Route::get('edit-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'edit']);
    Route::put('update-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'update']);
    Route::get('delete-department/{department_id}', [App\Http\Controllers\Admin\DepartmentController::class, 'destroy']);

    // Doctor
    Route::get('doctor', [App\Http\Controllers\Admin\DoctorController::class, 'index']);
    Route::get('add-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'create']);
    Route::post('add-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'store']);
    Route::get('edit-doctor/{doctor_id}', [App\Http\Controllers\Admin\DoctorController::class, 'edit']);
    Route::put('update-doctor/{doctor_id}', [App\Http\Controllers\Admin\DoctorController::class, 'update']);
    Route::get('delete-doctor/{doctor_id}', [App\Http\Controllers\Admin\DoctorController::class, 'destroy']);

    // Patients
    Route::get('patients', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('edit-patient/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put('update-patient/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'update']);

    // Appointments
    Route::get('appointments', [App\Http\Controllers\Admin\AppointmentController::class, 'index']);
    Route::get('add-appointment', [App\Http\Controllers\Admin\AppointmentController::class, 'create']);
    Route::post('add-appointment', [App\Http\Controllers\Admin\AppointmentController::class, 'store']);
    Route::get('appointment/{appointment_id}', [App\Http\Controllers\Admin\AppointmentController::class, 'edit']);
    Route::put('update-appointment/{appointment_id}', [App\Http\Controllers\Admin\AppointmentController::class, 'update']);
    Route::get('/doctors-by-department', [App\Http\Controllers\Admin\AppointmentController::class, 'getDoctorsByDepartment']);

    // Walk-in
    Route::get('add-walkin', [App\Http\Controllers\Admin\WalkInController::class, 'create'])->name('admin.walkin.create');
    Route::post('add-walkin', [App\Http\Controllers\Admin\WalkInController::class, 'store'])->name('admin.walkin.store');
    Route::get('walkin/doctors', [App\Http\Controllers\Admin\WalkInController::class, 'doctorsByDepartment'])->name('admin.walkin.doctors');
    Route::get('walkin/ticket/{id}', [App\Http\Controllers\Admin\WalkInController::class, 'showTicket'])->name('admin.walkin.ticket');

    // Medical Records
    Route::get('records', [App\Http\Controllers\Admin\RecordController::class, 'index']);
    Route::get('add-record', [App\Http\Controllers\Admin\RecordController::class, 'create']);
    Route::post('add-record', [App\Http\Controllers\Admin\RecordController::class, 'store']);
    Route::get('view-record/{record_id}', [App\Http\Controllers\Admin\RecordController::class, 'view']);
    Route::get('records/{record_id}/edit', [App\Http\Controllers\Admin\RecordController::class, 'edit']);
    Route::put('records/{record_id}', [App\Http\Controllers\Admin\RecordController::class, 'update']);
    Route::get('delete-record/{record_id}', [App\Http\Controllers\Admin\RecordController::class, 'destroy']);

    // Ticket Queue Management
    Route::prefix('tickets')->group(function () {
        Route::get('/', [TicketQueueController::class, 'index'])->name('admin.tickets.index');
        Route::put('/next', [TicketQueueController::class, 'next'])->name('admin.tickets.next');
        Route::put('/previous', [TicketQueueController::class, 'previous'])->name('admin.tickets.previous');
        Route::get('/display', [TicketQueueController::class, 'display'])->name('admin.tickets.display');
        Route::get('/restart', [TicketQueueController::class, 'restart'])->name('admin.tickets.restart');
        Route::get('/show/{id}', [TicketQueueController::class, 'showSpecific'])->name('admin.tickets.show-specific');
        Route::get('/{id}', [TicketQueueController::class, 'show'])->name('admin.tickets.show');

        // Priority Queue Routes
        Route::post('/prioritize/{id}', [TicketQueueController::class, 'prioritize'])->name('admin.tickets.prioritize');
        Route::post('/remove-priority/{id}', [TicketQueueController::class, 'removePriority'])->name('admin.tickets.remove-priority');
        Route::get('/priority-display', [TicketQueueController::class, 'priorityDisplay'])->name('admin.tickets.priority-display');
        
        // Regular Queue Routes
        Route::get('/regular-display', [TicketQueueController::class, 'regularDisplay'])->name('admin.tickets.regular-display');
        Route::put('/priority-next', [TicketQueueController::class, 'priorityNext'])->name('admin.tickets.priority-next');
        Route::put('/priority-previous', [TicketQueueController::class, 'priorityPrevious'])->name('admin.tickets.priority-previous');
        Route::put('/regular-next', [TicketQueueController::class, 'regularNext'])->name('admin.tickets.regular-next');
        Route::put('/regular-previous', [TicketQueueController::class, 'regularPrevious'])->name('admin.tickets.regular-previous');
    });
});