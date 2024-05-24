<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Functions;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QR;
use Illuminate\Support\Facades\Route;


//If authenticated, go to dashboard
Route::get('/', function (  ) {
    return view('auth.login');
});

//Admin
Route::middleware(['auth', 'admin'])->group(function () {
    //Employee
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('a-dash');
    Route::get('admin/employee', [AdminController::class, 'empIndex'])->name('a-employee');
    Route::post('admin/store', [AdminController::class, 'store'])->name('a-store');
    Route::get('admin/view', [AdminController::class, 'empView'])->name('a-view');
    Route::post('admin/username', [Functions::class, 'getUserName'])->name('username');
    Route::post('admin/{id}/username', [Functions::class, 'getUserName'])->name('username1');
    Route::get('admin/{id}/edit', [AdminController::class, 'edit'])->name('a-edit');
    Route::patch('admin/{id}/employee', [AdminController::class, 'update'])->name('a-update');
    Route::delete('admin/{id}', [AdminController::class, 'destroy'])->name('a-delete');
    Route::get('admin/{id}/qr', [Functions::class, 'QR'])->name('a-qr');

    //Payroll
    Route::get('admin/payroll', [AdminController::class, 'payView'])->name('a-payroll');
    Route::get('admin/all', [AdminController::class, 'payrollAll'])->name('a-all');
    Route::get('admin/{id}/payroll', [AdminController::class, 'payEdit'])->name('a-payEdit');
    Route::patch('admin/{id}/payroll', [AdminController::class, 'payUpdate'])->name('a-payUpdate');
});

//Employee
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('employee/dashboard', [EmployeeController::class, 'index'])->name('e-dash');
    Route::get('employee/salary', [EmployeeController::class, 'salary'])->name('e-salary');
    Route::get('employee/qr', [EmployeeController::class, 'qr'])->name('e-qr');
});


//QR Login
Route::middleware(['auth', 'QR'])->group(function () {
    Route::get('qr', [QR::class, 'index'])->name('qr');
    Route::get('qr/view', [QR::class, 'view'])->name('qr-view');
    Route::post('qr/find', [QR::class, 'find']);
    Route::post('qr/image', [QR::class, 'image']);
    Route::post('qr/check', [QR::class, 'check']);
    Route::post('qr/store', [QR::class, 'store'])->name('qr-store');
    Route::patch('qr/update', [QR::class, 'update'])->name('qr-update');
});
//Print
Route::get('print/{id}/', [PrintController::class, 'payslip'])->name('print');
Route::get('print/payroll/{id}/', [PrintController::class, 'payroll'])->name('p-payroll');

//Route::get('print',[PrintController::class,'index'])->name('print');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
