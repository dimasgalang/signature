<?php

namespace App\Http\Controllers;

use App\Models\AnswerCompInspectQuestionnaire;
use App\Models\ComputerInspection;
use App\Models\ItemQuestionnaireSurveillance;
use App\Models\SurveillanceSystemMaintenance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputerInspectionController extends Controller
{
    public function index()
    {
        $computerInspections = ComputerInspection::orderBy('created_at', 'desc')->get();
        return view('computer-inspection.index', compact('computerInspections'));
    }

    public function create()
    {
        $PICId = User::where('npk', '=', 'C-00983')->first();

        $hardwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'e')->get();
        $softwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'f')->get();
        $computerConditions = ItemQuestionnaireSurveillance::where('id', 75)->get();
        
        $computerInspection = ComputerInspection::orderBy('id', 'desc')->first();
        $prefix = 'CMPI';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        $computerDocs = DB::connection('docstore')->table('inventoryqr')->select('inventoryqr.*', 'inventory_it.user')->join('inventory_category', 'inventoryqr.item_number', '=', 'inventory_category.item_number')->join('inventory_it', 'inventoryqr.assets_number', '=', 'inventory_it.assets_number')->where('inventory_category.category', 'Computer')->orWhere('inventory_category.category', 'Laptop')->get();

        if (isset($computerInspection) && preg_match('/^CMPI(\d{6})(\d{2    })$/', $computerInspection->computer_inspection_id, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }

        $newIdComputerInspection = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('computer-inspection.create', compact(['PICId', 'hardwareCheckItems', 'softwareCheckItems', 'newIdComputerInspection', 'computerDocs', 'computerConditions'])); 
    }

    public function store(Request $request)
    {
        // simpan sendiri assets_number di array list
        $assetsNumbers = [];
        
        foreach ($request->computer_inspection as $inspectionData) {
            $assetsNumbers[] = $inspectionData['assets_number'];
            ComputerInspection::create([
                'computer_inspection_id' => $request->computer_inspection_id,
                'assets_number' => $inspectionData['assets_number'],
                'user' => $inspectionData['user'],
                'device_name' => $inspectionData['assets_number'],
                'location' => $inspectionData['location'],
                'date_of_inspection' => $inspectionData['date_of_inspection'],
                'person_in_charge' => $request->person_in_charge,
            ]);

            foreach ($inspectionData['check_item'] as $questionnaireId => $answer) {
                DB::table('answer_comp_inspect_questionnaires')->insert([
                    'computer_inspection_id' => $request->computer_inspection_id,
                    'assets_number' => $inspectionData['assets_number'],
                    'questionnaire_id' => $questionnaireId,
                    'answer' => $answer,
                    'notes' => null,
                    'month' => date('m', strtotime($inspectionData['date_of_inspection'])),
                    'year' => date('Y', strtotime($inspectionData['date_of_inspection'])),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('answer_comp_inspect_questionnaires')->insert([
                    'computer_inspection_id' => $request->computer_inspection_id,
                    'assets_number' => $inspectionData['assets_number'],
                    'questionnaire_id' => 75,
                    'answer' => $inspectionData['condition'],
                    'notes' => $inspectionData['additional_notes'] ?? null,
                    'month' => date('m', strtotime($inspectionData['date_of_inspection'])),
                    'year' => date('Y', strtotime($inspectionData['date_of_inspection'])),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }

        $fetchComputerList = DB::connection('docstore')->table('inventory_it')->select('inventory_it.assets_number', 'inventory_it.user', 'inventory_it.location', 'inventory_it.incoming_date')->where('inventory_it.incoming_date', '<=', $request->computer_inspection[0]['date_of_inspection'])->get();
        $checkItems = ItemQuestionnaireSurveillance::whereIn('questionnaire_category_id', ['e', 'f', 'g'])->where('id', '!=', 76)->get();
        foreach ($fetchComputerList as $computer) {
            if (!in_array($computer->assets_number, $assetsNumbers)) {
                ComputerInspection::create([
                    'computer_inspection_id' => $request->computer_inspection_id,
                    'assets_number' => $computer->assets_number,
                    'user' => $computer->user,
                    'device_name' => $computer->assets_number,
                    'location' => $computer->location,
                    'date_of_inspection' => $request->computer_inspection[0]['date_of_inspection'],
                    'person_in_charge' => $request->person_in_charge,
                ]);

                foreach ($checkItems as $item) {
                    DB::table('answer_comp_inspect_questionnaires')->insert([
                        'computer_inspection_id' => $request->computer_inspection_id,
                        'assets_number' => $computer->assets_number,
                        'questionnaire_id' => $item->id,
                        'answer' => 'true',
                        'notes' => null,
                        'month' => date('m', strtotime($request->computer_inspection[0]['date_of_inspection'])),
                        'year' => date('Y', strtotime($request->computer_inspection[0]['date_of_inspection'])),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function fetchComputerInfo($assets_number)
    {

        $computerInfo = DB::connection('docstore')->table('inventory_it')->select('inventory_it.assets_number', 'inventory_it.user', 'inventory_it.location')->where('inventory_it.assets_number', $assets_number)->first();
        if ($computerInfo) {
            return response()->json([
                'status' => 'success',
                'data' => $computerInfo
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Computer not found'
            ], 404);
        }
    }

    public function export()
    {
        $hardwareQuestionaireItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'e')->get();
        $softwareQuestionaireItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'f')->get();

        $fromDate = '2025-01-01';
        $toDate = '2025-12-31';
        $computerList = ComputerInspection::whereBetween('date_of_inspection', [$fromDate, $toDate])
            ->select('device_name', 'user', 'location', DB::raw('MIN(date_of_inspection) as date_of_inspection'))
            ->groupBy('device_name', 'user', 'location')
            ->orderBy('device_name', 'asc')
            ->get();        

        $bodyPC = AnswerCompInspectQuestionnaire::where('questionnaire_id', 61)->get();
        $bodyPCAnswersGrouped = $bodyPC->groupBy('assets_number');

        dd($bodyPCAnswersGrouped);
        // $computerInspections = ComputerInspection::orderBy('created_at', 'desc')->get();
        return view('template.computer-inspection', compact(['computerList', 'hardwareQuestionaireItems', 'softwareQuestionaireItems', 'bodyPCAnswersGrouped']));
    }
}
