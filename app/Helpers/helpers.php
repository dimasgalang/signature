<?php

use Illuminate\Support\Facades\DB;

if (! function_exists('get_mac_address')) {
    /**
     * Return MAC address for given IP (or server MAC if IP is server IP).
     *
     * @param  string|null  $ip
     * @return string|null
     */
    function get_mac_address(?string $ip = null): ?string
    {
        if ($ip !== '192.168.1.34') {
            $macAddr = false;
            $arp = `arp -a $ip`;
            $lines = explode("\n", $arp);
            foreach ($lines as $line) {
                $cols = preg_split('/\s+/', trim($line));
                if ($cols[0] == $ip) {
                    if (isset($cols[1])) {
                        $macAddr = strtoupper($cols[1]);
                    } else {
                        $macAddr = '';
                    }
                }
            }
        } else {
            $macAddr = substr(exec('getmac'), 0, 17);
        }

        return $macAddr;
    }
}

// function check user by npk from table users
if (! function_exists('check_user_by_npk')) {
    /**
     * Check user by NPK.
     *
     * @param  string  $npk
     * @return string|null
     */
    function check_user_by_npk(string $npk): ?string
    {
        $usersActive = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->get();
        $usersOut = DB::connection('cii')->table('BIODATA_KELUAR')->select('BIODATA_KELUAR.NPK AS NPK', 'NAMA_KARYAWAN', 'BAG',)->get();
        $users = $usersActive->merge($usersOut);
        $user = $users->where('NPK', $npk);
        return $user->isNotEmpty() ? $user->first()->NAMA_KARYAWAN : null;
    }
}
