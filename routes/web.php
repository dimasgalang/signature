<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ConverterController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SignaturePadController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\TemplateController;
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

Route::get('/', [LoginController::class, 'login'])->name('/');

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
    Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create')->middleware(['auth', 'role:Admin']);
    Route::post('/register', [RegisterController::class, 'storeAuth'])->name('register')->middleware(['auth', 'role:Admin']);

    //Role
    Route::get('/role/index', [RoleController::class, 'index'])->name('role.index')->middleware(['auth', 'role:Admin']);
    Route::get('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete')->middleware(['auth', 'role:Admin']);
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware(['auth', 'role:Admin']);
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store')->middleware(['auth', 'role:Admin']);
    Route::get('/role/find/{id}', [RoleController::class, 'find'])->name('role.find')->middleware(['auth', 'role:Admin']);
    Route::post('/role/update', [RoleController::class, 'update'])->name('role.update')->middleware(['auth', 'role:Admin']);

    //Signature
    Route::get('/signature', [SignaturePadController::class, 'index'])->name('signature');
    Route::get('/signature/create', [SignaturePadController::class, 'create'])->name('signature.create');
    Route::post('/signature/store', [SignaturePadController::class, 'store'])->name('signature.store');

    Route::get('/signature-pdf', [SignaturePadController::class, 'stamp'])->name('signaturepdf.stamp');
    Route::post('/signature/stamping', [SignaturePadController::class, 'stamping'])->name('signature.stamping');
    Route::post('/signature-pdf/upload', [SignaturePadController::class, 'upload'])->name('signaturepdf.upload');

    //User
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index')->middleware(['auth', 'role:Admin']);
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update')->middleware(['auth', 'role:Admin']);
    Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('user.detail')->middleware(['auth', 'role:Admin']);
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete')->middleware(['auth', 'role:Admin']);
    Route::get('/user/assign/{id}', [UserController::class, 'assign'])->name('user.assign')->middleware(['auth', 'role:Admin']);
    Route::post('/user/assignrole', [UserController::class, 'assignrole'])->name('user.assignrole')->middleware(['auth', 'role:Admin']);

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
    Route::get('/approval/stamp/{id}', [ApprovalController::class, 'stamp'])->name('approval.stamp');
    Route::post('/approval/stamping', [ApprovalController::class, 'stamping'])->name('approval.stamping');

    // Serah Terima
    Route::get('/handover/index', [HandoverController::class, 'index'])->name('handover.index');
    Route::get('/handover/create', [HandoverController::class, 'create'])->name('handover.create');
    Route::post('/handover/store', [HandoverController::class, 'store'])->name('handover.store');
    Route::get('/handover/revision/{id}', [HandoverController::class, 'revision'])->name('handover.revisionHandover');
    Route::get('/handover/fetchHandover/{id}', [HandoverController::class, 'fetchHandover'])->name('handover.fetchHandover');
    Route::post('/handover/update', [HandoverController::class, 'update'])->name('handover.updateHandover');
    Route::post('/handover/void', [HandoverController::class, 'void'])->name('handover.void');
    Route::post('/handover/restore', [HandoverController::class, 'restore'])->name('handover.restore');


    //Text To Speech
    Route::get('/speech/index', [SpeechController::class, 'index'])->name('speech.index');

    //Send Email
    Route::get('/email/send', [SendEmailController::class, 'send'])->name('email.send');

    //Template
    Route::get('/template/lpp', [TemplateController::class, 'lpp'])->name('template.lpp');
    Route::get('/template/serah-terima', [TemplateController::class, 'serah_terima'])->name('template.serah-terima');

    //Export
    Route::get('/export/lpp', [ExportController::class, 'lpp'])->name('export.lpp');
    Route::get('/export/lpp_pdf', [ExportController::class, 'lpp_pdf'])->name('export.lpp_pdf');

    //Converter
    Route::get('/converter', [ConverterController::class, 'index'])->name('converter.index');
    Route::post('/converter/converter', [ConverterController::class, 'converter'])->name('converter.converter');
});
