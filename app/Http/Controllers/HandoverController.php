<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Item;
use App\Models\ItemHandover;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HandoverController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $handovers = Handover::with(['item_handovers', 'handoverName', 'receiverName'])
                ->where('void', $request->void)->orderBy('date', 'desc')
                ->get();
        } else {
            $handovers = Handover::with(['item_handovers', 'handoverName', 'receiverName'])
                ->where('void', 'false')->orderBy('date', 'desc')
                ->get();
        }
        return view('handover.index', compact('handovers'));
    }

    public function create()
    {
        $users = User::all();
        // $items = Item::all();

        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $handover = Handover::all()->last();
        // dd('HO' . date('y') . date('n') . date('d') . str_pad(intval(substr($handover?->document_name, -4)) + 1, 4, '0', STR_PAD_LEFT));
        return view('handover.create', compact('users', 'items', 'handover'));
    }

    public function store(Request $request)
    {
        $handover = Handover::create([
            'handover_name_id' => $request->handover_name_id,
            'receiver_name_id' => $request->receiver_name_id,
            'department' => $request->receiverDepartment,
            'document_name' => $request->documentName,
            'date' => $request->handoverDate,
        ]);

        foreach ($request->product_id as $key => $value) {
            $item = new ItemHandover();
            $item->handover_id = $handover->id;
            $item->item_id = $value['barang_code'];
            $item->quantity = $value['quantity'];
            $item->save();
        }

        // Generate PDF and save it to storage
        $pdfHandover = $this->generatePDF($handover->id, $request->documentName);

        // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfHandover->output());

        // Set the file name and save the PDF to storage
        $originalName = sha1($request->documentName) . '.pdf';

        Storage::put('public/handover_pdfs/' . $originalName, $pdfHandover->output());

        // updating handover to saving document name and base64
        $handover->document_name = $request->documentName;
        $handover->original_name = $originalName;
        $handover->base64 = $pdfToBase64;
        $handover->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('handover/index');
    }

    public function fetchHandover($id)
    {
        $fetchHandover = Handover::select('handovers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'handovers.handover_name_id')->where('handovers.id', '=', $id)->get();
        // dd($fetchapproval);
        return response()->json($fetchHandover);
    }

    public function revision(Request $request)
    {
        $users = User::all();
        // $items = Item::all();
        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        $handover = Handover::find($request->id);
        $itemHandover = DB::select("SELECT ih.* FROM item_handovers ih INNER JOIN handovers h ON ih.handover_id = h.id WHERE h.id = ? ", [$request->id]);

        return view('handover.revision', compact('users', 'items', 'handover', 'itemHandover'));
    }

    public function update(Request $request)
    {
        $itemsToDelete = json_decode($request->input('items_to_delete'), true);
        if (!empty($itemsToDelete)) {
            // Delete old items from the database
            ItemHandover::whereIn('id', $itemsToDelete)->delete();
        }

        $handover = Handover::find($request->handover_id);
        // delete old file document if exists
        if ($handover->document_name) {
            Storage::delete('public/handover_pdfs/' . $handover->original_name);
        }

        $handover->handover_name_id = $request->handover_name_id;
        $handover->receiver_name_id = $request->receiver_name_id;
        $handover->department = $request->receiverDepartment;
        $handover->save();

        // update data item handover secara manual tanpa menghapus data yang ada
        foreach ($request->product_id as $key => $value) {
            // If items exist, update each one
            if (isset($value['id'])) {
                $items = ItemHandover::where('handover_id', $request->handover_id)
                    ->where('id', $value['id'])->get();
                foreach ($items as $item) {
                    $item->handover_id = $request->handover_id;
                    $item->item_id = $value['item_id'];
                    $item->quantity = $value['quantity'];
                    $item->save();
                }
                // If id is null, create a new item
            } else {
                $item = new ItemHandover();
                $item->handover_id = $request->handover_id;
                $item->item_id = $value['item_id'];
                $item->quantity = $value['quantity'];
                $item->save();
            }
        }


        // Generate PDF and save it to storage
        $pdfHandover = $this->generatePDF($handover->id, $request->documentName);

        // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfHandover->output());

        // Set the file name and save the PDF to storage
        $originalName = sha1($request->documentName) . '.pdf';

        Storage::put('public/handover_pdfs/' . $originalName, $pdfHandover->output());

        // updating handover to saving document name and base64
        $handover->document_name = $request->documentName;
        $handover->original_name = $originalName;
        $handover->base64 = $pdfToBase64;
        $handover->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('handover/index');
    }

    public function void(Request $request)
    {
        $handover = Handover::find($request->handover_id);
        $handover->void = 'true';
        $handover->save();
        Alert::success('Void Successfully!', 'Document successfully void!');
        return redirect()->intended('handover/index');
    }
    public function restore(Request $request)
    {
        $handover = Handover::find($request->handover_id);
        $handover->void = 'false';
        $handover->save();
        Alert::success('Restore Successfully!', 'Document successfully restore!');
        return redirect()->intended('handover/index');
    }

    public function generatePDF(String $id)
    {
        $handover = Handover::with(['item_handovers', 'handoverName', 'receiverName'])->find($id);
        // $itemHandover = DB::select("SELECT ih.*, i.productName AS item_name FROM item_handovers ih INNER JOIN handovers h ON ih.handover_id = h.id INNER JOIN items i ON ih.item_id = i.id WHERE h.id = ? ", [$id]);
        $itemHandover = DB::select("SELECT ih.* FROM item_handovers ih WHERE ih.handover_id = ?", [$id]);
        // dd($handover);
        $itemData = [];
        foreach ($itemHandover as $item) {
            $itemsSmartIT = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name', 'satuan_code')->where('barang_status', '=', 'Active')->where('barang_code', '=', $item->item_id)->get();
            $data = array(
                'item_id' => $itemsSmartIT[0]->barang_code,
                'item_name' => $itemsSmartIT[0]->barang_name,
                'quantity' => $item->quantity,
                'item_unit' => $itemsSmartIT[0]->satuan_code,
            );
            $itemData[] = $data;
        }

        // foreach($itemData as $list) {
        //     dd($list['item_name']);
        // }
        // dd($itemData);
        // $pdf = PDF::loadView('template.handover', compact(['handover', 'itemHandover']));
        $pdf = PDF::loadView('template.handover', compact(['handover', 'itemData']));

        return $pdf;
    }

    public function createApproval($id)
    {
        $handover = Handover::findOrFail($id);
        $users = User::all();
        return view('handover.createApprove', compact(['users', 'handover']));
    }

    public function fetchDept($id_user)
    {
        $users = User::findOrFail($id_user);
        return response()->json($users);
    }
}
