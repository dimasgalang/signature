<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonDeactivateCyberUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reason_deactivate_cyber_users')->insert([
            'reason' => 'Pemutusan hubungan kerja, Berhenti dari pekerjaan. / Termination, Quit job.',
        ]);
        DB::table('reason_deactivate_cyber_users')->insert([
            'reason' => 'Cuti hamil. / Maternity leave',
        ]);
        DB::table('reason_deactivate_cyber_users')->insert([
            'reason' => 'Cuti pribadi panjang. / Long personal leave',
        ]);
        DB::table('reason_deactivate_cyber_users')->insert([
            'reason' => 'Perubahan tuntutan pekerjaan / Change of work demands',
        ]);
    }
}
