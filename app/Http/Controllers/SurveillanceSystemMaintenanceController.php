<?php

namespace App\Http\Controllers;

use App\Models\AnswerSurveillanceQuestionnaire;
use App\Models\ItemQuestionnaireSurveillance;
use App\Models\SurveillanceSystemMaintenance;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $surveillanceSystemMaintenance  = SurveillanceSystemMaintenance::orderBy('id', 'desc')->first();
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
        $performerId = User::where('npk', '=', 'C-00983')->first();
        // dd($performerId);
        $ITHeadId = User::where('npk', '=', 'C-00827')->first();

        SurveillanceSystemMaintenance::create([
            'surveillance_system_maintenance_id' => $request->surveillance_system_maintenance_id,
            'date_of_maintenance' => $request->date_of_maintenance,
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
            'answer' => $request->recommendation_replacement,
        ]);

        Alert::success('Created Successfully!', 'Surveillance System Maintenance successfully created!');
        return redirect()->intended('approval/indexSurveillance');
    }
}
