<?php

namespace App\Http\Controllers;

use App\Models\AnswerSurveillanceQuestionnaire;
use App\Models\ItemQuestionnaireSurveillance;
use App\Models\SurveillanceSystemMaintenance;
use App\Models\SysLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use RealRashid\SweetAlert\Facades\Alert;

class SurveillanceSystemMaintenanceController extends Controller
{
    public function create()
    {
        $ItHeadId = User::where('id', '=', 1)->first();
        $performerId = User::where('npk', '=', 'C-00983')->first();

        $surveillanceCameraLensItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'a')->get();
        $checkingRecordingServer = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'b')->get();
        $checkNetworkInfrastructure = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'c')->get();
        $softwareTesting = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'd')->get();

        $surveillanceSystemMaintenance = SurveillanceSystemMaintenance::orderBy('id', 'desc')->first();
        $prefix = 'SSM';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($surveillanceSystemMaintenance) && preg_match('/^SSM(\d{6})(\d{2})$/', $surveillanceSystemMaintenance->surveillance_system_maintenance_id, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }

        $newIdSurveillanceSystemMaintenance = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('surveillance-system-maintenance.create', compact(['ItHeadId', 'performerId', 'surveillanceCameraLensItems', 'checkingRecordingServer', 'checkNetworkInfrastructure', 'softwareTesting', 'newIdSurveillanceSystemMaintenance']));
    }

    public function store(Request $request)
    {
        $random = Str::random();
        $performerId = Auth::user();
        // dd($performerId);
        $ITHeadId = User::where('npk', '=', 'C-00827')->first();

        SurveillanceSystemMaintenance::create([
            'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
            'date_of_maintenance' => $request->date_of_maintenance,
            'number_of_camera' => $request->number_of_camera,
            'number_of_server' => $request->number_of_server,
            'approval_id' => $performerId->id,
            'preparer_id' => $performerId->id,
            'approval_level' => '1',
            'approval_progress' => '1',
            'token' => $random,
            'document_name' => $request->document_name,
        ]);

        SurveillanceSystemMaintenance::create([
            'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
            'date_of_maintenance' => $request->date_of_maintenance,
            'number_of_camera' => $request->number_of_camera,
            'number_of_server' => $request->number_of_server,
            'approval_id' => $ITHeadId->id,
            'preparer_id' => $performerId->id,
            'approval_level' => '2',
            'approval_progress' => '1',
            'token' => $random,
            'document_name' => $request->document_name,
        ]);

        foreach ($request->surveillanceCameraLensItems as $itemId => $value) {
            AnswerSurveillanceQuestionnaire::create([
                'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
                'questionnaire_id' => $itemId,
                'answer' => $value,
            ]);
        }

        foreach ($request->checkingRecordingServer as $itemId => $value) {
            AnswerSurveillanceQuestionnaire::create([
                'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
                'questionnaire_id' => $itemId,
                'answer' => $value,
            ]);
        }

        foreach ($request->checkNetworkInfrastructure as $itemId => $value) {
            AnswerSurveillanceQuestionnaire::create([
                'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
                'questionnaire_id' => $itemId,
                'answer' => $value,
            ]);
        }

        foreach ($request->softwareTesting as $itemId => $value) {
            AnswerSurveillanceQuestionnaire::create([
                'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
                'questionnaire_id' => $itemId,
                'answer' => $value,
            ]);
        }

        AnswerSurveillanceQuestionnaire::create([
            'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
            'questionnaire_id' => 0, // Assuming this is the ID for 'recommendation_replacement'
            'answer' => $request->recommendation_replacement ?? '',
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
            'activity' => 'Created Surveillance System Maintenance ' . $request->surveillance_system_maintenance_id,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Created Successfully!', 'Surveillance System Maintenance successfully created!');
        return redirect()->intended('approval/indexSurveillance');
    }

    public function generatePdf($id)
    {
        $performerNpk = Auth::user()->npk;
        $surveillanceSystemMaintenance = SurveillanceSystemMaintenance::select('surveillance_system_maintenances.*', 'users.name', 'users.dept', 'users.npk', 'signatures.signature_img')->leftJoin('users', 'users.id', '=', 'surveillance_system_maintenances.approval_id')->leftJoin('signatures', 'signatures.user_id', '=', 'surveillance_system_maintenances.approval_id')->where('surveillance_system_maintenance_id', $id)->get();
        $performer = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->where('BIODATA.NPK', $performerNpk)->get();

        // dd($performer);
        $surveillanceCameraLensItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'a')->get();
        $checkingRecordingServer = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'b')->get();
        $checkNetworkInfrastructure = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'c')->get();
        $softwareTesting = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'd')->get();

        $answerSurveillanceQuestionnaires = AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $id)->get();
        // dd($employee);
        $pdf = Pdf::loadView('template.cctv-maintenance', compact('surveillanceSystemMaintenance', 'performer', 'surveillanceCameraLensItems', 'checkingRecordingServer', 'checkNetworkInfrastructure', 'softwareTesting', 'answerSurveillanceQuestionnaires'))->setOptions(['defaultFont' => 'sans-serif']);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename=' . $id . '.pdf');

        $directory = storage_path('app/public/surveillance_system_maintenance/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
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
            'activity' => 'Generated PDF for Surveillance System Maintenance ' . $id,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        $pdf->save($directory . $id . '.pdf');
    }

    public function fetchsurveillancemaintenance($id)
    {
        $fetchsurveillancemaintenance = SurveillanceSystemMaintenance::select('surveillance_system_maintenances.*', 'users.name')->leftJoin('users', 'users.id', '=', 'surveillance_system_maintenances.approval_id')->where('surveillance_system_maintenances.id', '=', $id)->get();

        return response()->json($fetchsurveillancemaintenance);
    }

    public function approved(Request $request)
    {
        $surveillanceSystemMaintenance = SurveillanceSystemMaintenance::findOrFail($request->id);
        $totalData = SurveillanceSystemMaintenance::select('surveillance_system_maintenances.*', 'users.name', 'users.email')->leftJoin('users', 'surveillance_system_maintenances.approval_id', '=', 'users.id')->where('surveillance_system_maintenances.preparer_id', '=', $request->employee_id)->where('surveillance_system_maintenances.document_name', '=', $request->document_name)->where('surveillance_system_maintenances.token', '=', $request->token)->get();

        $surveillanceSystemMaintenance->fill([
            'approval_date' => Carbon::now(),
            'status' => 'approved',
        ]);
        $surveillanceSystemMaintenance->save();

        if ($surveillanceSystemMaintenance->approval_level < count($totalData)) {
            SurveillanceSystemMaintenance::where('preparer_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress + 1,
            ]);
        } else {
            SurveillanceSystemMaintenance::where('preparer_id', '=', $request->employee_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
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
            'activity' => 'Approved Surveillance System Maintenance ' . $surveillanceSystemMaintenance->surveillance_system_maintenance_id,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Approved Successfully!', 'Document successfully approved!');
        return redirect()->intended('approval/indexSurveillance');
    }

    public function edit($id)
    {
        // $surveillanceSystemMaintenance = SurveillanceSystemMaintenance::findOrFail($id);
        $ItHeadId = User::where('id', '=', 1)->first();
        $surveillanceSystemMaintenance = DB::table('surveillance_system_maintenances')
            ->join('users as employee', 'employee.id', '=', 'surveillance_system_maintenances.preparer_id')
            ->join('users as approver', 'approver.id', '=', 'surveillance_system_maintenances.approval_id')
            ->select([
                'surveillance_system_maintenances.*',
                DB::raw('employee.name as name_performer'),
                DB::raw('employee.dept as performer_dept'),
                DB::raw('approver.name as need_approve')
            ])
            ->where('surveillance_system_maintenance_id', $id)
            ->first();

        $surveillanceCameraLensItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'a')->get();
        $checkingRecordingServer = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'b')->get();
        $checkNetworkInfrastructure = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'c')->get();
        $softwareTesting = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'd')->get();

        $answerSurveillanceQuestionnaires = AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $surveillanceSystemMaintenance->surveillance_system_maintenance_id)->get();
        // dd($answerSurveillanceQuestionnaires);
        return view('surveillance-system-maintenance.revision', compact('surveillanceSystemMaintenance', 'answerSurveillanceQuestionnaires', 'ItHeadId', 'surveillanceCameraLensItems', 'checkingRecordingServer', 'checkNetworkInfrastructure', 'softwareTesting'));
    }

    public function update(Request $request)
    {
        $surveillanceSystemMaintenance = SurveillanceSystemMaintenance::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id);
        $surveillanceSystemMaintenance->update([
            'number_of_camera' => $request->number_of_camera,
            'number_of_server' => $request->number_of_server,
        ]);
        foreach ($request->surveillanceCameraLensItems as $questionnaireId => $answer) {
            AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id)
                ->where('questionnaire_id', $questionnaireId)
                ->update(
                    ['answer' => $answer]
                );
        }

        foreach ($request->checkingRecordingServer as $questionnaireId => $answer) {
            AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id)
                ->where('questionnaire_id', $questionnaireId)
                ->update(
                    ['answer' => $answer]
                );
        }

        foreach ($request->checkNetworkInfrastructure as $questionnaireId => $answer) {
            AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id)
                ->where('questionnaire_id', $questionnaireId)
                ->update(
                    ['answer' => $answer]
                );
        }

        foreach ($request->softwareTesting as $questionnaireId => $answer) {
            AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id)
                ->where('questionnaire_id', $questionnaireId)
                ->update(
                    ['answer' => $answer]
                );
        }

        AnswerSurveillanceQuestionnaire::where('surveillance_system_maintenance_id', $request->surveillance_system_maintenance_id)
            ->where('questionnaire_id', 0)
            ->update(['answer' => $request->recommendation_replacement]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Updated Surveillance System Maintenance ' . $request->surveillance_system_maintenance_id,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Update Successfully!', 'Surveillance System Maintenance successfully updated!');
        return redirect()->intended('approval/indexSurveillance');
    }

    public function void(Request $request)
    {
        $approval = SurveillanceSystemMaintenance::select('*')->where('surveillance_system_maintenance_id', '=', $request->surveillance_system_maintenance_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'true',
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Voided Surveillance Maintenance Request For ' . $request->document_name,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Void Successfully!', 'Surveillance Maintenance Request For "' . $request->document_name . '" successfully voided!');
        return redirect('approval/indexSurveillance');
    }

    public function restore(Request $request)
    {
        $approval = SurveillanceSystemMaintenance::select('*')->where('surveillance_system_maintenance_id', '=', $request->surveillance_system_maintenance_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'false',
        ]);

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Restored Surveillance Maintenance Request For ' . $request->document_name,
            'menu' => 'Surveillance System Maintenance',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Restore Successfully!', 'Surveillance Maintenance Request For "' . $request->document_name . '" successfully restored!');
        return redirect('approval/indexSurveillance');
    }
}
