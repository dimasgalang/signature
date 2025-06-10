<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\ItemClearance;
use App\Models\ItemService;
use App\Models\ServiceClearance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ClearanceController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $clearances = Clearance::with(['item_clearance', 'clearanceName', 'receiverName'])
                ->where('void', $request->void)->orderBy('date', 'desc')
                ->get();
        } else {
            $clearances = Clearance::with(['item_clearance', 'clearanceName', 'receiverName'])
                ->where('void', 'false')->orderBy('date', 'desc')
                ->get();
        }
        return view('clearance.index', compact('clearances'));
    }

    public function create()
    {
        $users = User::all();
        // $items = Item::all();

        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $services = ServiceClearance::all();
        $clearance = Clearance::all()->last();
        // dd('HO' . date('y') . date('n') . date('d') . str_pad(intval(substr($handover?->document_name, -4)) + 1, 4, '0', STR_PAD_LEFT));
        return view('clearance.create', compact('users', 'items', 'clearance', 'services'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $clearance = Clearance::create([
            'clearance_name_id' => $request->clearance_name_id,
            'receiver_name_id' => $request->receiver_name_id,
            'department' => $request->receiverDepartment,
            'document_name' => $request->documentName,
            'date' => $request->clearanceDate,
        ]);

        foreach ($request->product_id as $key => $value) {
            $item = new ItemClearance();
            $item->clearance_id = $clearance->id;
            $item->item_id = $value['barang_code'];
            $item->quantity = $value['quantity'];
            $item->save();
        }

        foreach ($request->service_id as $key => $value) {
            $service = new ItemService();
            $service->clearance_id = $clearance->id;
            $service->clearance_code = $value;
            $service->save();
        }

        // Generate PDF and save it to storage
        $pdfClearance = $this->generatePDF($clearance->id, $request->documentName);

        // // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfClearance->output());

        // // Set the file name and save the PDF to storage
        $originalName = sha1($request->documentName) . '.pdf';

        Storage::put('public/clearance_pdfs/' . $originalName, $pdfClearance->output());

        // updating handover to saving document name and base64
        $clearance->document_name = $request->documentName;
        $clearance->original_name = $originalName;
        $clearance->base64 = $pdfToBase64;
        $clearance->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('clearance/index');
    }

    public function generatePDF(String $id, String $documentName)
    {
        $clearance = Clearance::with(['item_clearance', 'clearanceName', 'receiverName'])->find($id);
        // $itemHandover = DB::select("SELECT ih.*, i.productName AS item_name FROM item_handovers ih INNER JOIN handovers h ON ih.handover_id = h.id INNER JOIN items i ON ih.item_id = i.id WHERE h.id = ? ", [$id]);
        $itemClearance = DB::select("SELECT ic.* FROM item_clearances ic WHERE ic.clearance_id = ?", [$id]);
        // dd($handover);
        $itemData = [];
        foreach ($itemClearance as $item) {
            $itemsSmartIT = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name', 'satuan_code')->where('barang_status', '=', 'Active')->where('barang_code', '=', $item->item_id)->get();
            $data = array(
                'item_id' => $itemsSmartIT[0]->barang_code,
                'item_name' => $itemsSmartIT[0]->barang_name,
                'quantity' => $item->quantity,
                'item_unit' => $itemsSmartIT[0]->satuan_code,
            );
            $itemData[] = $data;
        }

        // ambil service dari table item service yang relasi ke table service_clearance berdasarkan clearance id
        $services = DB::table('item_services')
            ->join('service_clearances', 'item_services.clearance_code', '=', 'service_clearances.clearance_code')
            ->where('item_services.clearance_id', $id)
            ->select('item_services.clearance_id', 'service_clearances.clearance_name')
            ->get();

        // foreach($itemData as $list) {
        //     dd($list['item_name']);
        // }
        // dd($itemData);
        // $pdf = PDF::loadView('template.handover', compact(['handover', 'itemHandover']));
        $pdf = Pdf::loadView('template.clearance', compact(['clearance', 'itemData', 'services']));

        return $pdf;
    }

    public function fetchDept($id_user)
    {
        $users = User::findOrFail($id_user);
        return response()->json($users);
    }

    public function revision(Request $request)
    {
        $users = User::all();
        // $items = Item::all();
        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $clearance = Clearance::find($request->id);
        $itemClearance = DB::select("SELECT ic.* FROM item_clearances ic INNER JOIN clearances c ON ic.clearance_id = c.id WHERE c.id = ? ", [$request->id]);
        $itemServices = DB::select("SELECT sc.* FROM service_clearances sc INNER JOIN clearances c ON sc.clearance_id = c.id WHERE c.id = ? ", [$request->id]);

        return view('clearance.revision', compact('users', 'items', 'clearance', 'itemClearance'));
    }
}
