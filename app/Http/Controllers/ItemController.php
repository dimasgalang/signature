<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $last_item = Item::all()->last();
        return view('item.create', compact('last_item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
        ]);

        $last_item = Item::orderBy('itemNumber', 'desc')->first();

        Item::create([
            'itemNumber' => str_pad(intval($last_item->itemNumber) + 1, 4, '0', STR_PAD_LEFT),
            'productName' => $request->product_name,
            'qtyType' => $request->qty_type,
            'void' => 'false'
        ]);

        Alert::success('Create Successfully!', 'Item created successfully.');
        return redirect()->intended('item/index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function revision(string $id)
    {
        $item = Item::findOrFail($id);
        return view('item.revision', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($request->item_id);
        $item->update([
            'productName' => $request->product_name,
            'qtyType' => $request->qty_type,
        ]);

        Alert::success('Update Successfully!', 'Item updated successfully.');
        return redirect()->intended('item/index');
    }

    public function fetchItem($id)
    {
        $item = Item::select('items.*')->where('items.id', '=', $id)->get();
        dd($item);
        return response()->json($item);
    }

    public function void(Request $request)
    {
        $item = Item::find($request->item_id);
        $item->void = 'true';
        $item->save();
        Alert::success('Void Successfully!', 'Item successfully void!');
        return redirect()->intended('item/index');
    }

    public function restore(Request $request)
    {
        $item = Item::find($request->item_id);
        $item->void = 'false';
        $item->save();
        Alert::success('Restore Successfully!', 'Item successfully restore!');
        return redirect()->intended('item/index');
    }
}
