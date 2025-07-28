<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Deaktivasi Pengguna Cyber - PT. Teknologi Maju Indonesia</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm 20mm 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            border: 2px solid #000;
            margin-bottom: 8px;
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

        table {
            width: 100%;
            margin-top: 5px;
        }

        */
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
            align-items: flex-start;
        }
        
        .form-number {
            font-weight: bold;
            margin-right: 8px;
            min-width: 20px;
        }
        
        .form-content {
            flex: 1;
        }
        
        .checkbox-group {
            margin-left: 20px;
            margin-top: 8px;
        }
        
        .checkbox-item {
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }
        
        .checkbox {
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
        }
        
        .date-input-group {
            display: flex;
            align-items: center;
            margin-top: 8px;
            margin-left: 20px;
        }
        
        .date-input {
            border: none;
            border-bottom: 1px solid #000;
            padding: 2px 4px;
            margin: 0 8px;
            min-width: 100px;
            font-family: inherit;
            font-size: inherit;
        }
        
        .employee-info {
            margin-top: 12px;
            margin-left: 20px;
        }
        
        .employee-row {
            display: flex;
            margin-bottom: 8px;
            align-items: center;
        }
        
        .employee-label {
            min-width: 120px;
            font-weight: normal;
        }
        
        .employee-input {
            border: none;
            border-bottom: 1px solid #000;
            padding: 2px 4px;
            margin-left: 8px;
            min-width: 200px;
            font-family: inherit;
            font-size: inherit;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .signature-table th,
        .signature-table td {
            border: 1px solid #000;
            padding: 12px 8px;
            text-align: center;
            vertical-align: top;
            min-height: 80px;
        }
        
        .signature-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 10pt;
        }
        
        .signature-table td {
            height: 80px;
        }
        
        .followup-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .followup-table th,
        .followup-table td {
            border: 1px solid #000;
            padding: 12px;
            vertical-align: top;
        }
        
        .followup-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 60%;
        }
        
        .followup-table td {
            width: 40%;
            text-align: center;
            height: 100px;
        }
        
        .followup-checkbox-item {
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }
        
        .italic-text {
            font-style: italic;
            color: #444;
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
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <table class="document-container" style="border: #000 2px solid;">
        <tr>
            <td class="header" style="margin: 0px;">
                <center>
                  <img src="{{ public_path('img/chutex_logo.png') }}" style="width: 70px;">
                  <h6 style="margin: 0px;">PT. CHUTEX INTERNASIONAL <br> INDONESIA</h6>
              </center>
            </td>
            <td class="header">
                <center>
                    <h3 style="margin: 0px;">FORMULIR PERMINTAAN <br> AKSES IT</h3>
                    <h3 style="margin: 0px;"><i>IT Access Request Form</i></h3>
                </center>
            </td>
            <td class="header" style="text-align: center; vertical-align: middle;">
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Doc#</p>
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Revision: 00</p>
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Date: {{\Carbon\Carbon::parse(now())->format('d/m/Y')}}</p>
            </td>
        </tr>
    </table>

    <div class="document-container">
        <!-- Section I: Deactivation -->
        <div class="section">
            <div class="section-header">
                I. <span class="bold-text">PENONAKTIFAN PENGGUNA CYBER / <span class="italic-text">DEACTIVATION OF CYBER USER</span>:</span>
            </div>
            <div class="section-content">
                <!-- Item 1 -->
                <div class="form-row">
                    <div class="form-number">1.</div>
                    <div class="form-content">
                        <div>
                            Pada tanggal <input type="text" class="date-input" value="25 Juli 2025" readonly>, 
                            Departemen IT akan menindaklanjuti permintaan dari <span class="bold-text">Departemen HR/Kepala Departemen</span> 
                            terkait dengan isi sebagai berikut:
                        </div>
                        <div class="italic-text" style="margin-top: 6px;">
                            <em>IT Dept proceed to take below outlined action in accordance with the request by <span class="bold-text">HR Dept/ Head of Dept</span>.</em>
                        </div>
                        
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <div class="checkbox"></div>
                                <div>
                                    <div>Menghapus atau menghentikan secara permanen seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan.</div>
                                    <div class="italic-text indent-1" style="margin-top: 4px;">
                                        <em>Remove or terminate permanently the whole Cyber and IT related access right to Company's information systems.</em>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="checkbox-item">
                                <div class="checkbox checked"></div>
                                <div>
                                    <div>Menonaktifkan sementara seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan dalam kurun waktu di bawah ini:</div>
                                    <div class="italic-text indent-1" style="margin-top: 4px;">
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
                        </div>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="form-row">
                    <div class="form-number">2.</div>
                    <div class="form-content">
                        <div>Karena alasan di bawah ini / <em>Due to below reason</em>:</div>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <div class="checkbox"></div>
                                <div>Pemutusan hubungan kerja, Berhenti dari pekerjaan. / <em>Termination, Quit job.</em></div>
                            </div>
                            <div class="checkbox-item">
                                <div class="checkbox checked"></div>
                                <div>Cuti hamil. / <em>Maternity leave.</em></div>
                            </div>
                            <div class="checkbox-item">
                                <div class="checkbox"></div>
                                <div>Cuti pribadi panjang. / <em>Long personal leave.</em></div>
                            </div>
                            <div class="checkbox-item">
                                <div class="checkbox"></div>
                                <div>Perubahan tuntutan pekerjaan / <em>Change of work demands.</em></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Item 3 -->
                <div class="form-row">
                    <div class="form-number">3.</div>
                    <div class="form-content">
                        <div>Kepada/ <em>toward</em>:</div>
                        <div class="employee-info">
                            <div class="employee-row">
                                <span class="employee-label">Nama Lengkap/ <em>Full name</em>:</span>
                                <input type="text" class="employee-input" value="Siti Nurhaliza Dewi" readonly>
                                <span style="margin-left: 20px;">ID Pekerja/<em>Employee No</em>:</span>
                                <input type="text" class="employee-input" value="EMP2024001" readonly style="min-width: 120px;">
                            </div>
                            <div class="employee-row">
                                <span class="employee-label">Posisi/ <em>Position</em>:</span>
                                <input type="text" class="employee-input" value="Senior Marketing Specialist" readonly>
                                <span style="margin-left: 20px;">Dept. (<em>Dept</em>.):</span>
                                <input type="text" class="employee-input" value="Marketing & Sales" readonly style="min-width: 120px;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Signature Table -->
                <table class="signature-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="bold-text">Diminta oleh</div>
                                <div class="italic-text"><em>Requested by</em></div>
                                <div style="margin-top: 8px;">Kepala Dept (jika ada)</div>
                                <div class="italic-text"><em>Head of Department (if any)</em></div>
                            </th>
                            <th>
                                <div class="bold-text">Diminta Oleh</div>
                                <div class="italic-text"><em>Requested by</em></div>
                                <div style="margin-top: 8px;">Dept. HR</div>
                                <div class="italic-text"><em>HR Department</em></div>
                            </th>
                            <th>
                                <div class="bold-text">Dilaksanakan oleh</div>
                                <div class="italic-text"><em>Implemented by</em></div>
                                <div style="margin-top: 8px;">Dept. IT</div>
                                <div class="italic-text"><em>IT Department.</em></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div style="margin-top: 40px; font-weight: bold;">Budi Santoso, M.M</div>
                                <div style="font-size: 10pt; margin-top: 5px;">Kepala Dept. Marketing</div>
                            </td>
                            <td>
                                <div style="margin-top: 40px; font-weight: bold;">Indira Sari, S.Psi</div>
                                <div style="font-size: 10pt; margin-top: 5px;">HR Manager</div>
                            </td>
                            <td>
                                <div style="margin-top: 40px; font-weight: bold;">Ahmad Rifai, S.Kom</div>
                                <div style="font-size: 10pt; margin-top: 5px;">IT Manager</div>
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
                                Tanda tangan / <em>Signature</em>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left;">
                                <div class="followup-checkbox-item">
                                    <div class="checkbox checked"></div>
                                    <div>Tidak perlu mengembalikan permintaan di bagian I.1</div>
                                </div>
                                <div class="followup-checkbox-item">
                                    <div class="checkbox"></div>
                                    <div>
                                        <div>Dipulihkan dalam batas waktu yang diperlukan di bagian I.1 pada tanggal:</div>
                                        <input type="text" class="date-input" value="_____________" readonly style="margin-top: 8px;">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>Dept. IT</div>
                                <div class="italic-text"><em>IT Department.</em></div>
                                <div style="margin-top: 40px; font-weight: bold;">Ahmad Rifai, S.Kom</div>
                                <div style="font-size: 10pt; margin-top: 5px;">IT Manager</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>