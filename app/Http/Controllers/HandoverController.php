<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Item;
use App\Models\ItemHandover;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HandoverController extends Controller
{
    public function index(Request $request)
    {
        // $user_id = Auth::user()->id;
        // if ($request->void) {
        //     $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "' . $request->void . '"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');
        // } else {
        //     $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "false"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');
        // }
        $handovers = Handover::with(['item_handovers', 'handoverName', 'receiverName'])->get();
        return view('handover.index', compact('handovers'));
    }

    public function create()
    {
        $users = User::all();
        $items = Item::all();
        $now = Carbon::now();
        return view('handover.create', compact('users', 'now', 'items'));
    }

    public function store(Request $request)
    {
        $handover = Handover::create([
            'handover_name_id' => $request->handover_name_id,
            'receiver_name_id' => $request->receiver_name_id,
            'department' => $request->department,
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        foreach ($request->product_id as $key => $value) {
            $item = new ItemHandover();
            $item->handover_id = $handover->id;
            $item->item_id = $value['item_id'];
            $item->quantity = $value['quantity'];
            $item->save();
        }

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('handover/index');
    }

    public function revision(Request $request)
    {
        // cari dan relasi handover_id di item handover dengan id handover (buat dengan sql raw)
        $users = User::all();
        $items = Item::all();
        $handover = Handover::find($request->id);
        $itemHandover = DB::select("SELECT ih.* FROM item_handovers ih INNER JOIN handovers h ON ih.handover_id = h.id WHERE h.id = ? ", [$request->id]);

        // dd($itemHandover[0]);
        return view('handover.revision', compact('users', 'items', 'handover', 'itemHandover'));
    }

    public function update(Request $request)
    {
        $itemsToDelete = json_decode($request->input('items_to_delete'), true);
        if (!empty($itemsToDelete)) {
            // Delete items from the database
            ItemHandover::whereIn('id', $itemsToDelete)->delete();
        }

        $handover = Handover::find($request->handover_id);
        $handover->handover_name_id = $request->handover_name_id;
        $handover->receiver_name_id = $request->receiver_name_id;
        $handover->department = $request->department;
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

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('handover/index');
    }
}
