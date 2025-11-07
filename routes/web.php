<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CommitmentComputerController;
use App\Http\Controllers\ComputerInspectionController;
use App\Http\Controllers\LeaverController;
use App\Http\Controllers\ConverterController;
use App\Http\Controllers\CyberUserAccountController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItAccessRequestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchaseRequestionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SignaturePadController;
use App\Http\Controllers\SmartITController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\SurveillanceSystemMaintenanceController;
use App\Http\Controllers\SysLogController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Models\PurchaseRequestOrder;
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
    Route::get('/register', [RegisterController::class, 'index'])->name('registeri');
    Route::post('/register/guest', [RegisterController::class, 'store'])->name('register.guest');

    Route::get('/login', [LoginController::class, 'login'])->name('login.guest');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login')->middleware('throttle:3,10');
    Route::get('/login/qrauth', [LoginController::class, 'qrauth'])->name('login.qrauth');
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
    Route::get('/approval/indexHandover', [ApprovalController::class, 'indexHandover'])->name('approval.indexHandover');
    Route::get('/approval/indexLeaver', [ApprovalController::class, 'indexLeaver'])->name('approval.indexLeaver');
    Route::get('/approval/indexCommitment', [ApprovalController::class, 'indexCommitment'])->name('approval.indexCommitment');
    Route::get('/approval/indexItAccess', [ApprovalController::class, 'indexItAccess'])->name('approval.indexItAccess');
    Route::get('/approval/indexDeactivate', [ApprovalController::class, 'indexDeactivate'])->name('approval.indexDeactivate');
    Route::get('/approval/indexSurveillance', [ApprovalController::class, 'indexSurveillance'])->name('approval.indexSurveillance');
    Route::get('/approval/create', [ApprovalController::class, 'create'])->name('approval.create');
    Route::get('/approval/approve/{id}', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::get('/approval/fetchapproval/{id}', [ApprovalController::class, 'fetchapproval'])->name('approval.fetchapproval');
    Route::get('/approval/fetchattachment/{token}', [ApprovalController::class, 'fetchattachment'])->name('approval.fetchattachment');
    Route::post('/approval/revision', [ApprovalController::class, 'revision'])->name('approval.revision');
    Route::post('/approval/void', [ApprovalController::class, 'void'])->name('approval.void');
    Route::post('/approval/restore', [ApprovalController::class, 'restore'])->name('approval.restore');
    Route::post('/approval/store', [ApprovalController::class, 'store'])->name('approval.store');
    Route::post('/approval/approved', [ApprovalController::class, 'approved'])->name('approval.approved');
    Route::get('/approval/stamp/{id}', [ApprovalController::class, 'stamp'])->name('approval.stamp');
    Route::post('/approval/stamping', [ApprovalController::class, 'stamping'])->name('approval.stamping');
    Route::get('/handover/create-approval/{id}', [HandoverController::class, 'createApproval'])->name('handover.createApproval');

    // Handover
    Route::get('/handover/index', [HandoverController::class, 'index'])->name('handover.index')->middleware(['auth', 'role:Admin']);
    Route::get('/handover/create', [HandoverController::class, 'create'])->name('handover.create')->middleware(['auth', 'role:Admin']);
    Route::post('/handover/store', [HandoverController::class, 'store'])->name('handover.store')->middleware(['auth', 'role:Admin']);
    Route::get('/handover/revision/{id}', [HandoverController::class, 'revision'])->name('handover.revisionHandover')->middleware(['auth', 'role:Admin']);
    Route::get('/handover/fetchHandover/{id}', [HandoverController::class, 'fetchHandover'])->name('handover.fetchHandover')->middleware(['auth', 'role:Admin']);
    Route::post('/handover/update', [HandoverController::class, 'update'])->name('handover.updateHandover')->middleware(['auth', 'role:Admin']);
    Route::post('/handover/void', [HandoverController::class, 'void'])->name('handover.void')->middleware(['auth', 'role:Admin']);
    Route::post('/handover/restore', [HandoverController::class, 'restore'])->name('handover.restore')->middleware(['auth', 'role:Admin']);
    Route::get('/handover/fetchDept/{id_user}', [HandoverController::class, 'fetchDept'])->name('handover.fetchDept')->middleware(['auth', 'role:Admin']);
    Route::get('/handover/generatePDF/{id}', [HandoverController::class, 'generatePDF'])->name('handover.generatePDF')->middleware(['auth', 'role:Admin']);

    // Leaver
    Route::get('/leaver/index', [LeaverController::class, 'index'])->name('leaver.index');
    Route::get('/leaver/create', [LeaverController::class, 'create'])->name('leaver.create');
    Route::post('/leaver/store', [LeaverController::class, 'store'])->name('leaver.store');
    Route::get('/leaver/revision/{id}', [LeaverController::class, 'revision'])->name('leaver.revision')->middleware(['auth', 'role:Admin']);
    Route::get('/leaver/fetchLeaver/{id}', [LeaverController::class, 'fetchLeaver'])->name('leaver.fetchLeaver');
    Route::post('/leaver/update', [LeaverController::class, 'update'])->name('leaver.update')->middleware(['auth', 'role:Admin']);
    Route::post('/leaver/void', [LeaverController::class, 'void'])->name('leaver.void')->middleware(['auth', 'role:Admin']);
    Route::post('/leaver/restore', [LeaverController::class, 'restore'])->name('leaver.restore')->middleware(['auth', 'role:Admin']);
    Route::get('/leaver/fetchDept/{id_user}', [LeaverController::class, 'fetchDept'])->name('leaver.fetchDept');
    Route::get('/leaver/create-approval/{id}', [LeaverController::class, 'createApproval'])->name('leaver.createApproval');

    // IT Access Request
    Route::get('/it-access-request/index', [ItAccessRequestController::class, 'index'])->name('it-access-request.index');
    Route::get('/it-access-request/create', [ItAccessRequestController::class, 'create'])->name('it-access-request.create');
    Route::post('/it-access-request/store', [ItAccessRequestController::class, 'store'])->name('it-access-request.store');
    Route::get('/it-access-request/approve/{id_request_access}', [ItAccessRequestController::class, 'approve'])->name('it-access-request.approve');
    Route::post('/it-access-request/approvedItem', [ItAccessRequestController::class, 'approvedItem'])->name('it-access-request.approvedItem');
    Route::post('/it-access-request/approved', [ItAccessRequestController::class, 'approved'])->name('it-access-request.approved');
    Route::get('/it-access-request/fetchitaccess/{id}', [ItAccessRequestController::class, 'fetchitaccess'])->name('it-access-request.fetchitaccess');
    Route::post('/it-access-request/revision', [ItAccessRequestController::class, 'revision'])->name('it-access-request.revision')->middleware(['auth', 'role:Admin']);
    Route::get('/it-access-request/view/{id}', [ItAccessRequestController::class, 'generatePdf'])->name('it-access-request.view');
    Route::get('/it-access-request/revision/{id_request_access}', [ItAccessRequestController::class, 'edit'])->name('it-access-request.edit');
    Route::post('/it-access-request/update', [ItAccessRequestController::class, 'update'])->name('it-access-request.update')->middleware(['auth', 'role:Admin']);
    Route::post('/it-access-request/void', [ItAccessRequestController::class, 'void'])->name('it-access-request.void')->middleware(['auth', 'role:Admin']);
    Route::post('/it-access-request/restore', [ItAccessRequestController::class, 'restore'])->name('it-access-request.restore')->middleware(['auth', 'role:Admin']);
    // Route::get('/leaver/revision/{id}', [ItAccessRequestController::class, 'revision'])->name('leaver.revision')->middleware(['auth', 'role:Admin']);
    // Route::get('/leaver/fetchLeaver/{id}', [ItAccessRequestController::class, 'fetchLeaver'])->name('leaver.fetchLeaver')->middleware(['auth', 'role:Admin']);
    // Route::get('/leaver/fetchDept/{id_user}', [ItAccessRequestController::class, 'fetchDept'])->name('leaver.fetchDept')->middleware(['auth', 'role:Admin']);
    // Route::get('/leaver/create-approval/{id}', [ItAccessRequestController::class, 'createApproval'])->name('leaver.createApproval')->middleware(['auth', 'role:Admin']);

    // Commitment
    Route::get('/commitment/index', [CommitmentComputerController::class, 'index'])->name('commitment.index');
    Route::get('/commitment/create', [CommitmentComputerController::class, 'create'])->name('commitment.create');
    Route::post('/commitment/store', [CommitmentComputerController::class, 'store'])->name('commitment.store');
    Route::get('/commitment/revision/{id}', [CommitmentComputerController::class, 'revision'])->name('commitment.revisionHandover')->middleware(['auth', 'role:Admin']);
    Route::get('/commitment/fetchCommitment/{id}', [CommitmentComputerController::class, 'fetchCommitment'])->name('commitment.fetchCommitment');
    Route::post('/commitment/update', [CommitmentComputerController::class, 'update'])->name('commitment.updateHandover')->middleware(['auth', 'role:Admin']);
    Route::post('/commitment/void', [CommitmentComputerController::class, 'void'])->name('commitment.void')->middleware(['auth', 'role:Admin']);
    Route::post('/commitment/restore', [CommitmentComputerController::class, 'restore'])->name('commitment.restore')->middleware(['auth', 'role:Admin']);
    Route::get('/commitment/fetchEmployee/{npk}', [CommitmentComputerController::class, 'fetchEmployee'])->name('commitment.fetchEmployee');
    Route::get('/commitment/generatePDF/{id}', [CommitmentComputerController::class, 'generatePDF'])->name('commitment.generatePDF');
    Route::get('/commitment/create-approval/{id}', [CommitmentComputerController::class, 'createApproval'])->name('commitment.createApproval');

    //Attachment
    Route::get('/attachment/index', [AttachmentController::class, 'index'])->name('attachment.index');
    Route::get('/attachment/create', [AttachmentController::class, 'create'])->name('attachment.create');
    Route::post('/attachment/store', [AttachmentController::class, 'store'])->name('attachment.store');
    Route::post('/attachment/void', [AttachmentController::class, 'void'])->name('attachment.void');
    Route::post('/attachment/restore', [AttachmentController::class, 'restore'])->name('attachment.restore');
    Route::get('/attachment/fetchattachment/{id}', [AttachmentController::class, 'fetchattachment'])->name('attachment.fetchattachment');

    // Cyber User
    Route::get('/cyber-user/index', [CyberUserAccountController::class, 'index'])->name('cyber-user.index');
    Route::get('/cyber-user/create', [CyberUserAccountController::class, 'create'])->name('cyber-user.create');
    Route::post('/cyber-user/store', [CyberUserAccountController::class, 'store'])->name('cyber-user.store');
    Route::get('/cyber-user/fetchEmployee/{npk}', [CyberUserAccountController::class, 'fetchEmployee'])->name('cyber-user.fetchEmployee');
    Route::get('/cyber-user/revision/{deactivation_request_id}', [CyberUserAccountController::class, 'edit'])->name('cyber-user.edit');
    Route::post('/cyber-user/revision', [CyberUserAccountController::class, 'revision'])->name('cyber-user.revision')->middleware(['auth', 'role:Admin']);
    Route::get('/cyber-user/fetchdeactivaterequest/{id}', [CyberUserAccountController::class, 'fetchdeactivaterequest'])->name('cyber-user.fetchdeactivaterequest');
    Route::get('/cyber-user/approve/{deactivation_request_id}', [CyberUserAccountController::class, 'approve'])->name('cyber-user.approve');
    Route::post('/cyber-user/approved', [CyberUserAccountController::class, 'approved'])->name('cyber-user.approved');
    Route::get('/cyber-user/view/{id}', [CyberUserAccountController::class, 'generatePdf'])->name('cyber-user.view');
    Route::post('/cyber-user/update', [CyberUserAccountController::class, 'update'])->name('cyber-user.update');
    Route::post('/cyber-user/void', [CyberUserAccountController::class, 'void'])->name('cyber-user.void');
    Route::post('/cyber-user/restore', [CyberUserAccountController::class, 'restore'])->name('cyber-user.restore');

    // Surveillance System Maintenance
    Route::get('/surveillance-system-maintenance/index', [SurveillanceSystemMaintenanceController ::class, 'index'])->name('surveillance-system-maintenance.index');
    Route::get('/surveillance-system-maintenance/create', [SurveillanceSystemMaintenanceController::class, 'create'])->name('surveillance-system-maintenance.create');
    Route::post('/surveillance-system-maintenance/store', [SurveillanceSystemMaintenanceController::class, 'store'])->name('surveillance-system-maintenance.store');
    Route::get('/surveillance-system-maintenance/view/{id}', [SurveillanceSystemMaintenanceController::class, 'generatePdf'])->name('surveillance-system-maintenance.view');
    Route::get('/surveillance-system-maintenance/revision/{surveillance_maintenance_id}', [SurveillanceSystemMaintenanceController::class, 'edit'])->name('surveillance-system-maintenance.edit');
    Route::get('/surveillance-system-maintenance/fetchsurveillancemaintenance/{id}', [SurveillanceSystemMaintenanceController::class, 'fetchsurveillancemaintenance'])->name('surveillance-system-maintenance.fetchsurveillancemaintenance');
    Route::get('/surveillance-system-maintenance/approve/{surveillance_maintenance_id}', [SurveillanceSystemMaintenanceController::class, 'approve'])->name('surveillance-system-maintenance.approve');
    Route::post('/surveillance-system-maintenance/approved', [SurveillanceSystemMaintenanceController::class, 'approved'])->name('surveillance-system-maintenance.approved');
    Route::get('/surveillance-system-maintenance/view/{id}', [SurveillanceSystemMaintenanceController::class, 'generatePdf'])->name('surveillance-system-maintenance.view');
    Route::post('/surveillance-system-maintenance/update', [SurveillanceSystemMaintenanceController::class, 'update'])->name('surveillance-system-maintenance.update');
    Route::post('/surveillance-system-maintenance/void', [SurveillanceSystemMaintenanceController::class, 'void'])->name('surveillance-system-maintenance.void');
    Route::post('/surveillance-system-maintenance/restore', [SurveillanceSystemMaintenanceController::class, 'restore'])->name('surveillance-system-maintenance.restore');


    // Purchase Request Order
    Route::get('/purchase-requestion/index', [PurchaseRequestionController ::class, 'index'])->name('purchase-requestion.index');
    Route::get('/purchase-requestion/create', [PurchaseRequestionController::class, 'create'])->name('purchase-requestion.create');
    Route::post('/purchase-requestion/store', [PurchaseRequestionController::class, 'store'])->name('purchase-requestion.store');
    Route::get('/purchase-requestion/fetchPurchaseRequest/{purchaseRequestionNumber}', [PurchaseRequestionController::class, 'fetchPurchaseRequest'])->name('purchase-requestion.fetchPurchaseRequest');
    Route::get('/purchase-requestion/assignSupplier/{purchaseRequestionNumber}', [PurchaseRequestionController::class, 'assignSupplier'])->name('purchase-requestion.assignSupplier');
    Route::post('/purchase-requestion/processPurchaseRequest', [PurchaseRequestionController::class, 'processPurchaseRequest'])->name('purchase-requestion.processPurchaseRequest');
    Route::post('/purchase-requestion/canceledPurchaseRequest', [PurchaseRequestionController::class, 'canceledPurchaseRequest'])->name('purchase-requestion.canceledPurchaseRequest');
    Route::post('/purchase-requestion/finishedPurchaseRequest', [PurchaseRequestionController::class, 'finishedPurchaseRequest'])->name('purchase-requestion.finishedPurchaseRequest');
    Route::get('/purchase-requestion/arrival/{purchaseRequestionNumber}', [PurchaseRequestionController::class, 'createArrival'])->name('purchase-requestion.arrival');
    Route::post('/purchase-requestion/storeArrival', [PurchaseRequestionController::class, 'storeArrival'])->name('purchase-requestion.storeArrival');
    Route::get('/purchase-requestion/fetchArrivalHistory/{purchaseRequestionNumber}', [PurchaseRequestionController::class, 'fetchArrivalHistory'])->name('purchase-requestion.fetchArrivalHistory');
    Route::post('/purchase-requestion/void', [PurchaseRequestionController::class, 'void'])->name('purchase-requestion.void');
    Route::post('/purchase-requestion/restore', [PurchaseRequestionController::class, 'restore'])->name('purchase-requestion.restore');


    // Computer Inspection
    Route::get('/computer-inspection/index', [ComputerInspectionController ::class, 'index'])->name('computer-inspection.index');
    Route::get('/computer-inspection/create', [ComputerInspectionController::class, 'create'])->name('computer-inspection.create');
    Route::post('/computer-inspection/store', [ComputerInspectionController::class, 'store'])->name('computer-inspection.store');
    Route::get('/computer-inspection/fetchComputerInfo/{assets_number}', [ComputerInspectionController::class, 'fetchComputerInfo'])->name('computer-inspection.fetchComputerInfo');
    Route::get('/computer-inspection/export', [ComputerInspectionController::class, 'export'])->name('computer-inspection.export');

    //Text To Speech
    Route::get('/speech/index', [SpeechController::class, 'index'])->name('speech.index');

    //Send Email
    Route::get('/email/send', [SendEmailController::class, 'send'])->name('email.send');

    //Template
    Route::get('/template/lpp', [TemplateController::class, 'lpp'])->name('template.lpp');
    Route::get('/template/handover', [TemplateController::class, 'handover'])->name('template.handover');
    Route::get('/template/commitment', [TemplateController::class, 'commitment'])->name('template.commitment');
    Route::get('/template/it-access', [TemplateController::class, 'it_access'])->name('template.itaccess');
    Route::get('/template/cyber-user-account', [TemplateController::class, 'cyber_user_account'])->name('template.cyber_user_account');
    Route::get('/template/surveillance-system-maintenance', [TemplateController::class, 'surveillance_system_maintenance'])->name('template.surveillance_system_maintenance');
    Route::get('/template/computer-inspection', [TemplateController::class, 'computer_inspection'])->name('template.computer_inspection');
    
    //Export
    Route::get('/export/lpp', [ExportController::class, 'lpp'])->name('export.lpp');
    Route::get('/export/lpp_pdf', [ExportController::class, 'lpp_pdf'])->name('export.lpp_pdf');

    Route::get('/syslog/index', [SysLogController::class, 'index'])->name('syslog.index');

    //Converter
    Route::get('/converter', [ConverterController::class, 'index'])->name('converter.index');
    Route::post('/converter/converter', [ConverterController::class, 'converter'])->name('converter.converter');

    //SmartIT
    Route::get('/smartit/fetchitem', [SmartITController::class, 'fetchitem'])->name('smartit.fetchitem');
});
