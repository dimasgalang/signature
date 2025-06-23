<?php

namespace App\Http\Controllers;

use App\Models\ItemLeaver;
use App\Models\ItemService;
use App\Models\Leaver;
use App\Models\ServiceLeaver;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class LeaverController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $leavers = Leaver::with(['item_leaver', 'leaverName', 'receiverName'])
                ->where('void', $request->void)->orderBy('date', 'desc')
                ->get();
        } else {
            $leavers = Leaver::with(['item_leaver', 'leaverName', 'receiverName'])
                ->where('void', 'false')->orderBy('date', 'desc')
                ->get();
        }
        return view('leaver.index', compact('leavers'));
    }

    public function create()
    {
        $users = User::all();
        // $items = Item::all();

        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $services = ServiceLeaver::all();
        $leaver = Leaver::all()->last();
        // dd('HO' . date('y') . date('n') . date('d') . str_pad(intval(substr($handover?->document_name, -4)) + 1, 4, '0', STR_PAD_LEFT));
        return view('leaver.create', compact('users', 'items', 'leaver', 'services'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $leaver = Leaver::create([
            'leaver_name_id' => $request->leaver_name_id,
            'receiver_name_id' => $request->receiver_name_id,
            'department' => $request->receiverDepartment,
            'document_name' => $request->documentName,
            'date' => $request->leaverDate,
        ]);

        foreach ($request->product_id as $key => $value) {
            $item = new ItemLeaver();
            $item->leaver_id = $leaver->id;
            $item->item_id = $value['barang_code'];
            $item->quantity = $value['quantity'];
            $item->save();
        }

        foreach ($request->service_id as $key => $value) {
            $service = new ItemService();
            $service->leaver_id = $leaver->id;
            $service->leaver_code = $value;
            $service->save();
        }

        // Generate PDF and save it to storage
        $pdfLeaver = $this->generatePDF($leaver->id, $request->documentName);

        // // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfLeaver->output());

        // // Set the file name and save the PDF to storage
        $originalName = sha1($request->documentName) . '.pdf';

        Storage::put('public/leaver_pdfs/' . $originalName, $pdfLeaver->output());

        // updating handover to saving document name and base64
        $leaver->document_name = $request->documentName;
        $leaver->original_name = $originalName;
        $leaver->base64 = $pdfToBase64;
        $leaver->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('leaver/index');
    }

    public function generatePDF(String $id, String $documentName)
    {
        $leaver = Leaver::with(['item_leaver', 'leaverName', 'receiverName'])->find($id);
        // $itemHandover = DB::select("SELECT ih.*, i.productName AS item_name FROM item_handovers ih INNER JOIN handovers h ON ih.handover_id = h.id INNER JOIN items i ON ih.item_id = i.id WHERE h.id = ? ", [$id]);
        $itemLeaver = DB::select("SELECT il.* FROM item_leavers il WHERE il.leaver_id = ?", [$id]);
        // dd($handover);
        $itemData = [];
        foreach ($itemLeaver as $item) {
            $itemsSmartIT = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name', 'satuan_code')->where('barang_status', '=', 'Active')->where('barang_code', '=', $item->item_id)->get();
            $data = array(
                'item_id' => $itemsSmartIT[0]->barang_code,
                'item_name' => $itemsSmartIT[0]->barang_name,
                'quantity' => $item->quantity,
                'item_unit' => $itemsSmartIT[0]->satuan_code,
            );
            $itemData[] = $data;
        }

        // ambil service dari table item service yang relasi ke table service_leaver berdasarkan leaver id
        $services = DB::table('item_services')
            ->join('service_leavers', 'item_services.leaver_code', '=', 'service_leavers.leaver_code')
            ->where('item_services.leaver_id', $id)
            ->select('item_services.leaver_id', 'service_leavers.leaver_name')
            ->get();

        // foreach($itemData as $list) {
        //     dd($list['item_name']);
        // }
        // dd($itemData);
        // $pdf = PDF::loadView('template.handover', compact(['handover', 'itemHandover']));
        $pdf = Pdf::loadView('template.leaver', compact(['leaver', 'itemData', 'services']));

        return $pdf;
    }

    public function fetchDept($id_user)
    {
        $users = User::findOrFail($id_user);
        return response()->json($users);
    }

    public function createApproval($id)
    {
        $leaver = Leaver::findOrFail($id);
        $users = User::all();
        return view('leaver.createApprove', compact(['users', 'leaver']));
    }


    public function revision(Request $request)
    {
        $users = User::all();
        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $leaver = Leaver::find($request->id);
        $itemLeaver = DB::select("SELECT il.* FROM item_leavers il INNER JOIN leavers c ON il.leaver_id = c.id WHERE c.id = ? ", [$request->id]);
        // $itemServices = DB::select("SELECT sc.* FROM service_leavers sc INNER JOIN leavers c ON sc.leaver_id = c.id WHERE c.id = ? ", [$request->id]);
        $services = ServiceLeaver::all();
        $itemServices = DB::table('item_services')
            ->join('service_leavers', 'item_services.leaver_code', '=', 'service_leavers.leaver_code')
            ->where('item_services.leaver_id', $request->id)
            ->select('item_services.*', 'service_leavers.leaver_name')
            ->get();

        // dd($itemServices);

        return view('leaver.revision', compact('users', 'items', 'leaver', 'itemLeaver', 'services', 'itemServices'));
    }


    public function update(Request $request)
    {
        // dd($request->all());
        $itemsToDelete = json_decode($request->input('items_to_delete'), true);
        if (!empty($itemsToDelete)) {
            // Delete old items from the database
            ItemLeaver::whereIn('id', $itemsToDelete)->delete();
        }

        $servicesToDelete = json_decode($request->input('services_to_delete'), true);
        if (!empty($servicesToDelete)) {
            // Delete old services from the database
            ItemService::whereIn('id', $servicesToDelete)->delete();
        }

        $leaver = Leaver::find($request->leaver_id);
        // delete old file document if exists
        if ($leaver->document_name) {
            Storage::delete('public/leaver_pdfs/' . $leaver->original_name);
        }

        $leaver->leaver_name_id = $request->leaver_name_id;
        $leaver->receiver_name_id = $request->receiver_name_id;
        $leaver->department = $request->receiverDepartment;
        $leaver->save();

        // update data item leaver secara manual tanpa menghapus data yang ada
        foreach ($request->product_id as $key => $value) {
            // If items exist, update each one
            if (isset($value['id'])) {
                $items = ItemLeaver::where('leaver_id', $request->leaver_id)
                    ->where('id', $value['id'])->get();
                foreach ($items as $item) {
                    $item->leaver_id = $request->leaver_id;
                    $item->item_id = $value['item_id'];
                    $item->quantity = $value['quantity'];
                    $item->save();
                }
                // If id is null, create a new item
            } else {
                $item = new ItemLeaver();
                $item->leaver_id = $request->leaver_id;
                $item->item_id = $value['item_id'];
                $item->quantity = $value['quantity'];
                $item->save();
            }
        }

        // update data item service secara manual tanpa menghapus data yang ada
        foreach ($request->service_id as $key => $value) {
            // If items exist, update each one
            if (isset($value['id'])) {
                $services = ItemService::where('leaver_id', $request->leaver_id)
                    ->where('id', $value['id'])->get();
                foreach ($services as $service) {
                    $service->leaver_id = $request->leaver_id;
                    $service->leaver_code = $value['service_id'];
                    $service->save();
                }
                // If id is null, create a new item
            } else {
                $service = new ItemService();
                $service->leaver_id = $request->leaver_id;
                $service->leaver_code = $value['service_id'];
                $service->save();
            }
        }


        // Generate PDF and save it to storage
        $pdfLeaver = $this->generatePDF($leaver->id, $request->documentName);

        // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfLeaver->output());

        // Set the file name and save the PDF to storage
        $originalName = sha1($request->documentName) . '.pdf';

        Storage::put('public/leaver_pdfs/' . $originalName, $pdfLeaver->output());

        // updating handover to saving document name and base64
        $leaver->document_name = $request->documentName;
        $leaver->original_name = $originalName;
        $leaver->base64 = $pdfToBase64;
        $leaver->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('leaver/index');
    }
}
