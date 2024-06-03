<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ViewController::class, 'index'])->name('index');


Route::middleware(['role:QR'])->group(function () {
    Route::get('/scanner', [ViewController::class, 'qrScanner'])->name('qr-scanner');
    Route::post('/scanner', [QRController::class, 'store'])->name('qr-store');
    Route::post('qr/data', [QRController::class, 'data']);
    Route::post('qr/image', [QRController::class, 'image']);
    Route::post('qr/store', [QRController::class, 'store']);
    Route::get('/session', [FunctionController::class, 'qrSession']);
});
Route::middleware(['role:USER'])->group(function () {
    Route::get('user/dashboard', [ViewController::class, 'userDash'])->name('u-dashboard');
    Route::get('user/payroll', [ViewController::class, 'empPay'])->name('u-payroll');
    Route::get('user/qrView', [ViewController::class, 'empQr'])->name('u-qrView');


    Route::post('user/empMonth', [FunctionController::class, 'empMonth']);
    Route::post('user/empYear', [FunctionController::class, 'empYear']);
});

Route::middleware(['role:ADMIN'])->group(function () {
    //Views
    Route::get('/dashboard', [ViewController::class, 'adminDash'])->name('a-dashboard');
    Route::get('/empView', [ViewController::class, 'empView'])->name('a-empView');
    Route::get('/payView', [ViewController::class, 'payView'])->name('a-payView');
    Route::get('/qrView', [ViewController::class, 'qrView'])->name('a-qrView');
    Route::get('/logs', [ViewController::class, 'logs'])->name('a-logs');
    Route::get('/addEmp', [ViewController::class, 'addEmp'])->name('a-addEmp');
    Route::get('/editEmp/{id}', [ViewController::class, 'editEmp'])->name('a-editEmp');
    Route::get('/editPay/{id}', [ViewController::class, 'editPay'])->name('a-editPay');


    //Process
    Route::post('/addEmp', [AdminController::class, 'addEmp'])->name('a-addEmp');
    Route::patch('/updateEmp/{id}', [AdminController::class, 'updateEmp'])->name('a-updateEmp');
    Route::delete('/deleteEmp/{id}', [AdminController::class, 'deleteEmp'])->name('a-deleteEmp');
    Route::patch('/updatePay/{id}', [AdminController::class, 'updatePay'])->name('a-updatePay');
    Route::get('/payslip/{id}/', [AdminController::class, 'payslip'])->name('p-payslip');
    Route::get('/payroll/{id}/', [AdminController::class, 'payroll'])->name('p-payroll');

    //Functions
    Route::get('/qr/{id}', [FunctionController::class, 'QR'])->name('a-qr');
    Route::post('/username', [FunctionController::class, 'username'])->name('username');
    Route::post('{id}/username', [FunctionController::class, 'username']);
    Route::post('month', [FunctionController::class, 'month']);
    Route::post('year', [FunctionController::class, 'year']);



});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
