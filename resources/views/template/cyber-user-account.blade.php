<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Deaktivasi Pengguna Cyber - PT. Teknologi Maju Indonesia</title>
    <style>
        @page {
            size: A4;
            margin: 10mm 10mm 10mm 10mm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            background: white;
        }
        
        .document-container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            background: white;
        }
        
        .section {
            border: 1px solid #000;
            /* margin-bottom: 8px; */
            page-break-inside: avoid;
        }
        
        .section-header {
            background-color: white;
            border-bottom: 1px solid #000;
            padding: 8px 12px;
            font-weight: bold;
            text-align: start;
            font-size: 12pt;
        }

        /* table #leaver-table {
            width: 100%;
            border-collapse: collapse;
        }
        */

        table {
            width: 100%;
            max-width: 210mm;
            margin-top: 5px;
            justify-content: center;
            align-items: center;

            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: start;
        } 
        
        .section-content {
            padding: 12px;
        }
        
        .form-row {
            margin-bottom: 12px;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }
        
        /* .form-number {
            font-weight: bold;
            margin-right: 8px;
            min-width: 10px;
            flex-basis: 10px;
            display: inline-block;
        } */

        .form-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }
        
        .form-table td {
            padding: 4px;
            vertical-align: top;
            border: none;
        }
        
        .form-number {
            width: 5px;
            text-align: center;
            font-weight: bold;
            background-color: white;
        }
        
        .form-content {
            /* flex: 1;
            flex-grow: 1;
            display: inline-block; */
            display: inline-block;
            width: calc(100% - 20px);
        }
        
        .checkbox-group {
            /* margin-left: 10px; */
            /* margin-top: 8px; */
        }
        
        .checkbox-item {
            /* margin-bottom: 8px; */
            display: flex;
            align-items: flex-start;
        }
        
        /* .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 8px;
            margin-top: 2px;
            flex-shrink: 0;
            position: relative;
        }
        
        .checkbox.checked::after {
            content: '✓';
            position: absolute;
            top: -2px;
            left: 1px;
            font-size: 10px;
            font-weight: bold;
        } */
        
        .date-input-group {
            display: flex;
            align-items: center;
            vertical-align: bottom;
            margin-top: 8px;
            margin-bottom: 10px;
        }
        
        .date-input {
            border: none;
            /* border-bottom: 1px solid #000; */
            /* padding: 2px 4px; */
            margin: 0; 8px;
            max-width: 120px;
            vertical-align: bottom;
            font-family: inherit;
            font-size: inherit;
        }
        
        .employee-info {
            margin-top: 4px;
            /* margin-left: 20px; */
        }
        
        .employee-row {
            display: flex;
            /* margin-bottom: 8px; */
            align-items: flex-start;
            vertical-align: bottom;

        }
        
        .employee-label {
            min-width: 60px;
            font-weight: normal;
        }
        
        .employee-input {
            border: none;
            /* border-bottom: 1px solid #000; */
            padding: 2px 4px;
            margin-left: 4px;
            vertical-align: bottom;
            max-width: 180px;
            font-family: inherit;
            font-size: inherit;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-top: 20px; */
        }
        
        .signature-table th,
        .signature-table td {
            border: none;
            /* padding: 12px 8px; */
            text-align: center;
            margin: 0;
            vertical-align: top;
            /* min-height: 80px; */
        }
        
        .signature-table th {
            background-color: white;
            font-weight: bold;
            font-size: 10pt;
        }
        
        .signature-table td {
            /* height: 80px; */
        }

        .signature-image {
        width: 200px;
        margin: 0;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        }   
        
        .followup-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .followup-table th,
        .followup-table td {
            border: none;
            /* padding: 12px; */
            vertical-align: top;
        }
        
        .followup-table th {
            background-color: white;
            font-weight: bold;
            width: 70%;
        }
        
        .followup-table td {
            width: 30%;
            text-align: start;
            /* height: 100px; */
        }
        
        .followup-checkbox-item {
            /* margin-bottom: 4px; */
            display: flex;
            align-items: flex-start;
        }
        
        .italic-text {
            font-style: italic;
            color: black;
        }
        
        .bold-text {
            font-weight: bold;
        }
        
        .indent-1 {
            margin-left: 20px;
        }
        
        .indent-2 {
            margin-left: 40px;
        }

        .checkbox-cell {
            /* width: auto; */
            max-width: 100px;
            text-align: start;
            white-space: nowrap;
        }
        
        .content-cell {
            width: 100%;
            margin: 0;
        }

        input[type="checkbox"] {
            margin: 0;
        }
        
        /* @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            
            .section {
                page-break-inside: avoid;
            }
        } */
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
                        <h3 style="margin: 0px;">MENIT PENONAKTIFAN ATAU <br> PENGHAPUSAN AKUN PENGGUNA CYBER</h3>
                        <h3 style="margin: 0px;"><i>Cyber User Account Deactivation or Removal <br> Minutes</i></h3>
                    </center>
                </td>
                <td class="header" style="text-align: center; vertical-align: middle;">
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Doc#: 01/FM-PL05</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Revision: 00</p>
                        <p style="font-size:11px; x-small; margin:0; text-align: left;">Effective: {{\Carbon\Carbon::parse($userDeactivateRequest[0]->date_of_request)->format('d-F-Y')}}</p>
                </td>
            </tr>
        </table>
    </center>

    <div class="document-container">
        <!-- Section I: Deactivation -->
        <div class="section">
            <div class="section-header">
                I. <span class="bold-text">PENONAKTIFAN PENGGUNA CYBER / <span class="italic-text">DEACTIVATION OF CYBER USER</span>:</span>
            </div>
            <div class="section-content">
                <!-- Item 1 -->
                <table class="form-table">
                    <!-- Item 1 -->
                    <tr>
                        <td class="form-number">1.</td>
                        <td class="form-content">
                            <div>
                                Pada tanggal <span class="bold-text">{{\Carbon\Carbon::parse($userDeactivateRequest[0]->date_of_request)->format('d F Y')}}</span>, 
                                Departemen IT akan menindaklanjuti permintaan dari <span class="bold-text">Departemen HR/Kepala Departemen</span> 
                                terkait dengan isi sebagai berikut:
                            </div>
                            <div class="italic-text">
                                <em>IT Dept proceed to take below outlined action in accordance with the request by <span class="bold-text">HR Dept/ Head of Dept</span>.</em>
                            </div>

                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="permanent" {{$userDeactivateRequest[0]->deactivate == 'permanent' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>
                                        <div>Menghapus atau menghentikan secara permanen seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan.</div>
                                        <div class="italic-text">
                                            <em>Remove or terminate permanently the whole Cyber and IT related access right to Company's information systems.</em>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="temporary" {{$userDeactivateRequest[0]->deactivate == 'temporarily' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>
                                        <div>Menonaktifkan sementara seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan dalam kurun waktu di bawah ini:</div>
                                        <div class="italic-text1">
                                            <em>Deactivate temporarily the whole Cyber and IT related access right to Company's information systems within the below period:</em>
                                        </div>
                                        <div class="date-input-group">
                                            <span>Tanggal mulai/<em>Start date</em>:</span>
                                            <input type="text" class="date-input" value="{{$userDeactivateRequest[0]->start_date ? \Carbon\Carbon::parse($userDeactivateRequest[0]->start_date)->format('d F Y') : '-'}}" readonly>
                                            <span>Tanggal selesai/<em>End date</em>:</span>
                                            <input type="text" class="date-input" value="{{$userDeactivateRequest[0]->end_date ? \Carbon\Carbon::parse($userDeactivateRequest[0]->end_date)->format('d F Y') : '-'}}" readonly>
                                        </div>
                                        {{-- <tr>
                                            <td style="white-space: nowrap;" class="label-cell">Tanggal mulai/<em>Start date</em>:</td>
                                            <td style="white-space: nowrap;" class="input-cell"><input type="text" class="date-input" value="26 Juli 2025" readonly></td>
                                            <td style="white-space: nowrap;" class="label-cell">Tanggal selesai/<em>End date</em>:</td>
                                            <td style="white-space: nowrap;" class="input-cell"><input type="text" class="date-input" value="30 Agustus 2025" readonly></td>
                                        </tr> --}}
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="permanent" checked>
                                    <div>
                                        <div>Menghapus atau menghentikan secara permanen seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan.</div>
                                        <div class="italic-text">
                                            <em>Remove or terminate permanently the whole Cyber and IT related access right to Company's information systems.</em>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="checkbox-item">
                                    <input type="checkbox" id="temporary" checked>
                                    <div>
                                        <div>Menonaktifkan sementara seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan dalam kurun waktu di bawah ini:</div>
                                        <div class="italic-text1">
                                            <em>Deactivate temporarily the whole Cyber and IT related access right to Company's information systems within the below period:</em>
                                        </div>
                                        <div class="date-input-group">
                                            <span>Tanggal mulai/<em>Start date</em>:</span>
                                            <input type="text" class="date-input" value="26 Juli 2025" readonly>
                                            <span>Tanggal selesai/<em>End date</em>:</span>
                                            <input type="text" class="date-input" value="30 Agustus 2025" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </td>
                    </tr>
                    
                    <!-- Item 2 -->
                    <tr>
                        <td class="form-number">2.</td>
                        <td class="form-content">
                            <div>Karena alasan di bawah ini / <em>Due to below reason</em>:</div>

                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="termination" {{$userDeactivateRequest[0]->reason_id == '1' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>Pemutusan hubungan kerja, Berhenti dari pekerjaan. / <em>Termination, Quit job.</em></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="maternity" {{$userDeactivateRequest[0]->reason_id == '2' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>Cuti hamil. / <em>Maternity leave.</em></div>                                
                                </td>
                            </tr>
                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="personal-leave" {{$userDeactivateRequest[0]->reason_id == '3' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>Cuti pribadi panjang. / <em>Long personal leave.</em></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-number">
                                    <input type="checkbox" id="work-change" {{$userDeactivateRequest[0]->reason_id == '4' ? 'checked' : ''}}>
                                </td>
                                <td class="form-content">
                                    <div>Perubahan tuntutan pekerjaan / <em>Change of work demands.</em></div>
                                </td>
                            </tr>

                            {{-- <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="termination" checked>
                                    <div>Pemutusan hubungan kerja, Berhenti dari pekerjaan. / <em>Termination, Quit job.</em></div>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="maternity" checked>
                                    <div>Cuti hamil. / <em>Maternity leave.</em></div>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="personal-leave" checked>
                                    <div>Cuti pribadi panjang. / <em>Long personal leave.</em></div>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="work-change" checked>
                                    <div>Perubahan tuntutan pekerjaan / <em>Change of work demands.</em></div>
                                </div>
                            </div> --}}
                        </td>
                    </tr>
                    
                    <!-- Item 3 -->
                    <tr>
                        <td class="form-number">3.</td>
                        <td class="form-content">
                            <div>Kepada/ <em>toward</em>:</div>
                            <div class="employee-info">
                                <div class="employee-row">
                                    <span class="employee-label">Nama Lengkap/ <em>Full name</em>:</span>
                                    <input type="text" class="employee-input" style=" min-width: 100px;" value="{{$employee[0]->NAMA_KARYAWAN}}" readonly>
                                    <span>NPK/<em>Employee No</em>:</span>
                                    <input type="text" class="employee-input" value="{{$employee[0]->NPK}}" readonly style=" width: auto; min-width: 80px; max-width: 300px;">
                                </div>
                                <div class="employee-row">
                                    <span class="employee-label">Posisi/ <em>Position</em>:</span>
                                    <input type="text" class="employee-input" style="min-width: 250px;" value="{{$employee[0]->BAG}}" readonly>
                                    <span>Dept. (<em>Dept</em>.):</span>
                                    <input type="text" class="employee-input" value="{{$employee[0]->DEPARTEMENT}}" readonly style="min-width: 80px;">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <!-- Signature Table -->
                <table class="signature-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="bold-text">Diminta oleh</div>
                                <div class="italic-text"><em>Requested by</em></div>
                            </th>
                            <th>
                                <div class="bold-text">Diminta Oleh</div>
                                <div class="italic-text"><em>Requested by</em></div>
                            </th>
                            <th>
                                <div class="bold-text">Dilaksanakan oleh</div>
                                <div class="italic-text"><em>Implemented by</em></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($userDeactivateRequest[0]->approval_progress == '3' && $userDeactivateRequest[0]->status == 'approved')
                                @php
                                    $imagePathSign3 = public_path('storage/signature/'. $userDeactivateRequest[0]->signature_img);
                                    $imageSign3 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign3));
                                @endphp
                                    <div class="signature-image">
                                        <img src="{{$imageSign3}}" alt="Requesting Person Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($userDeactivateRequest[1]->approval_progress == '3' && $userDeactivateRequest[1]->status == 'approved')
                                @php
                                    $imagePathSign2 = public_path('storage/signature/'. $userDeactivateRequest[1]->signature_img);
                                    $imageSign2 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign2));
                                @endphp
                                    <div class="signature-image">
                                        <img src="{{$imageSign2}}" alt="Requesting Person Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($userDeactivateRequest[2]->approval_progress == '3' && $userDeactivateRequest[2]->status == 'approved')
                                @php
                                    $imagePathSign1 = public_path('storage/signature/'. $userDeactivateRequest[2]->signature_img);
                                    $imageSign1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign1));
                                @endphp
                                    <div class="signature-image">
                                        <img src="{{$imageSign1}}" alt="Requesting Person Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: bold;">{{$userDeactivateRequest[0]->name}}</div>
                                <div style="font-size: 10pt; margin-top: 5px;">{{$userDeactivateRequest[0]->dept}}</div>
                            </td>
                            <td>
                                <div style="font-weight: bold;">{{$userDeactivateRequest[1]->name}}</div>
                                <div style="font-size: 10pt; margin-top: 5px;">{{$userDeactivateRequest[1]->dept}}</div>
                            </td>
                            <td>
                                <div style="font-weight: bold;">{{$userDeactivateRequest[2]->name}}</div>
                                <div style="font-size: 10pt; margin-top: 5px;">{{$userDeactivateRequest[2]->dept}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Section II: Reactivation Follow-up -->
        <div class="section">
            <div class="section-header">
                II. <span class="bold-text">TINDAK LANJUT REAKTIVASI/ <span class="italic-text">REACTIVATION FOLLOWUP</span></span>
            </div>
            <div class="section-content">
                <table class="followup-table">
                    <thead>
                        <tr>
                            <th>
                                Cakupan tindak lanjut/ <em>Follow up scopes</em>:
                            </th>
                            <th>
                                <center>Tanda tangan / <em>Signature</em></center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="form-followup-table">
                                    <tr>
                                        <td class="content-cell">
                                            <input type="checkbox" id="computer1" {{$userDeactivateRequest[0]->deactivate == 'permanent' ? 'checked' : ''}} style="margin-right: 5px; vertical-align: bottom;">Tidak perlu mengembalikan permintaan di bagian I.1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-cell">
                                            <input type="checkbox" id="computer2" {{$userDeactivateRequest[0]->deactivate == 'temporarily' ? 'checked' : ''}} style="margin-right: 5px; vertical-align: bottom;">Dipulihkan dalam batas waktu yang diperlukan di bagian I.1 pada tanggal:
                                            <input type="text" class="date-input" value="{{$userDeactivateRequest[0]->end_date ? \Carbon\Carbon::parse($userDeactivateRequest[0]->end_date)->addDay()->format('d F Y') : '-'}}" readonly>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="text-align: center;">
                                @if($userDeactivateRequest[2]->approval_progress == '3' && $userDeactivateRequest[2]->status == 'approved')
                                @php
                                    $imagePathSign1 = public_path('storage/signature/'. $userDeactivateRequest[2]->signature_img);
                                    $imageSign1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign1));
                                @endphp
                                <center>
                                    <div style="width: 200px; margin: 0; padding: 0; height: 100px; margin-left: 70px;">
                                        <img src="{{$imageSign1}}" alt="Requesting Person Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                </center>
                                @endif
                                <div style="font-weight: bold;">{{$userDeactivateRequest[2]->name}}</div>
                                <div style="font-size: 10pt; margin-top: 5px;">{{$userDeactivateRequest[2]->dept}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>