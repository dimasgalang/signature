<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV Maintenance Form</title>
    <style>
        @page {
            size: A4;
            margin: 5mm 5mm 5mm 5mm;
        }

        body {
            font-family: 'Times New Roman', serif, 'DejaVu Sans', Arial, Helvetica, sans-serif;
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
        .page-break {
            page-break-after: always;
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
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Doc#: 01/FM-SOP14</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Revision: 0</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Effective: 13/May/25</p>
                </td>
            </tr>
        </table>
    </center>

    <div class="form-container">
        <!-- Maintenance Info -->
        <div class="maintenance-info">
            Tanggal Pemeliharaan/ Date of Maintenance: {{ \Carbon\Carbon::parse($surveillanceSystemMaintenance[0]->date_of_maintenance)->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;
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

                @foreach ($surveillanceCameraLensItems as $item)
                    <tr>
                        <td class="item-detail">
                            {!! $item->questionnaire_items !!}
                        </td>
                        @foreach($answerSurveillanceQuestionnaires as $answer)
                            @if($answer->questionnaire_id == $item->id)
                                <td class="method-columns">{{ $answer->answer == 'periksa' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'bersihkan' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'perbaiki' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'mengganti' ? '✓' : '' }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                
                <tr>
                    <td rowspan="6" class="subsection">1.2 </td>
                    <td colspan="5" class="subsection">Memeriksa server rekaman/ Checking recording server – 2 servers.</td>
                </tr>

                @foreach ($checkingRecordingServer as $item)
                    <tr>
                        <td class="item-detail">
                            {!! $item->questionnaire_items !!}
                        </td>
                        @foreach($answerSurveillanceQuestionnaires as $answer)
                            @if($answer->questionnaire_id == $item->id)
                                <td class="method-columns">{{ $answer->answer == 'periksa' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'bersihkan' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'perbaiki' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'mengganti' ? '✓' : '' }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                
                <tr>
                    <td rowspan="5" class="subsection">1.3 </td>
                    <td colspan="5" class="subsection">Periksa infrastruktur jaringan / Check network infrastructure</td>
                </tr>

                @foreach ($checkNetworkInfrastructure as $item)
                    <tr>
                        <td class="item-detail">
                            {!! $item->questionnaire_items !!}
                        </td>
                        @foreach($answerSurveillanceQuestionnaires as $answer)
                            @if($answer->questionnaire_id == $item->id)
                                <td class="method-columns">{{ $answer->answer == 'periksa' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'bersihkan' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'perbaiki' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'mengganti' ? '✓' : '' }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div>
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
                    <td class="no-column section-header">2</td>
                    <td colspan="5" class="section-header">Pengujian Perangkat Lunak / Software Testing</td>    
                </tr>

                @foreach ($softwareTesting as $item)
                    <tr>
                        <td class="no-column section-header">2.{{$loop->iteration}} </td>
                        <td class="item-detail">
                            {!! $item->questionnaire_items !!}
                        </td>
                        @foreach($answerSurveillanceQuestionnaires as $answer)
                            @if($answer->questionnaire_id == $item->id)
                                <td class="method-columns">{{ $answer->answer == 'periksa' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'bersihkan' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'perbaiki' ? '✓' : '' }}</td>
                                <td class="method-columns">{{ $answer->answer == 'mengganti' ? '✓' : '' }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <td colspan="6" class="recommendation-section">
                        <div style="font-weight: bold; text-align: start;">
                            REKOMENDASI PENGGANTIAN BARU / RECOMMENDATION OF NEW REPLACEMENT
                        </div>
                        <div class="recommendation-content">
                            {{$answerSurveillanceQuestionnaires->where('questionnaire_id', '0')->first()->answer ?? ''}}
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
                            <i>Para pihak/ Performer:</i> {{$performer[0]->NAMA_KARYAWAN}}
                        </div>
                        <div class="signature-field">
                            <i>Nama jabatan/ Job title:</i> {{$performer[0]->BAG}}
                        </div>
                        <div class="signature-field">
                            <i>Tanggal/ Date:</i> {{ \Carbon\Carbon::parse($surveillanceSystemMaintenance[0]->approval_date)->format('d-m-Y') }}
                        </div>
                        <div class="signature-field">
                            <i>Tanda tangan/ Signature:</i>
                            @if($surveillanceSystemMaintenance[0]->approval_progress == '2' && $surveillanceSystemMaintenance[0]->status == 'approved')
                                @php
                                    $imagePathSign2 = public_path('storage/signature/'. $surveillanceSystemMaintenance[0]->signature_img);
                                    $imageSign2 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign2));
                                @endphp
                                    <div class="signature-image">
                                        <img src="{{$imageSign2}}" alt="Requesting Person Signature" style="max-width: 50%; max-height: 50%; object-fit: contain;">
                                    </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="signature-field">
                            <i>Para pihak/ Performer:</i> {{$surveillanceSystemMaintenance[1]->name}}
                        </div>
                        <div class="signature-field">
                            <i>Nama Jabatan/ Job title:</i> {{$surveillanceSystemMaintenance[1]->dept}}
                        </div>
                        <div class="signature-field">
                            <i>Tanggal/ Date:</i> {{ \Carbon\Carbon::parse($surveillanceSystemMaintenance[1]->approval_date)->format('d-m-Y') }}
                        </div>
                        <div class="signature-field">
                            <i>Tanda tangan/ Signature:</i>
                            @if($surveillanceSystemMaintenance[1]->approval_progress == '2' && $surveillanceSystemMaintenance[1]->status == 'approved')
                                @php
                                    $imagePathSign1 = public_path('storage/signature/'. $surveillanceSystemMaintenance[1]->signature_img);
                                    $imageSign1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign1));
                                @endphp
                                    <div class="signature-image">
                                        <img src="{{$imageSign1}}" alt="Requesting Person Signature" style="max-width: 50%; max-height: 50%; object-fit: contain;">
                                    </div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>