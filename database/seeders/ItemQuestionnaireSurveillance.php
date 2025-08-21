<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemQuestionnaireSurveillance extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Periksa apakah lensa kamera difokuskan dan disesuaikan dengan benar. <br>Check the camera lens is focused and adjusted properly.',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Monitor menampilkan gambar yang jelas, pengaturan kecerahan dan kontras disesuaikan dengan benar. <br>Monitor are showing a clear picture, brightness and contrast setting are correctly adjusted',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Bersihkan debu atau noda pada lensa kamera.<br> Clean any dust or marks off the camera lens',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Sesuaikan tampilan kamera yang telah terlempar dari jalur yang dituju. <br>Adjust the camera view that has been knocked of the aimed path',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Periksa apakah sensor deteksi gerakan berfungsi dengan baik. <br>Check the motion detection sensors are working well.',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Kamera terkena kebocoran air/hujan. <br>Camera impacted by water/rain leaking',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Pangkas dedaunan, benda-benda yang dapat menghalangi pandangan. <br>Trim back any foliage, objects that may be obscuring the view',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Gunakan pengontrol untuk memeriksa apakah fungsi kamera, seperti zoom dan pan berfungsi dengan benar. <br>Use controller to check that the camera’s functions, such as zoom and pan are working correctly.',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'a',
            'questionnaire_items' => 'Kamera tidak bisa berfungsi dengan baik dan tidak berfungsi dengan baik <br>Camera are securely attached to the wall or pillar',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'b',
            'questionnaire_items' => 'Tombol pada perekam, kendali jarak jauh.<br>Buttons on the recorder, remote controler',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'b',
            'questionnaire_items' => 'Server rekaman, kipas pendingin.<br>Recording server, cooling fan.',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'b',
            'questionnaire_items' => 'Steker, UPS, dan catu daya.<br> Plugs, UPSs, and Power supply',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'b',
            'questionnaire_items' => 'Waktu dan tanggal yang benar telah ditetapkan. <br>Correct time and date stamp is set',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'b',
            'questionnaire_items' => 'Transmisi gambar jernih dan tidak ada distorsi. <br>The transmission of picture are clear and no distortion.',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'c',
            'questionnaire_items' => 'Konektor dan kabel jaringan. Network connectors and cables',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'c',
            'questionnaire_items' => 'Saklar. Switches',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'c',
            'questionnaire_items' => 'Catu daya untuk Sakelar (termasuk UPS) <br>.Power supply for the Switches (including UPSs)',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'c',
            'questionnaire_items' => 'Kabel serat optik, kotak sambungan optik, kabel patch optik, konverter optik. <br>Fiber optic cables, optical junction boxes, optical patchcords, optical converters',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'd',
            'questionnaire_items' => "Menguji akses gambar kamera melalui browser web dari komputer staf keamanan dan dewan manajemen. <br>Testing camera image access via web browser from security staff's and management board's computers.",
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'd',
            'questionnaire_items' => 'Periksa data rekaman yang disimpan di hard drive. <br>Check the recording data stored on the hard drive',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'd',
            'questionnaire_items' => 'Uji ekstraksi data rekaman. <br>Test the extraction of recording data',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'd',
            'questionnaire_items' => 'Data rekaman cadangan <br>Backup recording data',
        ]);
    }
}
