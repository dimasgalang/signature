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
        return view('home');
    }

    public function profile()
    {
        $user = User::select('users.*','signatures.signature_img')
        ->leftJoin('signatures','users.id','=','signatures.user_id')
        ->where('users.id','=', Auth::user()->id)
        ->get();
        return view('auth.profile', compact('user'));
    }

    public function listuser() {
        $users   = User::all();
        return view('auth.list-user', compact('users'));
    }
}
