<?php

namespace App\Http\Controllers;

use App\Models\AnswerCompInspectQuestionnaire;
use App\Models\ComputerInspection;
use App\Models\ItemQuestionnaireSurveillance;
use App\Models\SurveillanceSystemMaintenance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ComputerInspectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->void) {
            $computerInspections = ComputerInspection::where('void', $request->void)
                ->groupBy('computer_inspection_id', 'void')
                ->select('void', 'computer_inspection_id', DB::raw('MAX(date_of_inspection) as date_of_inspection'))
                ->orderBy('date_of_inspection', 'desc')
                ->get();
        } else {
            $computerInspections = ComputerInspection::where('void', 'false')
                ->groupBy('computer_inspection_id', 'void')
                ->select('void', 'computer_inspection_id', DB::raw('MAX(date_of_inspection) as date_of_inspection'))
                ->orderBy('date_of_inspection', 'desc')
                ->get();
        }

        return view('computer-inspection.index', compact('computerInspections'));
    }

    public function create()
    {
        $PICId = User::where('npk', '=', 'C-00983')->first();

        $hardwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'e')->get();
        $softwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'f')->get();
        $computerConditions = ItemQuestionnaireSurveillance::where('id', 35)->get();

        $computerInspection = ComputerInspection::orderBy('id', 'desc')->first();
        $prefix = 'CMPI';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        $computerDocs = DB::connection('docstore')->table('inventoryqr')->select('inventoryqr.*', 'inventory_it.user')->join('inventory_category', 'inventoryqr.item_number', '=', 'inventory_category.item_number')->join('inventory_it', 'inventoryqr.assets_number', '=', 'inventory_it.assets_number')->where('inventory_category.category', 'Computer')->orWhere('inventory_category.category', 'Laptop')->get();

        if (isset($computerInspection) && preg_match('/^CMPI(\d{6})(\d{2})$/', $computerInspection->computer_inspection_id, $matches)) {
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
                'void' => 'false',
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
                'questionnaire_id' => 35,
                'answer' => $inspectionData['condition'],
                'notes' => $inspectionData['additional_notes'] ?? null,
                'month' => date('m', strtotime($inspectionData['date_of_inspection'])),
                'year' => date('Y', strtotime($inspectionData['date_of_inspection'])),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $fetchComputerList = DB::connection('docstore')->table('inventory_it')->select('inventory_it.assets_number', 'inventory_it.user', 'inventory_it.location', 'inventory_it.incoming_date')->whereRaw("CAST(inventory_it.incoming_date AS DATE) <= ?", [$request->computer_inspection[0]['date_of_inspection']])->get();
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
                    'void' => 'false',
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

        Alert::success('Created Successfully!', 'Computer Inspection successfully created!');
        return redirect()->intended('computer-inspection/index');
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

    public function export($fromMonth, $toMonth)
    {
        $fromDate = $fromMonth . '-01';
        $toDate = $toMonth . '-31';

        $fromParts = explode('-', $fromMonth);
        $toParts = explode('-', $toMonth);

        $fromYear = $fromParts[0];
        $fromMonth = $fromParts[1];
        $toMonth = $toParts[1];

        $computerList = ComputerInspection::whereBetween('date_of_inspection', [$fromDate, $toDate])
            ->select('device_name', 'user', 'location', DB::raw('MIN(date_of_inspection) as date_of_inspection'))

            ->groupBy('device_name', 'user', 'location')
            ->orderBy('device_name', 'asc')
            ->get();

        $bodyPC = AnswerCompInspectQuestionnaire::where('questionnaire_id', 23)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $bodyPCAnswersGrouped = $bodyPC->groupBy('assets_number');

        $kipas = AnswerCompInspectQuestionnaire::where('questionnaire_id', 24)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $kipasAnswersGrouped = $kipas->groupBy('assets_number');

        $motherboard = AnswerCompInspectQuestionnaire::where('questionnaire_id', 25)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $motherboardAnswersGrouped = $motherboard->groupBy('assets_number');

        $ram = AnswerCompInspectQuestionnaire::where('questionnaire_id', 26)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $ramAnswersGrouped = $ram->groupBy('assets_number');

        $storage = AnswerCompInspectQuestionnaire::where('questionnaire_id', 27)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $storageAnswersGrouped = $storage->groupBy('assets_number');

        $cabel = AnswerCompInspectQuestionnaire::where('questionnaire_id', 28)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $cabelAnswersGrouped = $cabel->groupBy('assets_number');

        $monitor = AnswerCompInspectQuestionnaire::where('questionnaire_id', 29)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $monitorAnswersGrouped = $monitor->groupBy('assets_number');

        $mouse = AnswerCompInspectQuestionnaire::where('questionnaire_id', 30)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $mouseAnswersGrouped = $mouse->groupBy('assets_number');

        $keyboard = AnswerCompInspectQuestionnaire::where('questionnaire_id', 31)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $keyboardAnswersGrouped = $keyboard->groupBy('assets_number');

        $application = AnswerCompInspectQuestionnaire::where('questionnaire_id', 32)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $applicationAnswersGrouped = $application->groupBy('assets_number');

        $antivirus = AnswerCompInspectQuestionnaire::where('questionnaire_id', 33)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $antivirusAnswersGrouped = $antivirus->groupBy('assets_number');

        $license = AnswerCompInspectQuestionnaire::where('questionnaire_id', 34)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $licenseAnswersGrouped = $license->groupBy('assets_number');

        $condition = AnswerCompInspectQuestionnaire::where('questionnaire_id', 35)->where('month', '>=', $fromMonth)->where('month', '<=', $toMonth)->where('year', $fromYear)->orderBy('month', 'asc')->get();
        $conditionAnswersGrouped = $condition->groupBy('assets_number');

        // dd($bodyPCAnswersGrouped["I-0296"]);
        // $computerInspections = ComputerInspection::orderBy('created_at', 'desc')->get();
        $cabelAnswersGrouped = $cabel->groupBy('assets_number');
        $inspectionPerson = User::where('npk', 'C-00983')->join('signatures', 'users.id', '=', 'signatures.user_id')->select('users.name', 'signatures.signature_img')->first();
        // return view('template.computer-inspection', compact(['computerList', 'inspectionPerson', 'bodyPCAnswersGrouped', 'kipasAnswersGrouped', 'motherboardAnswersGrouped', 'ramAnswersGrouped', 'storageAnswersGrouped', 'cabelAnswersGrouped', 'monitorAnswersGrouped', 'keyboardAnswersGrouped', 'mouseAnswersGrouped', 'applicationAnswersGrouped', 'antivirusAnswersGrouped', 'licenseAnswersGrouped', 'conditionAnswersGrouped']));

        $pdf = Pdf::loadView('template.computer-inspection', compact(['computerList', 'inspectionPerson', 'bodyPCAnswersGrouped', 'kipasAnswersGrouped', 'motherboardAnswersGrouped', 'ramAnswersGrouped', 'storageAnswersGrouped', 'cabelAnswersGrouped', 'monitorAnswersGrouped', 'keyboardAnswersGrouped', 'mouseAnswersGrouped', 'applicationAnswersGrouped', 'antivirusAnswersGrouped', 'licenseAnswersGrouped', 'conditionAnswersGrouped']))->setOptions(['defaultFont' => 'DejaVu Sans']);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename=' . $fromDate . '-' . $toDate . '.pdf');

        $directory = storage_path('app/public/computer_inspection/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $pdf->save($directory . $fromDate . '-' . $toDate . '- Computer' . '.pdf');
    }

    public function fetchInspections($computer_inspection_id)
    {
        $computerInspections = ComputerInspection::where('computer_inspection_id', $computer_inspection_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $computerInspections
        ]);
    }

    public function edit($id)
    {
        $hardwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'e')->get();
        $softwareCheckItems = ItemQuestionnaireSurveillance::where('questionnaire_category_id', 'f')->get();
        $computerConditions = ItemQuestionnaireSurveillance::where('id', 35)->get();

        $computerInspection = ComputerInspection::where('id', $id)->get()->first();
        $hardwareAnswerItems = AnswerCompInspectQuestionnaire::where('computer_inspection_id', $computerInspection->computer_inspection_id)->where('assets_number', $computerInspection->assets_number)->get();
        $softwareAnswerItems = AnswerCompInspectQuestionnaire::where('computer_inspection_id', $computerInspection->computer_inspection_id)->where('assets_number', $computerInspection->assets_number)->get();
        $conditionAnswerItem = AnswerCompInspectQuestionnaire::where('questionnaire_id', 35)->where('computer_inspection_id', $computerInspection->computer_inspection_id)->where('assets_number', $computerInspection->assets_number)->first();

        // dd($conditionAnswerItem);
        return view('computer-inspection.edit', compact('computerInspection', 'hardwareCheckItems', 'softwareCheckItems', 'computerConditions', 'hardwareAnswerItems', 'softwareAnswerItems', 'conditionAnswerItem'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $computerInspection = ComputerInspection::where('id', $request->id)->first();

        foreach ($request->computer_inspection['check_item'] as $questionnaireId => $answer) {
            AnswerCompInspectQuestionnaire::where('computer_inspection_id', $computerInspection->computer_inspection_id)
                ->where('assets_number', $computerInspection->assets_number)
                ->where('questionnaire_id', $questionnaireId)
                ->update(['answer' => $answer]);
        }

        AnswerCompInspectQuestionnaire::where('computer_inspection_id', $computerInspection->computer_inspection_id)
            ->where('assets_number', $computerInspection->assets_number)
            ->where('questionnaire_id', 35)
            ->update([
                'answer' => $request->computer_inspection['condition'],
                'notes' => $request->computer_inspection['additional_notes'] ?? null,
            ]);

        Alert::success('Updated Successfully!', 'Computer Inspection successfully updated!');
        return redirect()->intended('computer-inspection/index');
    }

    public function void(Request $request)
    {
        // dd($request->all());
        ComputerInspection::where('computer_inspection_id', $request->computer_inspection_id)->update(['void' => 'true']);
        Alert::success('Void Successfully!', 'Computer Inspection successfully void!');
        return redirect()->intended('computer-inspection/index');
    }

    public function restore(Request $request)
    {
        // dd($request->all());
        ComputerInspection::where('computer_inspection_id', $request->computer_inspection_id)->update(['void' => 'false']);
        Alert::success('Restore Successfully!', 'Computer Inspection successfully restored!');
        return redirect()->intended('computer-inspection/index');
    }
}
