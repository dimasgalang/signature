<?php

namespace App\Http\Controllers;

use App\Models\ItemQuestionnaireSurveillance;
use App\Models\SurveillanceSystemMaintenance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
