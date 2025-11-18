<?php

namespace App\Http\Controllers;

use App\Models\AnswerFingerInspectQuestionnaire;
use App\Models\FingerInspection;
use App\Models\ItemQuestionnaireSurveillance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class FingerInspectionController extends Controller
{
    public function create()
    {
        $PICId = User::where('npk', '=', 'C-00983')->first();

        $fingerCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'h')->get();

        $fingerInspection = FingerInspection::orderBy('id', 'desc')->first();
        $prefix = 'FINP';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        $fingerDocs = DB::connection('docstore')->table('inventoryqr')->select('inventoryqr.*')->join('inventory_category', 'inventoryqr.item_number', '=', 'inventory_category.item_number')->where('inventory_category.category', 'Finger')->get();

        if (isset($fingerInspection) && preg_match('/^FINP(\d{6})(\d{2})$/', $fingerInspection->finger_inspection_id, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }

        $newIdfingerInspection = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('finger-inspection.create', compact(['PICId', 'fingerCheckItems','newIdfingerInspection', 'fingerDocs']));
    }

    public function store(Request $request)
    {
        // simpan sendiri assets_number di array list
        $assetsNumbers = [];
        // dd($request->all());

        foreach ($request->finger_inspection as $inspectionData) {
            $assetsNumbers[] = $inspectionData['machine_number'];
            FingerInspection::create([
                'finger_inspection_id' => $request->finger_inspection_id,
                'machine_number' => $inspectionData['machine_number'],
                'date_of_inspection' => $inspectionData['date_of_inspection'],
                'person_in_charge' => $request->person_in_charge,
                'void' => 'false',
            ]);

            foreach ($inspectionData['check_item'] as $questionnaireId => $answer) {
                DB::table('answer_finger_inspect_questionnaires')->insert([
                    'finger_inspection_id' => $request->finger_inspection_id,
                    'machine_number' => $inspectionData['machine_number'],
                    'questionnaire_id' => $questionnaireId,
                    'answer' => $answer,
                    'notes' => null,
                    'month' => date('m', strtotime($inspectionData['date_of_inspection'])),
                    'year' => date('Y', strtotime($inspectionData['date_of_inspection'])),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $fetchFingerList = DB::connection('docstore')->table('inventoryqr')->join('inventory_category', 'inventoryqr.item_number', '=', 'inventory_category.item_number')->where('inventory_category.category', 'Finger')->get();
        $checkItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'h')->get();
        foreach ($fetchFingerList as $finger) {
            if (!in_array($finger->assets_number, $assetsNumbers)) {
                FingerInspection::create([
                    'finger_inspection_id' => $request->finger_inspection_id,
                    'machine_number' => $finger->assets_number,
                    'date_of_inspection' => $request->finger_inspection[0]['date_of_inspection'],
                    'person_in_charge' => $request->person_in_charge,
                    'void' => 'false',
                ]);

                foreach ($checkItems as $item) {
                    DB::table('answer_finger_inspect_questionnaires')->insert([
                        'finger_inspection_id' => $request->finger_inspection_id,
                        'machine_number' => $finger->assets_number,
                        'questionnaire_id' => $item->id,
                        'answer' => 'true',
                        'notes' => null,
                        'month' => date('m', strtotime($request->finger_inspection[0]['date_of_inspection'])),
                        'year' => date('Y', strtotime($request->finger_inspection[0]['date_of_inspection'])),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Alert::success('Created Successfully!', 'finger Inspection successfully created!');
        return redirect()->intended('finger-inspection/index');
    }

    public function index(Request $request)
    {
        if ($request->void) {
            $fingerInspections = FingerInspection::where('void', $request->void)
            ->groupBy('finger_inspection_id', 'void')
            ->select('void','finger_inspection_id', DB::raw('MAX(date_of_inspection) as date_of_inspection'))
            ->orderBy('date_of_inspection', 'desc')
            ->get();
        } else {
            $fingerInspections = FingerInspection::where('void', 'false')
            ->groupBy('finger_inspection_id', 'void')
            ->select('void','finger_inspection_id', DB::raw('MAX(date_of_inspection) as date_of_inspection'))
            ->orderBy('date_of_inspection', 'desc')
            ->get();
        }

        return view('finger-inspection/index', compact('fingerInspections'));
    }

    public function fetchFingerInfo($assets_number)
    {
        $fingerInfo = DB::connection('docstore')->table('inventoryqr')->join('inventory_category', 'inventoryqr.item_number', '=', 'inventory_category.item_number')->where('inventory_category.category', 'Finger')->andWhere('inventoryqr.assets_number', $assets_number)->first();
        if ($fingerInfo) {
            return response()->json([
                'status' => 'success',
                'data' => $fingerInfo
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Finger not found'
            ], 404);
        }
    }

    public function export($fromDate, $toDate)
    {
        $fromDate = $fromDate . '-01';
        $toDate = $toDate . '-31';
        $fingerList = FingerInspection::whereBetween('date_of_inspection', [$fromDate, $toDate])
            ->select('machine_number', DB::raw('MIN(date_of_inspection) as date_of_inspection'))
            ->groupBy('machine_number')
            ->orderBy('machine_number', 'asc')
            ->get();

        $sensor = AnswerFingerInspectQuestionnaire::where('questionnaire_id', 77)->orderBy('month', 'asc')->get();
        $sensorAnswersGrouped = $sensor->groupBy('machine_number');

        $led = AnswerFingerInspectQuestionnaire::where('questionnaire_id', 78)->orderBy('month', 'asc')->get();
        $ledAnswersGrouped = $led->groupBy('machine_number');

        $powerCable = AnswerFingerInspectQuestionnaire::where('questionnaire_id', 79)->orderBy('month', 'asc')->get();
        $powerCableAnswersGrouped = $powerCable->groupBy('machine_number');

        $electricity = AnswerFingerInspectQuestionnaire::where('questionnaire_id', 80)->orderBy('month', 'asc')->get();
        $electricityAnswersGrouped = $electricity->groupBy('machine_number');

        $inspectionPerson = User::where('npk', 'C-00983')->join('signatures', 'users.id', '=', 'signatures.user_id')->select('users.name', 'signatures.signature_img')->first();
        // return view('template.finger-inspection', compact(['fingerList', 'inspectionPerson', 'bodyPCAnswersGrouped', 'kipasAnswersGrouped', 'motherboardAnswersGrouped', 'ramAnswersGrouped', 'storageAnswersGrouped', 'cabelAnswersGrouped', 'monitorAnswersGrouped', 'keyboardAnswersGrouped', 'mouseAnswersGrouped', 'applicationAnswersGrouped', 'antivirusAnswersGrouped', 'licenseAnswersGrouped', 'conditionAnswersGrouped']));
        
        $pdf = Pdf::loadView('template.finger-inspection', compact(['fingerList', 'inspectionPerson', 'sensorAnswersGrouped', 'ledAnswersGrouped', 'powerCableAnswersGrouped', 'electricityAnswersGrouped']))->setOptions(['defaultFont' => 'DejaVu Sans']);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename=' . $fromDate . '-' . $toDate . '.pdf');

        $directory = storage_path('app/public/finger_inspection/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function fetchInspections($finger_inspection_id)
    {
        $fingerInspections = FingerInspection::where('finger_inspection_id', $finger_inspection_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $fingerInspections
        ]);
    }

    public function edit($id)
    {
        $fingerCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'h')->get();
        
        $fingerInspection = FingerInspection::where('id', $id)->get()->first();
        $fingerAnswerItems = AnswerFingerInspectQuestionnaire::where('finger_inspection_id', $fingerInspection->finger_inspection_id)->where('machine_number', $fingerInspection->machine_number)->get();        

        return view('finger-inspection.edit', compact('fingerInspection', 'fingerCheckItems', 'fingerAnswerItems'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $fingerInspection = FingerInspection::where('id', $request->id)->first();

        foreach ($request->finger_inspection['check_item'] as $questionnaireId => $answer) {
            AnswerFingerInspectQuestionnaire::where('finger_inspection_id', $fingerInspection->finger_inspection_id)
                ->where('machine_number', $fingerInspection->machine_number)
                ->where('questionnaire_id', $questionnaireId)
                ->update(['answer' => $answer]);
        }

        Alert::success('Updated Successfully!', 'Finger Inspection successfully updated!');
        return redirect()->intended('finger-inspection/index');
    }

    public function void(Request $request)
    {
        // dd($request->all());
        FingerInspection::where('finger_inspection_id', $request->finger_inspection_id)->update(['void' => 'true']);
        Alert::success('Void Successfully!', 'Finger Inspection successfully void!');
        return redirect()->intended('finger-inspection/index');
    }

    public function restore(Request $request)
    {
        // dd($request->all());
        FingerInspection::where('finger_inspection_id', $request->finger_inspection_id)->update(['void' => 'false']);
        Alert::success('Restore Successfully!', 'Finger Inspection successfully restored!');
        return redirect()->intended('finger-inspection/index');
    }
}
