<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPurchaseItem;
use App\Models\PurchaseRequestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseRequestionController extends Controller
{
    public function index()
    {
        // $purchaseRequests = PurchaseRequestOrder::select('purchase_requestions.*')->count('nm_barang')->groupBy('purchase_requestions.purchase_requestion_number')->get();
        // $purchaseRequests = DB::select('select purchase_requestions.*, count(nm_barang) AS total_items from purchase_requestions group by purchase_requestion_number');
        $purchaseRequests = DB::select(" SELECT t.*, x.total_items FROM purchase_requestions t INNER JOIN ( SELECT purchase_requestion_number, MIN(id) AS min_id, COUNT(nm_barang) AS total_items FROM purchase_requestions GROUP BY purchase_requestion_number ) x ON t.purchase_requestion_number = x.purchase_requestion_number AND t.id = x.min_id");
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
            PurchaseRequestion::create([
                'purchase_requestion_number' => $request['purchase_request_number'],
                'requestion' => $request['requestion'],
                'employee_id' => auth()->id(),
                'supplier' => $request['supplier_id'],
                'date_of_request' => now(),
                'nm_barang' => $item['item_name'],
                'qty' => $item['quantity'],
                'status' => 'waiting', // Default status
            ]);
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
        return response()->json(['data' => $purchaseRequests]);
    }

    public function processPurchaseRequest(Request $request)
    {
        PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number)
            ->update([
                'status' => 'process'
            ]);
        Alert::success('Processed Successfully!', 'Purchase Request successfully processed!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function canceledPurchaseRequest(Request $request)
    {
        PurchaseRequestion::where('purchase_requestion_number', $request->purchase_requestion_number)
            ->update(['status' => 'canceled']);
        Alert::success('Canceled Successfully!', 'Purchase Request successfully canceled!');
        return redirect()->intended('purchase-requestion/index');
    }

    public function createArrival($id)
    {
        $purchaseRequests = PurchaseRequestion::where('id', $id)->get();
        return view('purchase-requestion.arrival', compact('purchaseRequests'));
    }

    public function storeArrival(Request $request)
    {
        // $validatedData = $request->validate([
        //     'purchase_request_number' => 'required|string|max:255',
        //     'item_request.*.item_name' => 'required|string|max:255',
        //     'item_request.*.quantity_receiver' => 'required|min:1',
        //     'item_request.*.remark' => 'nullable|string|max:255',
        // ]);
        // dd($request->all());

        $arrivalNumber = ArrivalPurchaseItem::max('id') + 1;
        ArrivalPurchaseItem::create([
            'arrival_number' => $arrivalNumber,
            'purchase_requestion_number' => $request['purchase_request_number'],
            'date_of_arrival' => $request['date_of_arrival'],
            'id_barang' => $request['id_barang'],
            'qty' => $request['quantity_receiver'],
            'remarks' => $request['remark'],
        ]);

        Alert::success('Created Successfully!', 'Arrival items successfully created!');
        return redirect()->intended('purchase-requestion/index');
    }
}
