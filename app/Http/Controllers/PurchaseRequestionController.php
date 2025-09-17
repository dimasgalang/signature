<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\ArrivalPurchaseItem;
use App\Models\PurchaseRequestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseRequestionController extends Controller
{
    public function index(Request $request)
    {
        // $purchaseRequests = PurchaseRequestOrder::select('purchase_requestions.*')->count('nm_barang')->groupBy('purchase_requestions.purchase_requestion_number')->get();
        // $purchaseRequests = DB::select('select purchase_requestions.*, count(nm_barang) AS total_items from purchase_requestions group by purchase_requestion_number');

        $user = Auth::user()->getRoleNames()->first();
        if ( $user == 'Purchase' || $user == 'Admin') {
            if ($request->void) {
                $purchaseRequests = DB::select("SELECT * FROM ( SELECT pr.*, COUNT(pr.nm_barang) OVER (PARTITION BY pr.purchase_requestion_number) AS total_items, ROW_NUMBER() OVER (PARTITION BY pr.purchase_requestion_number ORDER BY pr.status_code ASC) AS rn FROM purchase_requestions pr WHERE pr.void = '" . $request->void . "' ) t WHERE t.rn = 1 ORDER BY t.status_code ASC");
            } else {
                $purchaseRequests = DB::select("SELECT * FROM ( SELECT pr.*, COUNT(pr.nm_barang) OVER (PARTITION BY pr.purchase_requestion_number) AS total_items, ROW_NUMBER() OVER (PARTITION BY pr.purchase_requestion_number ORDER BY pr.status_code ASC) AS rn FROM purchase_requestions pr WHERE pr.void = 'false' ) t WHERE t.rn = 1 ORDER BY t.status_code ASC");
            }
        } else {
            $id_user = Auth::user()->id;
            if ($request->void) {
                $purchaseRequests = DB::select("SELECT * FROM ( SELECT pr.*, COUNT(pr.nm_barang) OVER (PARTITION BY pr.purchase_requestion_number) AS total_items, ROW_NUMBER() OVER (PARTITION BY pr.purchase_requestion_number ORDER BY pr.status_code ASC) AS rn FROM purchase_requestions pr WHERE pr.void = '" . $request->void . "' AND pr.employee_id = '" . $id_user . "' ) t WHERE t.rn = 1 ORDER BY t.status_code ASC");
            } else {
                $purchaseRequests = DB::select("SELECT * FROM ( SELECT pr.*, COUNT(pr.nm_barang) OVER (PARTITION BY pr.purchase_requestion_number) AS total_items, ROW_NUMBER() OVER (PARTITION BY pr.purchase_requestion_number ORDER BY pr.status_code ASC) AS rn FROM purchase_requestions pr WHERE pr.void = 'false' AND pr.employee_id = '" . $id_user . "' ) t WHERE t.rn = 1 ORDER BY t.status_code ASC");
            }
        }

        return view('purchase-requestion.index', compact('purchaseRequests'));
    }

    public function create()
    {
        $purchaseRequest = PurchaseRequestion::orderBy('id', 'desc')->first();
        $prefix = 'PR';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($purchaseRequest) && preg_match('/^PR(\d{6})(\d{2})$/', $purchaseRequest->purchase_requestion_number, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }
        $newIdPurchaseRequest = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        $suppliers = DB::connection('smartit')->table('ms_supplier')->select('supplier_code', 'supplier_name')->get();

        return view('purchase-requestion.create', compact('newIdPurchaseRequest', 'suppliers'));
    }

    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'purchase_request_number' => 'required|string|max:255',
        //     'item_request.*.item_name' => 'required|string|max:255',
        //     'item_request.*.quantity' => 'required|min:1',
        // ]);
        // dd($request->all());
        // Create the purchase request order
        foreach ($request['item_request'] as $item) {
            $purchaseReq = PurchaseRequestion::create([
                'purchase_requestion_number' => $request['purchase_request_number'],
                'requestion' => $request['requestion'],
                'employee_id' => auth()->id(),
                'supplier' => $request['supplier_id'],
                'date_of_request' => $request['date_of_request'],
                'nm_barang' => $item['item_name'],
                'qty' => $item['quantity'],
                'status' => 'waiting',
                'status_code' => '01',
                'void' => 'false',
            ]);
        }

        $purchaseEmail = DB::table('users')->where('dept', 'Purchase')->pluck('email')->toArray();

        foreach ($purchaseEmail as $email) {
            $emailBody = [
                'name' => 'Chutex E-Signature',
                'body' => 'You have a new purchase requestion "' . $request['purchase_request_number'] . '"_"' . $request['requestion'] . '"  from "' . $request->name . '". You can check the purchase requestion by opening the link below.',
                'url' => URL::to("/purchase-requestion/index/")
            ];
            // Mail::to($email)->send(new SendEmail($emailBody));
        }

        Alert::success('Created Successfully!', 'Purchase Request successfully created!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function fetchPurchaseRequest($purchaseRequestionNumber)
    {
        $purchaseRequests = DB::table('purchase_requestions as pr')
            ->select('pr.*', DB::raw('ISNULL(a.incoming_qty, 0) as incoming_qty'))
            ->leftJoin(DB::raw('(SELECT id_barang, SUM(CAST(qty AS INT)) as incoming_qty FROM arrival_purchase_items GROUP BY id_barang) a'), 'pr.id', '=', 'a.id_barang')->where('pr.purchase_requestion_number', $purchaseRequestionNumber)
            ->get();
        $requestBy = DB::table('users')->where('id', $purchaseRequests[0]->employee_id)->first()->name;
        $processedBy = $purchaseRequests[0]->process_date ? DB::table('users')->where('id', $purchaseRequests[0]->approval_id)->first()->name : null;
        $canceledBy = $purchaseRequests[0]->canceled_date ? DB::table('users')->where('id', $purchaseRequests[0]->canceled_id)->first()->name : null;
        return response()->json(['data' => $purchaseRequests, 'requestBy' => $requestBy, 'processedBy' => $processedBy, 'canceledBy' => $canceledBy]);
    }

    public function fetchArrivalHistory($purchaseRequestionNumber)
    {
        $arrivalHistory = DB::table('arrival_purchase_items as api')
            ->join('purchase_requestions as pr', 'api.id_barang', 'pr.id')
            ->select('api.*', 'pr.nm_barang')
            ->where('api.purchase_requestion_number', $purchaseRequestionNumber)
            ->orderBy('api.created_at', 'desc')
            ->get();
        return response()->json(['data' => $arrivalHistory]);
    }

    public function processPurchaseRequest(Request $request)
    {
        $processReq = PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number)
            ->update([
                'status' => 'process',
                'status_code' => '02',
                'approval_id' => auth()->id(),
                'process_date' => now(),
            ]);
        $requestEmail = DB::table('users')->where('id', $request->employee_id)->first()->email;
        $emailBody = [
            'name' => 'Chutex E-Signature',
            'body' => 'Your purchase requestion with number "' . $request['purchase_request_number'] . '"_"' . $request['requestion'] . '" is now being processed. You can check the purchase requestion by opening the link below.',
            'url' => URL::to("/purchase-requestion/index/")
        ];
        // Mail::to($requestEmail)->send(new SendEmail($emailBody));
        Alert::success('Processed Successfully!', 'Purchase Request successfully processed!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function canceledPurchaseRequest(Request $request)
    {
        PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number)
            ->update(['status' => 'canceled', 'status_code' => '04', 'canceled_id' => auth()->id(), 'canceled_date' => now()]);
        
        $requestEmail = DB::table('users')->where('id', $request->employee_id)->first()->email;
        $emailBody = [
            'name' => 'Chutex E-Signature',
            'body' => 'Your purchase requestion with number "' . $request['purchase_request_number'] . '"_"' . $request['requestion'] . '" has been canceled. You can check the purchase requestion by opening the link below.',
            'url' => URL::to("/purchase-requestion/index/")
        ];
        // Mail::to($requestEmail)->send(new SendEmail($emailBody));
        Alert::success('Canceled Successfully!', 'Purchase Request successfully canceled!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function createArrival($purchaseRequestionNumber)
    {
        // $purchaseRequests = PurchaseRequestion::where('purchase_requestion_number', $purchaseRequestionNumber)->get();
        $purchaseRequests = DB::table('purchase_requestions as pr')
            ->select('pr.*', DB::raw('ISNULL(a.incoming_qty, 0) as incoming_qty'))
            ->leftJoin(DB::raw('(SELECT id_barang, SUM(CAST(qty AS INT)) as incoming_qty FROM arrival_purchase_items GROUP BY id_barang) a'), 'pr.id', '=', 'a.id_barang')
            ->where('pr.purchase_requestion_number', $purchaseRequestionNumber)
            ->get();

        $created_by = DB::table('users')->where('id', $purchaseRequests[0]->employee_id)->first()->name;

            // dd($purchaseRequests);
        return view('purchase-requestion.arrival', compact('purchaseRequests', 'created_by'));
    }

    public function storeArrival(Request $request)
    {
        foreach ($request['itemRequest'] as $item) {
           if($item['qty_receiver'] != null && $item['qty_receiver'] > 0) {
                ArrivalPurchaseItem::create([
                    'arrival_number' => ArrivalPurchaseItem::max('id') + 1,
                    'purchase_requestion_number' => $request['purchase_request_number'],
                    'date_of_arrival' => now(),
                    'id_barang' => $item['id_barang'],
                    'qty' => $item['qty_receiver'],
                    'remarks' => $item['remark'] ?? null,
                ]);

                $totalArrival = DB::table('arrival_purchase_items')
                    ->where('purchase_requestion_number', $request['purchase_request_number'])
                    ->where('id_barang', $item['id_barang'])
                    ->sum(DB::raw('CAST(qty AS INT)'));

                if ($totalArrival >= $item['total_quantity']) {
                    PurchaseRequestion::where('purchase_requestion_number', $request['purchase_request_number'])
                        ->where('id', $item['id_barang'])
                        ->update(['status' => 'finished', 'status_code' => '05']);
                }
           }
        }

        Alert::success('Created Successfully!', 'Arrival items successfully created!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function void(Request $request)
    {
        // dd($request->all());
        $purchaseRequestion = PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number);
        $purchaseRequestion->update(['void' => 'true']);

        Alert::success('Void Successfully!', 'Document successfully void!');
        return redirect()->intended('purchase-requestion/index');
    }
    public function restore(Request $request)
    {
        $purchaseRequestion = PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number);
        $purchaseRequestion->update(['void' => 'false']);
        Alert::success('Restore Successfully!', 'Document successfully restore!');
        return redirect()->intended('purchase-requestion/index');
    }
}
