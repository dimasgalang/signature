<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartITController extends Controller
{
    public function fetchitem()
    {
        $items = DB::connection('smartit')->table('ms_barang')->select('barang_code', 'barang_name')->where('barang_status', '=', 'Active')->get();
        return response()->json($items);
    }
}
