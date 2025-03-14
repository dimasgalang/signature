<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\LogCiiper;
use App\Models\OrderMaster;
use App\Models\ProductionPlanning;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $totalapproved = DB::select('select ifnull(sum(total),0) as total from (select preparer_id,document_name,created_at,status,count(distinct status) as total from approval where preparer_id = "' . Auth::user()->id . '" and status = "approved" group by preparer_id,document_name,created_at,status) as subquery');
        $totalpending = DB::select('select ifnull(sum(total),0) as total from (select preparer_id,document_name,created_at,status,count(distinct status) as total from approval where preparer_id = "' . Auth::user()->id . '" and status = "pending" group by preparer_id,document_name,created_at,status) as subquery');
        $totaldocument = DB::select('select ifnull(sum(total),0) as total from (select preparer_id,document_name,created_at,status,count(distinct status) as total from approval where preparer_id = "' . Auth::user()->id . '" group by preparer_id,document_name,created_at,status) as subquery');
        $totaluser = count(User::all());
        // dd($totaluser);
        return view('home', compact('totalapproved','totalpending','totaldocument','totaluser'));
    }
}
