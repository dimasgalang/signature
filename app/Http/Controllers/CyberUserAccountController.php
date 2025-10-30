<?php

namespace App\Http\Controllers;

use App\Models\CyberUserAccount;
use App\Models\ReasonDeactivateCyberUser;
use App\Models\SysLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use RealRashid\SweetAlert\Facades\Alert;

class CyberUserAccountController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $deactivateRequests = DB::select("with data1 as ( select cyber_user_accounts.*, employee.name as employee_name, employee.dept as employee_dept, (select users.name from cyber_user_accounts t2 left join users on t2.approval_id = users.id where t2.approval_level = cyber_user_accounts.approval_progress and t2.document_name = cyber_user_accounts.document_name and t2.token = cyber_user_accounts.token ) as need_approve, case when preparer_id = lag(preparer_id) over (order by cyber_user_accounts.id) and document_name = lag(document_name) over (order by cyber_user_accounts.id) and token = lag(token) over (order by cyber_user_accounts.id) then 0 else 1 end as the_same from cyber_user_accounts left join users as employee on employee.id = cyber_user_accounts.preparer_id where void = '" . $request->void . "' ), data2 as ( select *, sum(the_same) over (order by id) group_num FROM data1 ) select * from data2 where approval_id = '" . $user_id . "' order by id desc");
        } else {
            $deactivateRequests = DB::select("with data1 as ( select cyber_user_accounts.*, employee.name as employee_name, employee.dept as employee_dept, (select users.name from cyber_user_accounts t2 left join users on t2.approval_id = users.id where t2.approval_level = cyber_user_accounts.approval_progress and t2.document_name = cyber_user_accounts.document_name and t2.token = cyber_user_accounts.token ) as need_approve, case when preparer_id = lag(preparer_id) over (order by cyber_user_accounts.id) and document_name = lag(document_name) over (order by cyber_user_accounts.id) and token = lag(token) over (order by cyber_user_accounts.id) then 0 else 1 end as the_same from cyber_user_accounts left join users as employee on employee.id = cyber_user_accounts.preparer_id where void = 'false' ), data2 as ( select *, sum(the_same) over (order by id) group_num FROM data1 ) select * from data2 where approval_id = '" . $user_id . "' order by id desc");
        }
        return view('user-account-deactivation.index', compact('deactivateRequests'));
    }

    public function create()
    {
        $usersActive = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->get();
        $usersOut = DB::connection('cii')->table('BIODATA_KELUAR')->select('BIODATA_KELUAR.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->get();
        $users = $usersActive->merge($usersOut);
        $reasons = ReasonDeactivateCyberUser::all();

        // CUA25062401
        $cyberUserAccount = CyberUserAccount::orderBy('id', 'desc')->first();
        $prefix = 'CUA';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($cyberUserAccount) && preg_match('/^CUA(\d{6})(\d{2})$/', $cyberUserAccount->deactivation_request_id, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }

        $newIdRequestDeactivate = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('user-account-deactivation.create', compact(['users', 'reasons', 'newIdRequestDeactivate']));
    }

    public function edit($deactivation_request_id)
    {
        $deactivateRequest = DB::table('cyber_user_accounts')
            ->join('users as employee', 'employee.id', '=', 'cyber_user_accounts.preparer_id')
            ->join('users as approver', 'approver.id', '=', 'cyber_user_accounts.approval_id')
            ->select([
                'cyber_user_accounts.*',
                DB::raw('employee.name as preparer_name'),
                DB::raw('employee.dept as preparer_dept'),
                DB::raw('approver.name as need_approve')
            ])
            ->where('deactivation_request_id', $deactivation_request_id)
            ->first();
        $userDeactive = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->where('NPK', '=', $deactivateRequest->employee_id)->get();
        // dd($userDeactive);
        $reasons = ReasonDeactivateCyberUser::all();
        return view('user-account-deactivation.revision', compact('deactivateRequest', 'userDeactive', 'reasons'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $deactivateRequest = CyberUserAccount::where('deactivation_request_id', $request->deactivation_request_id)->get();
        // dd($deactivateRequest);
        foreach ($deactivateRequest as $deactivate) {
            $deactivate->update([
                'reason_id' => $request->reason_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'deactivate' => $request->deactivate
            ]);
        }

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Updated Deactivate Access for NPK ' . User::where('npk', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Updated Successfully!', 'Deactivate Access successfully updated!');
        return redirect()->intended('approval/indexDeactivate');
    }

    public function fetchEmployee($npk)
    {
        $employee = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->get();
        $employeeOut = DB::connection('cii')->table('BIODATA_KELUAR')->select('BIODATA_KELUAR.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA_KELUAR.ID_DEPT', '=', 'DEPT.ID_DEPT')->get();

        $employee = $employee->merge($employeeOut)->where('NPK', '=', $npk)->first();
        return response()->json($employee);
    }

    public function store(Request $request)
    {

        $random = Str::random();
        $ItHeadId = User::where('id', '=', 1)->first();
        $HRHeadId = User::where('npk', '=', 'C-00011')->first();

        // $request->validate([
        //     'npk' => 'required',
        //     'reason' => 'required',
        // ]);

        $cyberUserAccountPreparer = CyberUserAccount::create([
            'deactivation_request_id' => $request->deactivation_request_id,
            'date_of_request' => Carbon::now(),
            'approval_id' => $request->preparer_id,
            'preparer_id' => $request->preparer_id,
            'approval_level' => '1',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'deactivate' => $request->deactivate,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason_id' => $request->reason_id,
            'employee_id' => $request->employee_id,
            'status' => 'pending',
            'token' => $random
        ]);

        $cyberUserAccountHR = CyberUserAccount::create([
            'deactivation_request_id' => $request->deactivation_request_id,
            'date_of_request' => Carbon::now(),
            'approval_id' => $HRHeadId->id,
            'preparer_id' => $request->preparer_id,
            'approval_level' => '2',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'deactivate' => $request->deactivate,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason_id' => $request->reason_id,
            'employee_id' => $request->employee_id,
            'status' => 'pending',
            'token' => $random
        ]);

        $cyberUserAccountIT = CyberUserAccount::create([
            'deactivation_request_id' => $request->deactivation_request_id,
            'date_of_request' => Carbon::now(),
            'approval_id' => $ItHeadId->id,
            'preparer_id' => $request->preparer_id,
            'approval_level' => '3',
            'approval_progress' => '1',
            'document_name' => $request->document_name,
            'deactivate' => $request->deactivate,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason_id' => $request->reason_id,
            'employee_id' => $request->employee_id,
            'status' => 'pending',
            'token' => $random
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Create Deactivate Access for NPK ' . User::where('npk', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Created Successfully!', 'Deactivate Access successfully created!');
        return redirect()->intended('approval/indexDeactivate');
    }

    public function approved(Request $request)
    {
        $deactivateRequest = CyberUserAccount::findOrFail($request->id);
        $totalData = CyberUserAccount::select('cyber_user_accounts.*', 'users.name', 'users.email')->leftJoin('users', 'cyber_user_accounts.approval_id', '=', 'users.id')->where('cyber_user_accounts.preparer_id', '=', $request->employee_id)->where('cyber_user_accounts.document_name', '=', $request->document_name)->where('cyber_user_accounts.token', '=', $request->token)->get();

        // dd($totalData);

        $deactivateRequest->fill([
            'approval_date' => Carbon::now(),
            'status' => 'approved',
        ]);
        $deactivateRequest->save();

        if ($deactivateRequest->approval_level < count($totalData)) {
            CyberUserAccount::where('preparer_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress + 1,
            ]);
        } else {
            $approvalProgress = $request->approval_progress;
            CyberUserAccount::where('preparer_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress,
                'status' => 'approved',
            ]);
        }

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Approved Deactivate Access for NPK ' . User::where('id', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Approved Successfully!', 'Document successfully approved!');
        return redirect()->intended('approval/indexDeactivate');
    }

    public function fetchdeactivaterequest($id)
    {
        $fetchdeactivaterequest = CyberUserAccount::select('cyber_user_accounts.*', 'users.name')->leftJoin('users', 'users.id', '=', 'cyber_user_accounts.approval_id')->where('cyber_user_accounts.id', '=', $id)->get();

        return response()->json($fetchdeactivaterequest);
    }

    public function revision(Request $request)
    {
        CyberUserAccount::select('*')->where('preparer_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'status' => 'revision',
            'comment' => $request->comment,
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Revised Deactivate Access for NPK ' . User::where('id', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Comment to Revision Successfully!', 'Approval "' . $request->document_name . '" successfully commented!');
        return redirect('approval/indexDeactivate');
    }

    public function generatePdf($id)
    {
        $userDeactivateRequest = CyberUserAccount::select('cyber_user_accounts.*', 'users.name', 'users.dept', 'users.npk', 'signatures.signature_img')->leftJoin('users', 'users.id', '=', 'cyber_user_accounts.approval_id')->leftJoin('signatures', 'signatures.user_id', '=', 'cyber_user_accounts.approval_id')->where('deactivation_request_id', $id)->get();
        $employee = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->where('BIODATA.NPK', '=', $userDeactivateRequest[0]->employee_id)->get();

        // dd($employee);
        $pdf = Pdf::loadView('template.cyber-user-account', compact('userDeactivateRequest', 'employee'))->setOptions(['defaultFont' => 'sans-serif']);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename=' . $id . '.pdf');
        // I: Show to Browser, D: Download, F: Save to File, S: Return as String
        // return PDF::Output('Signature.pdf', 'I');
        // PDF::Output(storage_path('app/public/document/') . $new_filename, 'F');

        $directory = storage_path('app/public/deactivate_request/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $pdf->save($directory . $id . '.pdf');

        // Open file in new tab
        // return PDF::Output($id . 'pdf', 'I');

        // Storage::put('public/it_access_pdfs/' . $id . '.pdf', $pdf->output());
    }
    public function void(Request $request)
    {
        $approval = CyberUserAccount::select('*')->where('deactivation_request_id', '=', $request->deactivation_request_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'true',
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Void Deactivate Access for NPK ' . User::where('id', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Void Successfully!', 'Cyber User Request For "' . $request->document_name . '" successfully voided!');
        return redirect('approval/indexDeactivate');
    }

    public function restore(Request $request)
    {
        $approval = CyberUserAccount::select('*')->where('deactivation_request_id', '=', $request->deactivation_request_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'false',
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Restore Deactivate Access for NPK ' . User::where('id', '=', $request->employee_id)->first()->npk,
            'menu' => 'Cyber User Account',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Restore Successfully!', 'Cyber User Request For "' . $request->document_name . '" successfully restored!');
        return redirect('approval/indexDeactivate');
    }
}
