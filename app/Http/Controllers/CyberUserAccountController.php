<?php

namespace App\Http\Controllers;

use App\Models\CyberUserAccount;
use App\Models\ReasonDeactivateCyberUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CyberUserAccountController extends Controller
{
    public function index(Request $request)
    {
        return view('user-account-deactivation.index');
    }

    public function create()
    {
        $users = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->get();
        $reasons = ReasonDeactivateCyberUser::all();

        // CUA25062401
        $cyberUserAccount = CyberUserAccount::orderBy('id', 'desc')->first();
        $prefix = 'CUA';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($cyberUserAccount) && preg_match('/^ARF(\d{6})(\d{2})$/', $cyberUserAccount->id, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }
        $newIdRequestDeactivate = $prefix . $todayDate . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return view('user-account-deactivation.create', compact(['users', 'reasons', 'newIdRequestDeactivate']));
    }

    public function edit()
    {
        return view('user-account-deactivation.edit');
    }

    public function fetchEmployee($npk)
    {
        $employee = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->where('BIODATA.NPK', '=', $npk)->get();
        return response()->json($employee);
    }
}
