<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SignaturePadController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/guest', [RegisterController::class, 'store'])->name('register.guest');
    
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //Register
    Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [RegisterController::class, 'storeAuth'])->name('register');

    //Role
    Route::get('/role/index', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/find/{id}', [RoleController::class, 'find'])->name('role.find');
    Route::post('/role/update', [RoleController::class, 'update'])->name('role.update');

    //Signature
    Route::get('/signature', [SignaturePadController::class, 'index'])->name('signature');
    Route::get('/signature/create', [SignaturePadController::class, 'create'])->name('signature.create');
    Route::post('/signature/store', [SignaturePadController::class, 'store'])->name('signature.store');

    Route::get('/signature-pdf', [SignaturePadController::class, 'stamp'])->name('signaturepdf.stamp');
    Route::post('/signature/stamping', [SignaturePadController::class, 'stamping'])->name('signature.stamping');
    Route::post('/signature-pdf/upload', [SignaturePadController::class, 'upload'])->name('signaturepdf.upload');

    //User
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/user/assign/{id}', [UserController::class, 'assign'])->name('user.assign');
    Route::post('/user/assignrole', [UserController::class, 'assignrole'])->name('user.assignrole');

    //Approval
    Route::get('/approval/index', [ApprovalController::class, 'index'])->name('approval.index');
    Route::get('/approval/create', [ApprovalController::class, 'create'])->name('approval.create');
    Route::get('/approval/approve/{id}', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::get('/approval/fetchapproval/{id}', [ApprovalController::class, 'fetchapproval'])->name('approval.fetchapproval');
    Route::post('/approval/revision', [ApprovalController::class, 'revision'])->name('approval.revision');
    Route::post('/approval/void', [ApprovalController::class, 'void'])->name('approval.void');
    Route::post('/approval/restore', [ApprovalController::class, 'restore'])->name('approval.restore');
    Route::post('/approval/store', [ApprovalController::class, 'store'])->name('approval.store');
    Route::post('/approval/approved', [ApprovalController::class, 'approved'])->name('approval.approved');

    //Text To Speech
    Route::get('/speech/index', [SpeechController::class, 'index'])->name('speech.index');

    //Send Email
    Route::get('/email/send', [SendEmailController::class, 'send'])->name('email.send');
});
