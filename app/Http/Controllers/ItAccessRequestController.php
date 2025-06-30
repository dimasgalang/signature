<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\ApplicationProgram;
use App\Models\Approval;
use App\Models\FileFolderAccess;
use App\Models\HardwareRequest;
use App\Models\ResourceAccess;
use App\Models\User;
use App\Models\UserAccount;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ItAccessRequestController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        // $accessRequests = AccessRequest::join('users as employee', 'employee.id', '=', 'access_requests.employee_id')
        //     ->join('users as approver', 'approver.id', '=', 'access_requests.approval_id')
        //     ->select([
        //         'access_requests.*',
        //         DB::raw('employee.name as preparer_name'),
        //         DB::raw('employee.dept as preparer_dept'),
        //         DB::raw('approver.name as need_approve')
        //     ])
        //     ->orderBy('access_requests.created_at', 'desc')
        //     ->get();


        $accessRequests = DB::select('with data1 as ( select access_requests.*, employee.name as employee_name, employee.dept as employee_dept, (select users.name from access_requests t2 left join users on t2.approval_id = users.id where t2.approval_level = access_requests.approval_progress and t2.document_name = access_requests.document_name and t2.token = access_requests.token ) as need_approve, case when employee_id = lag(employee_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from access_requests left join users as employee on employee.id = access_requests.employee_id where void = "false" ), data2 as ( select *, sum(the_same) over (order by id) group_num FROM data1 ) select * from data2 where approval_id = ' . $user_id . ' order by id desc');

        // dd($accessRequests);
        return view('it-access-request.index', compact('accessRequests'));
    }

    public function create()
    {
        // ARF25062401
        $accessRequest = AccessRequest::orderBy('id', 'desc')->first();
        $prefix = 'ARF';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($accessRequest) && preg_match('/^ARF(\d{6})(\d{2})$/', $accessRequest->id_request_access, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }
        $newIdRequestAccess = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $users = User::all();

        return view('it-access-request.create', compact('newIdRequestAccess', 'users'));
    }

    public function store(Request $request)
    {
        $random = Str::random();
        $ItHeadId = User::where('id', '=', 1)->first();

        $acceessRequestPreparer = AccessRequest::create([
            'id_request_access' => $request->access_request_id,
            'date_of_request' => Carbon::now(),
            'employee_id' => Auth::user()->id,
            'approval_id' => Auth::user()->id,
            'approval_level' => '1',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'status' => 'pending',
            'token' => $random
        ]);

        $acceessRequestHod = AccessRequest::create([
            'id_request_access' => $request->access_request_id,
            'date_of_request' => Carbon::now(),
            'employee_id' => Auth::user()->id,
            'approval_id' => $request->approval_hod_id,
            'approval_level' => '2',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'status' => 'pending',
            'token' => $random
        ]);

        $acceessRequestITHead = AccessRequest::create([
            'id_request_access' => $request->access_request_id,
            'date_of_request' => Carbon::now(),
            'employee_id' => Auth::user()->id,
            'approval_id' => $ItHeadId->id,
            'approval_level' => '3',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'status' => 'pending',
            'token' => $random
        ]);


        if ($request->hardware_device[0]['hardware_name'] != null) {
            foreach ($request->hardware_device as $key => $value) {
                HardwareRequest::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'hardware_device' => $value['hardware_name'],
                    'qty' => $value['quantity'],
                ]);
            }
        }

        if ($request->user_account[0]['account_name'] != null) {
            foreach ($request->user_account as $key => $value) {
                UserAccount::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'account_name' => $value['account_name'],
                ]);
            }
        }

        if ($request->application_program[0]['application_name'] != null) {
            foreach ($request->application_program as $key => $value) {
                ApplicationProgram::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'application_name' => $value['application_name'],
                    'login_name' => $value['login_name'],
                ]);
            }
        }

        if ($request->file_folder_access[0]['file_folder_access'] != null) {
            foreach ($request->file_folder_access as $key => $value) {
                FileFolderAccess::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'file_folder_name' => $value['file_folder_access'],
                    'read' => $value['read'] ?? 'false',
                    'write' => $value['write'] ?? 'false',
                ]);
            }
        }

        if ($request->email_address[0]['email_address'] != null) {
            foreach ($request->email_address as $key => $value) {
                ResourceAccess::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'email_address' => $value['email_address'],
                    'type' => 'email_address',
                    'purpose' => $value['purpose'],
                    'restriction' => $value['restriction'],
                ]);
            }
        }

        if ($request->internet_access[0]['purpose'] != null) {
            foreach ($request->internet_access as $key => $value) {
                ResourceAccess::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'type' => 'internet_access',
                    'purpose' => $value['purpose'],
                    'restriction' => $value['restriction'],
                ]);
            }
        }

        if ($request->other_request[0]['other_request'] != null) {
            foreach ($request->other_request as $key => $value) {
                ResourceAccess::create([
                    'id_request_access' => $acceessRequestPreparer->id_request_access,
                    'type' => 'other_request',
                    'purpose' => $value['purpose'],
                    'restriction' => $value['restriction'],
                ]);
            }
        }

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('it-access-request/index');
    }

    public function approve(Request $request)
    {
        // Data utama
        $accessRequest = DB::table('access_requests')
            ->join('users as employee', 'employee.id', '=', 'access_requests.employee_id')
            ->join('users as approver', 'approver.id', '=', 'access_requests.approval_id')
            ->select([
                'access_requests.*',
                DB::raw('employee.name as preparer_name'),
                DB::raw('employee.dept as preparer_dept'),
                DB::raw('approver.name as need_approve')
            ])
            ->where('id_request_access', $request->id_request_access)
            ->first();

        // Semua hardware request terkait
        $hardwareRequests = DB::table('hardware_requests')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->get();

        // Semua application program terkait
        $applicationPrograms = DB::table('application_programs')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->get();

        // Semua file folder access terkait
        $fileFolderAccesses = DB::table('file_folder_accesses')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->get();

        $emailAccount = DB::table('resource_accesses')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->where('type', 'email_address')
            ->get();

        $internetAccess = DB::table('resource_accesses')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->where('type', 'internet_access')
            ->get();

        $otherRequests = DB::table('resource_accesses')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->where('type', 'other_request')
            ->get();

        // Semua user account terkait
        $userAccounts = DB::table('user_accounts')
            ->where('id_request_access', $accessRequest->id_request_access)
            ->get();

        return view('it-access-request.approval', compact(['accessRequest', 'hardwareRequests', 'applicationPrograms', 'fileFolderAccesses', 'emailAccount', 'internetAccess', 'otherRequests', 'userAccounts', 'accessRequest',]));
    }

    public function approvedItem(Request $request)
    {
        if ($request->hardware_device) {
            foreach ($request->hardware_device as $key => $value) {
                HardwareRequest::where('id_request_access', $request->access_request_id)
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->user_account) {
            foreach ($request->user_account as $key => $value) {
                UserAccount::where('id_request_access', $request->access_request_id)
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->application_program) {
            foreach ($request->application_program as $key => $value) {
                ApplicationProgram::where('id_request_access', $request->access_request_id)
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->file_folder_access) {
            foreach ($request->file_folder_access as $key => $value) {
                FileFolderAccess::where('id_request_access', $request->access_request_id)
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->email_address) {
            foreach ($request->email_address as $key => $value) {
                ResourceAccess::where('id_request_access', $request->access_request_id)
                    ->where('type', 'email_address')
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->internet_access) {
            foreach ($request->internet_access as $key => $value) {
                ResourceAccess::where('id_request_access', $request->access_request_id)
                    ->where('type', 'internet_access')
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        if ($request->other_request) {
            foreach ($request->other_request as $key => $value) {
                ResourceAccess::where('id_request_access', $request->access_request_id)
                    ->where('type', 'other_request')
                    ->where('id', $value['id'])
                    ->update([
                        'status_approved' => $value['status'],
                    ]);
            }
        }

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('it-access-request/index');
    }

    public function approved(Request $request)
    {
        $accessRequest = AccessRequest::findOrFail($request->id);
        $totalData = AccessRequest::select('access_requests.*', 'users.name', 'users.email')->leftJoin('users', 'access_requests.employee_id', '=', 'users.id')->where('access_requests.employee_id', '=', $request->employee_id)->where('access_requests.document_name', '=', $request->document_name)->where('access_requests.token', '=', $request->token)->get();

        $accessRequest->fill([
            'approval_date' => Carbon::now(),
            'status' => 'approved',
        ]);
        $accessRequest->save();

        // AccessRequest::where('employee_id', '=', $request->employee_id)->where('approval_level', '>', $accessRequest->approval_level)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
        //     'original_name' => $new_filename,
        //     'base64' => $new_base64,
        // ]);

        if ($accessRequest->approval_level < count($totalData)) {
            AccessRequest::where('employee_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress + 1,
            ]);
        } else {
            $approvalProgress = $request->approval_progress;
            AccessRequest::where('employee_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress,
                'status' => 'approved',
            ]);
        }

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('it-access-request/index');
    }
}
