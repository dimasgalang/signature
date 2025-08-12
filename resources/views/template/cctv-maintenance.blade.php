<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV Maintenance Form</title>
    <style>
        @page {
            size: A4;
            margin: 10mm 10mm 10mm 10mm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            margin: 8px;
            line-height: 1.15;
        }

        table {
            width: 100%;
            max-width: 210mm;
            margin-top: 5px;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: start;
        }
        
        .form-container {
            max-width: 210mm;
            margin: 0 auto;
            /* border: 2px solid #000; */
        }
        
        .maintenance-info {
            padding-bottom: 10px;
            /* border-bottom: 1px solid #000; */
            font-size: 11pt;
            font-weight: normal;
        }
        
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        
        .main-table th,
        .main-table td .item-detail{
            border: 0.5px solid #000;
            padding: 4px;
            vertical-align: top;
            text-align: left;
        }

        .main-table th,
        .main-table td .section-header .subsection{
            border: 0.5px solid #000;
            padding: 4px;
            text-align: left;
        }
        
        .main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }
        
        .no-column {
            width: 30px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-column {
            width: 60%;
            vertical-align: middle;
            font-size: 14px;
        }
        
        .method-columns {
            width: 10%;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 12pt;
        }
        
        .section-header {
            padding: 10px;
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 11pt;
        }
        
        .subsection {
            padding: 10px;
            background-color: #f5f5f5;
            font-weight: bold;
            vertical-align: top;
            font-size: 10pt;
        }
        
        .item-detail {
            padding-left: 10px;
            font-size: 9pt;
            line-height: 1.2;
            font-weight: normal;
        }
        
        .recommendation-section {
            /* background-color: #f0f0f0; */
            font-weight: bold;
            text-align: center;
            padding: 15px;
            font-size: 11pt;
        }
        
        .recommendation-content {
            margin-top: 6px;
            font-weight: normal;
            text-align: left;
            /* padding: 8px; */
            background-color: white;
            /* border: 1px solid #ccc; */
            min-height: 60px;
            font-size: 10pt;
        }
        
        .signature-section {
            /* padding-top: 15px; */
            /* border: 1px solid #000; */
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        
        .signature-table td {
            /* border-top: 0.5px solid #000; */
            padding: 10px;
            vertical-align: top;
            width: 50%;
        }
        
        .signature-title {
            font-weight: bold;
            text-align: left;
            background-color: #f0f0f0;
            font-size: 10pt;
        }
        
        .signature-field {
            margin: 8px 0;
            font-size: 10pt;
        }
        
        .page-info {
            text-align: right;
            font-size: 9pt;
            padding: 5px;
        }
        
        .page-info {
            text-align: right;
            font-size: 8px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <center>
        <table>
            <tr>
                <td class="header">
                      @php
                          $imagePath = public_path('img/chutex_logo.png');
                          $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
                      @endphp
                    <center>
                      <img src="{{ $image }}" style="width: 70px;">
                      <h6 style="margin: 0px;">PT. CHUTEX INTERNASIONAL <br> INDONESIA</h6>
                  </center>
                </td>
                <td class="header">
                    <center>
                        <h3 style="margin: 0px;">FORMULIR PEMELIHARAAN <br> SISTEM PENGAWASAN</h3>
                        <h3 style="margin: 0px;"><i>Surveillance System Maintenance Form</i></h3>
                    </center>
                </td>
                <td class="header" style="text-align: center; vertical-align: middle;">
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Doc#: 01/FM-PL05</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Revision: 00</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Effective: 19-08-2023</p>
                </td>
            </tr>
        </table>
    </center>

    <div class="form-container">
        <!-- Maintenance Info -->
        <div class="maintenance-info">
            Tanggal Pemeliharaan/ Date of Maintenance: 15-08-2025&nbsp;&nbsp;&nbsp;
            Frekuensi/Frequency: Setahun 2 kali/ Twice a year
        </div>
        
        <!-- Main Table -->
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" class="no-column" style="vertical-align: middle;">No.</th>
                    <th rowspan="2" class="items-column" style="vertical-align: middle;">BARANG / ITEMS</th>
                    <th colspan="4">Metode/ Method</th>
                </tr>
                <tr>
                    <th class="method-columns">Periksa<br>Inspect</th>
                    <th class="method-columns">Bersihkan<br>Clean</th>
                    <th class="method-columns">Perbaiki<br>Repair</th>
                    <th class="method-columns">Mengganti<br>Replace</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no-column section-header">1</td>
                    <td colspan="5" class="section-header">PERANGKAT KERAS / HARDWARE</td>
                </tr>
                
                <tr>
                    <td rowspan="10" class="subsection">1.1 </td>
                    <td colspan="5"  class="subsection">Lensa Kamera Pengawas / Surveillance Camera Lens - 12 camera</td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        a. Periksa apakah lensa kamera difokuskan dan disesuaikan dengan benar.<br>
                        <em>Check the camera lens is focused and adjusted properly.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        b. Monitor menampilkan gambar yang jelas, pengaturan kecerahan dan kontras disesuaikan dengan benar.<br>
                        <em>Monitor are showing a clear picture, brightness and contrast setting are correctly adjusted.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        c. Bersihkan debu atau noda pada lensa kamera.<br>
                        <em>Clean any dust or marks off the camera lens.</em>
                    </td>
                    <td class="method-columns"></td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        d. Sesuaikan tampilan kamera yang telah terlempar dari jalur yang dituju.<br>
                        <em>Adjust the camera view that has been knocked of the aimed path.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        e. Periksa apakah sensor deteksi gerakan berfungsi dengan baik.<br>
                        <em>Check the motion detection sensors are working well.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        f. Kamera terkena kebocoran air/hujan.<br>
                        <em>Camera impacted by water/rain leaking</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        g. Pangkas dedaunan, benda-benda yang dapat menghalangi pandangan.<br>
                        <em>Trim back any foliage, objects that may be obscuring the view.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        h. Gunakan pengontrol untuk memeriksa apakah fungsi kamera, seperti zoom dan pan berfungsi dengan benar.<br>
                        <em>Use controller to check that the camera's functions, such as zoom and pan are working correctly.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        i. Kamera tidak bisa berfungsi dengan baik dan tidak berfungsi dengan baik<br>
                        <em>Camera are securely attached to the wall or pillar.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td rowspan="6" class="subsection">1.2 </td>
                    <td colspan="5" class="subsection">Memeriksa server rekaman/ Checking recording server – 2 servers.</td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        a. Tombol pada perekam, kendali jarak jauh.
                        <em>Buttons on the recorder, remote controler</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        b. Server rekaman, kipas pendingin.
                        <em>Recording server, cooling fan.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        c. Steker, UPS, dan catu daya.
                        <em>Plugs, UPSs, and Power supply</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        d. Waktu dan tanggal yang benar telah ditetapkan.
                        <em>Correct time and date stamp is set.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        e. Transmisi gambar jernih dan tidak ada distorsi.
                        <em>The transmission of picture are clear and no distortion.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td rowspan="5" class="subsection">1.3 </td>
                    <td colspan="5" class="subsection">Periksa infrastruktur jaringan / Check network infrastructure</td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        a. Konektor dan kabel jaringan
                        <em>Network connectors and cables.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>

                <tr>
                    <td class="item-detail">
                        b. Saklar Switches
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        c. Catu daya untuk Sakelar (termasuk UPS)
                        <em>Power supply for the Switches (including UPSs)</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="item-detail">
                        d. Kabel serat optik, kotak sambungan optik, kabel patch optik, konverter optik.
                        <em>Fiber optic cables, optical junction boxes, optical patchcords, optical converters</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="no-column section-header">2</td>
                    <td colspan="5" class="section-header">Pengujian Perangkat Lunak / Software Testing</td>    
                </tr>
                
                <tr>
                    <td class="no-column section-header">2.1 </td>
                    <td class="item-detail">
                        Menguji akses gambar kamera melalui browser web dari komputer staf keamanan dan dewan manajemen.<br>
                        <em>Testing camera image access via web browser from security staff's and management board's computers.</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="no-column section-header">2.2 </td>
                    <td class="item-detail">
                        Periksa data rekaman yang disimpan di hard drive.<br>
                        <em>Check the recording data stored on the hard drive</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="no-column section-header">2.3 </td>
                    <td class="item-detail">
                        Uji ekstraksi data rekaman.<br>
                        <em>Test the extraction of recording data</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td class="no-column section-header">2.4 </td>
                    <td class="item-detail">
                        Data rekaman cadangan<br>
                        <em>Backup recording data</em>
                    </td>
                    <td class="method-columns">✓</td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                    <td class="method-columns"></td>
                </tr>
                
                <tr>
                    <td colspan="6" class="recommendation-section">
                        <div style="font-weight: bold; text-align: start;">
                            REKOMENDASI PENGGANTIAN BARU / RECOMMENDATION OF NEW REPLACEMENT
                        </div>
                        <div class="recommendation-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure officiis tenetur accusamus, vero ab natus, laborum praesentium tempora dolor minima impedit obcaecati adipisci molestias nemo consectetur atque alias id fugit aut? Tempore accusamus eligendi voluptatibus fugit natus excepturi beatae facere modi velit nam similique corrupti qui inventore, quibusdam, rerum vel repellat eaque fugiat ut ea aspernatur eum aliquam delectus aperiam. Sit, nesciunt aperiam aspernatur rerum obcaecati ad voluptas animi fuga hic voluptatem nobis suscipit exercitationem, iste soluta molestias quibusdam distinctio expedita voluptate numquam! Aliquid ad nobis quasi officiis! Consequuntur impedit tempore dicta numquam ipsum exercitationem consectetur laudantium enim reiciendis earum.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Page 2 -->
    <div class="form-container" style="margin-top: 15px;">
        <!-- Signature Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: left; padding-left: 10px; margin-bottom: 15px;">
                        <div style="font-size: 16px; font-weight: bold;">
                            PELAKU PEMELIHARAAN/ MAINTENANCE PERFORMER
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="signature-title">
                        Pihak pemeliharaan / Maintenance performer<br>
                        <em>(Dept. IT atau konsultan/ IT Dept or consultant)</em>
                    </td>
                    <td class="signature-title">
                        Tindak lanjut (Acak)/ Follow-Up person (Randomly)<br>
                        <em>(Kepala Dept. IT/ IT Head of Dept.)</em>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="signature-field">
                            <i>Para pihak/ Performer:</i> Ahmad Fauzi
                        </div>
                        <div class="signature-field">
                            <i>Nama jabatan/ Job title:</i> IT Support Specialist
                        </div>
                        <div class="signature-field">
                            <i>Tanggal/ Date:</i> 15 Agustus 2025
                        </div>
                        <div class="signature-field" style="margin-top: 40px;">
                            <i>Tanda tangan/ Signature:</i> ___________________
                        </div>
                    </td>
                    <td>
                        <div class="signature-field">
                            <i>Para pihak/ Performer:</i> Dr. Budi Santoso
                        </div>
                        <div class="signature-field">
                            <i>Nama Jabatan/ Job title:</i> Head of IT Department
                        </div>
                        <div class="signature-field">
                            <i>Tanggal/ Date:</i> 16 Agustus 2025
                        </div>
                        <div class="signature-field" style="margin-top: 40px;">
                            <i>Tanda tangan/ Signature:</i> ___________________
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>