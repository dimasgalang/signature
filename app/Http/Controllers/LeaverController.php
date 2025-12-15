<?php

namespace App\Http\Controllers;

use App\Models\ItemLeaver;
use App\Models\ItemService;
use App\Models\Leaver;
use App\Models\ServiceLeaver;
use App\Models\SysLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use RealRashid\SweetAlert\Facades\Alert;

class LeaverController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $leavers = Leaver::with(['item_leaver', 'leaverName', 'receiverName'])
                ->where('void', $request->void)
                ->where('leaver_name_id', $user_id)
                ->orderBy('date', 'desc')
                ->get();
        } else {
            $leavers = Leaver::with(['item_leaver', 'leaverName', 'receiverName'])
                ->where('void', 'false')->where('leaver_name_id', $user_id)
                ->orderBy('date', 'desc')
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

        $leavers = Leaver::orderBy('id', 'desc')->first();
        $prefix = 'C';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($leavers) && preg_match('/^C(\d{6})(\d{4})$/', $leavers->document_name, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }

        $newIdleavers = $prefix . $todayDate . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // dd('HO' . date('y') . date('n') . date('d') . str_pad(intval(substr($handover?->document_name, -4)) + 1, 4, '0', STR_PAD_LEFT));
        return view('leaver.create', compact('users', 'items', 'leaver', 'services', 'newIdleavers'));
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
            $item->item_details = $value['item_details'];
            $item->serial_number = $value['serial_number'];
            $item->quantity = $value['quantity'];
            $item->save();

            $username = Auth::user()->name;
            $agent = new Agent();
            $agent->setUserAgent(request()->userAgent());
            $ipAddress = request()->ip();
            $mac = get_mac_address($ipAddress);
            $browser = $agent->browser();
            $os = $agent->platform();
            SysLog::create([
                'username' => $username,
                'activity' => 'Create Leaver Item ' . $leaver->document_name . ' : ' . $value['barang_code'] . ' - ' . $value['item_details'],
                'menu' => 'Leaver',
                'log_date' => now(),
                'ip_address' => $ipAddress,
                'mac_address' => $mac,
                'browser_type' => $browser,
                'os' => $os,
            ]);
        }

        foreach ($request->service_id as $key => $value) {
            $service = new ItemService();
            $service->leaver_id = $leaver->id;
            $service->leaver_code = $value;
            $service->save();

            $username = Auth::user()->name;
            $agent = new Agent();
            $agent->setUserAgent(request()->userAgent());
            $ipAddress = request()->ip();
            $mac = get_mac_address($ipAddress);
            $browser = $agent->browser();
            $os = $agent->platform();
            SysLog::create([
                'username' => $username,
                'activity' => 'Create Leaver Service ' . $leaver->document_name . ' : ' . $value,
                'menu' => 'Leaver',
                'log_date' => now(),
                'ip_address' => $ipAddress,
                'mac_address' => $mac,
                'browser_type' => $browser,
                'os' => $os,
            ]);
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
                'item_details' => $item->item_details,
                'serial_number' => $item->serial_number,
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

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Generate Leaver Document ' . $documentName,
            'menu' => 'Leaver',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

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
                    $item->item_details = $value['item_details'];
                    $item->serial_number = $value['serial_number'];
                    $item->quantity = $value['quantity'];
                    $item->save();

                    $username = Auth::user()->name;
                    $agent = new Agent();
                    $agent->setUserAgent(request()->userAgent());
                    $ipAddress = request()->ip();
                    $mac = get_mac_address($ipAddress);
                    $browser = $agent->browser();
                    $os = $agent->platform();
                    SysLog::create([
                        'username' => $username,
                        'activity' => 'Update Leaver Item ' . $leaver->document_name . ' : ' . ' - ' . $value['item_details'],
                        'menu' => 'Leaver',
                        'log_date' => now(),
                        'ip_address' => $ipAddress,
                        'mac_address' => $mac,
                        'browser_type' => $browser,
                        'os' => $os,
                    ]);
                }
                // If id is null, create a new item
            } else {
                $item = new ItemLeaver();
                $item->leaver_id = $request->leaver_id;
                $item->item_id = $value['item_id'];
                $item->item_details = $value['item_details'];
                $item->serial_number = $value['serial_number'];
                $item->quantity = $value['quantity'];
                $item->save();

                $username = Auth::user()->name;
                $agent = new Agent();
                $agent->setUserAgent(request()->userAgent());
                $ipAddress = request()->ip();
                $macAddress = get_mac_address($ipAddress);
                $browser = $agent->browser();
                $os = $agent->platform();
                SysLog::create([
                    'username' => $username,
                    'activity' => 'Create New Leaver Item ' . $leaver->document_name . ' : ' . $value['item_details'],
                    'menu' => 'Leaver',
                    'log_date' => now(),
                    'ip_address' => $ipAddress,
                    'mac_address' => $macAddress,
                    'browser_type' => $browser,
                    'os' => $os,
                ]);
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

                    $username = Auth::user()->name;
                    $agent = new Agent();
                    $agent->setUserAgent(request()->userAgent());
                    $ipAddress = request()->ip();
                    $mac = get_mac_address($ipAddress);
                    $browser = $agent->browser();
                    $os = $agent->platform();
                    SysLog::create([
                        'username' => $username,
                        'activity' => 'Update Leaver Service ' . $leaver->document_name,
                        'menu' => 'Leaver',
                        'log_date' => now(),
                        'ip_address' => $ipAddress,
                        'mac_address' => $mac,
                        'browser_type' => $browser,
                        'os' => $os,
                    ]);
                }
                // If id is null, create a new item
            } else {
                $service = new ItemService();
                $service->leaver_id = $request->leaver_id;
                $service->leaver_code = $value['service_id'];

                $username = Auth::user()->name;
                $agent = new Agent();
                $agent->setUserAgent(request()->userAgent());
                $ipAddress = request()->ip();
                $macAddress = get_mac_address($ipAddress);
                $browser = $agent->browser();
                $os = $agent->platform();
                SysLog::create([
                    'username' => $username,
                    'activity' => 'Create New Leaver Service ' . $leaver->document_name,
                    'menu' => 'Leaver',
                    'log_date' => now(),
                    'ip_address' => $ipAddress,
                    'mac_address' => $macAddress,
                    'browser_type' => $browser,
                    'os' => $os,
                ]);
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

    public function fetchLeaver($id)
    {
        $fetchLeaver = Leaver::select('leavers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'leavers.leaver_name_id')->where('leavers.id', '=', $id)->get();
        // dd($fetchapproval);
        return response()->json($fetchLeaver);
    }

    public function void(Request $request)
    {
        // dd($request->all());
        $leaver = Leaver::find($request->leaver_id);
        $leaver->void = 'true';
        $leaver->save();

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Void Leaver Document ' . $leaver->document_name,
            'menu' => 'Leaver',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Void Successfully!', 'Document successfully void!');
        return redirect()->intended('leaver/index');
    }
    public function restore(Request $request)
    {
        $leaver = Leaver::find($request->leaver_id);
        $leaver->void = 'false';
        $leaver->save();

        $username = Auth::user()->name;
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());
        $ipAddress = request()->ip();
        $macAddress = get_mac_address($ipAddress);
        $browser = $agent->browser();
        $os = $agent->platform();
        SysLog::create([
            'username' => $username,
            'activity' => 'Restore Leaver Document ' . $leaver->document_name,
            'menu' => 'Leaver',
            'log_date' => now(),
            'ip_address' => $ipAddress,
            'mac_address' => $macAddress,
            'browser_type' => $browser,
            'os' => $os,
        ]);

        Alert::success('Restore Successfully!', 'Document successfully restore!');
        return redirect()->intended('leaver/index');
    }
}
