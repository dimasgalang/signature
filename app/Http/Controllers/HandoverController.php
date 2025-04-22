<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Item;
use App\Models\ItemHandover;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HandoverController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if($request->void) {
            $handovers = Handover::with(['item_handovers', 'handoverName', 'receiverName'])
                ->where('void', $request->void)
                ->get();
        } else {
            $handovers = Handover::with(['item_handovers', 'handoverName', 'receiverName'])
                ->where('void', false)
                ->get();
        }
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

    public function fetchHandover($id)
    {
        $fetchHandover = Handover::select('handovers.*', 'users.name')->leftJoin('users', 'users.id', '=', 'handovers.handover_name_id')->where('handovers.id', '=', $id)->get();
        // dd($fetchapproval);
        return response()->json($fetchHandover);
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
}
