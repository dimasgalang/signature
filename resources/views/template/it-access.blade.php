<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FORMULIR PERMINTAAN AKSES IT</title>
  <style>
    @page {
        size: A4;
        margin: 5mm;
    }
    body {
      font-family: Arial, sans-serif;
      line-height: 1.5;
      max-width: 800px;
      margin: 10px auto;
      padding: 5px;
    }
    h1 {
      text-align: center;
      text-transform: uppercase;
      font-size: 18px;
      margin-bottom: 30px;
    }
    .section {
      margin-bottom: 15px;
    }
    .form-field {
      margin-bottom: 10px;
    }
    .form-label {
      font-weight: bold;
    }
    .signature {
      width: 100%;
    }

    .signature td {
      vertical-align: top;
      padding: 20px;
    }

    .signature td:first-child {
      text-align: center;
      padding-right: 50px;
    }

    .signature td:last-child {
      text-align: center;
    }

    .signature div {
      text-align: center;
      width: 45%;
    }
    table #leaver-table {
      width: 100%;
      border-collapse: collapse;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }
    th, td {
      border: 1px solid #000;
      padding: 3px;
      text-align: start;
    }
    .note {
      margin-top: 15px;
    }
  </style>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }
    
    .form-container {
        flex: row;
        padding: 10px;
        margin: 0 auto;
    }
    
    .form-row {
        display: flex;
        align-items: start;
        margin-bottom: -2px;
        min-height: 25px;
    }
    
    .form-row:last-child {
        margin-bottom: -15px;
    }
    
    .label {
        font-size: 12px;
        font-weight: normal;
        color: #000;
        margin-right: 10px;
        white-space: nowrap;
    }
    
    .underline {
        align-items: flex-start;
        padding-bottom: 2px;
        margin-right: 0;
        margin-left: 0px;
        white-space: nowrap;
    }
    
    .value {
        margin: 0;
        font-size: 12px;
        color: #000;
        white-space: nowrap;
    }

    .reason {
        padding-left: 5px;
        padding-bottom: 2px;
        white-space: normal;
    }
    
    .short-field {
        margin-left: 0px;
        text-align: left;
        width: 80px;
        flex-grow: 0;
    }
    
    .medium-field {
        text-align: left;
        width: 90px;
        flex-grow: 0;
    }
    
    .request-row {
        margin-top: 15px;
    }
    
    .request-text {
        font-size: 12px;
        color: #000;
    }
    
    .request-underline {
        border-bottom: 0.3px #000;
        height: 20px;
        width: 100%;
    }
    
    .hardware-section {
        margin-top: 0;
        margin-bottom: -5px;
    }
    
    .hardware-table {
        width: 100%;
        border-bottom: none !important;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .hardware-table th {
        padding: 8px;
        font-weight: normal;
        text-align: left;
        vertical-align: top;
    }
    
    .hardware-table td {
        padding: 8px;
        vertical-align: top;
    }

    .no-border-bottom {
        border-bottom: none !important;
    }
    
    .device-column {
        width: 60%;
    }
    
    .qty-column {
        width: 136px;
        text-align: start;
    }
    
    .approval-column {
        width: 120px;
        text-align: center;
    }
    
    .checkbox-item {
        display: flex;
        align-items: start;
    }
    
    .checkbox-item input[type="checkbox"] {
        width: 14px;
        height: 14px;
        margin-right: 8px;
        margin-top: 1px;
    }
    
    .checkbox-item label {
        font-size: 12px;
        color: #000;
        cursor: default;
    }
    
    .qty-cell {
        text-align: center;
        vertical-align: end;
    }
    
    .qty-box {
        /* display: inline-block; */
        border-bottom: 1px solid #000;
        min-width: 90px;
        text-align: center;
        font-size: 12px;
        vertical-align: end;
    }
    
    .approval-cell {
        text-align: center;
        vertical-align: middle;
    }
    
    .approval-options {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        align-content: flex-start;
        gap: 12px;
    }
    
    .approval-options input[type="checkbox"] {
        width: 12px;
        height: 12px;
        /* padding: 2px; */
        vertical-align: top;
    }
    
    .approval-options label {
        font-size: 11px;
        color: #000;
        vertical-align: bottom;
        margin-right: 3px;
        margin-top: 5px;
    }
    
    .device-detail {
        padding-left: 25px;
        position: relative;
    }
    
    .number {
        position: absolute;
        font-size: 12px;
        color: #000;
    }
    
    .detail-underline {
        border-bottom: 1px solid #000;
        height: 20px;
        display: flex;
        align-items: flex-start;
        padding-bottom: 2px;
    }
    
    .detail-value {
        font-size: 12px;
        color: #000;
        padding-left: 5px;
    }
    
    .other-devices-cell {
        vertical-align: top;
        padding-top: 8px;
    }
    
    .device-details {
        margin-top: 10px;
    }
    
    .device-detail-item {
        padding-left: 10px;
        /* position: relative;
        margin-bottom: 8px; */
    }
    
    .device-detail-item:last-child {
        margin-bottom: 0;
    }
    
    .device-detail-item .number {
        position: absolute;
        left: 0;
        font-size: 12px;
        color: #000;
    }
    
    .device-detail-item .detail-underline {
        border-bottom: 1px solid #000;
        height: 20px;
        display: flex;
        align-items: flex-start;
        /* padding-bottom: 2px; */
    }
    
    .other-devices-qty {
        vertical-align: top;
        /* padding-top: 8px; */
    }

    .access-right {
        vertical-align: top;
        padding-top: 4px;
    }
    
    .qty-details {
        /* display: flex; */
        margin-top: 10px;
        vertical-align: middle;
        /* flex-direction: column; */
    }
    
    .qty-item {
        height: 30;
        display: flex;
        align-items: center;
        justify-content: start;
    }
    .access-right-item {
        /* height: 30; */
        /* margin-top: 10px; */
        /* display: flex; */
        align-items: center;
        justify-content: start;
    }
    
    /* .qty-item:first-child {
        height: 40px;
    } */
    
    /* .other-devices-approval {
        vertical-align: top;
        padding-top: 8px;
    } */
    
    .approval-details {
        /* display: flex; */
        /* margin-top: 10px; */
        vertical-align: end;
        /* flex-direction: column; */
    }
    
    .approval-item {
        height: 30px;
        /* display: flex; */
        vertical-align: middle;
        align-items: center;
        justify-content: center;
    }
    
    /* .approval-item:first-child {
        height: 30px;
    } */

    .signature-container {
        width: 100%;
        max-width: 800px;
        font-family: Arial, sans-serif;
        
    }
    
    .signature-table {
        width: 100%;
    }
    
    .signature-cell {
        width: 33.33%;
        padding: 10px;
        text-align: center;
        vertical-align: top;
    }
    
    .signature-title {
        font-size: 12px;
        font-weight: normal;
        color: #000;
    }
    
    .signature-subtitle {
        font-size: 10px;
        font-style: italic;
        color: #666;
    }
    
    .signature-image {
        width: 200px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .signature-name {
        margin-top: -10px;
        font-size: 12px;
        font-weight: normal;
        color: #000;
    }
    
    .signature-line {
        width: 200px;
        height: 0.5px;
        justify-content: center;
        font-size: 11px;
        background-color: #000;
        margin: 0 auto;
    }
    
    .signature-table,
    .signature-table th,
    .signature-table td {
        border: none !important;
    }
    
    @media print {
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            zoom: 100%; /* atau 1 */
        }
        .signature-container {
            margin: 0;
            max-width: none;
            width: 100%;
        }
        @page {
            size: auto; /* atau A4, landscape, dsb sesuai kebutuhan */
            margin: 10mm; /* atur margin sesuai kebutuhan */
        }
    }
</style>
</head>
<body>

    <table id="leaver-table">
        <tr>
            <td class="header" style="margin: 0px;">
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
                    <h3 style="margin: 0px;">FORMULIR PERMINTAAN <br> AKSES IT</h3>
                    <h3 style="margin: 0px;"><i>IT Access Request Form</i></h3>
                </center>
            </td>
            <td class="header" style="text-align: center; vertical-align: middle;">
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Doc#: 01/FM-PL05</p>
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Revision: 00</p>
                    <p style="font-size:11px; x-small; margin:0; text-align: left;">Effective: {{\Carbon\Carbon::parse($accessRequest[0]->date_of_request)->format('d-F-Y')}}</p>
            </td>
        </tr>
    </table>

<table class="signature-table">
    <tr style="border: none;">
        <td class="label short-field">Tanggal/ Date :</td>
        <td class="underline value"> {{\Carbon\Carbon::parse($accessRequest[0]->date_of_request)->format('d F Y')}}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
    <tr>
        <td class="label">Nama/ Name :</td>
        <td class="underline value">
            {{$accessRequest[0]->name}}
        </td>
        
        <td class="label medium-field">ID Karyawan/ Employee ID :</td>
        <td class="underline value">{{$accessRequest[0]->npk}}
        </td>
        
        <td class="label" style="width: 50px">Dep/ Dept :</td>
        <td class="underline value">
            {{$accessRequest[0]->dept}}
        </td>
    </tr>
    
    <!-- Row 3: Permintaan Dep IT -->
    <tr>
        <td colspan="6" class="request-text">
            Permintaan Dep IT untuk/ <i>Request IT Department for :</i>
        </td>
    </tr>
</table>

<!-- Hardware Device Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <thead>
            <tr>
                <th class="device-column">Perangkat keras/ Hardware device</th>
                <th class="qty-column"><center>Jumlah/ Qty</center></th>
                <th class="approval-column"><center>Persetujuan/ Approval</center></th>
            </tr>
        </thead>
        <tbody>
            @if(count($computerRequests) > 0)

            <tr style="border-bottom: none !important;">
                <td class="device-row">
                    <div class="checkbox-item">
                        <input type="checkbox" id="computer" checked disabled>
                        <label for="computer">Komputer/ Computer</label>
                    </div>
                    <div class="checkbox-item" style="margin-left: 25px">
                        <label for="computer">Purpose : {{$computerRequests[0]->purpose}}</label>
                    </div>
                    <div class="checkbox-item" style="margin-left: 25px">
                        <label for="computer">Restriction : {{$computerRequests[0]->restriction}}</label>
                    </div>
                </td>
                <td class="qty-cell">
                    <center>
                        <br>
                        <div class="qty-box">
                            {{$computerRequests[0]->qty}}
                        </div>
                    </center>
                </td>
                <td class="approval-cell">
                    <br>
                    <div class="approval-options">
                        <input type="checkbox" id="computer-yes" {{$computerRequests[0]->status_approved == 'true' ? 'checked' : ''}} disabled> 
                        <label for="computer-yes">Yes</label>
                        <input type="checkbox" id="computer-no" {{$computerRequests[0]->status_approved == 'false' ? 'checked' : ''}} disabled>
                        <label for="computer-no">No</label>
                    </div>
                </td>
            </tr>
            @endif

            @if(count($otherDevices) > 0)
            
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell">
                    <div class="checkbox-item">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="other-devices">Perangkat lainnya/ Other Devices :</label>
                    </div>
                    @foreach($otherDevices as $device)
                    <div class="device-details">
                        <div class="device-detail-item">
                            <span class="detail-underline" style="color: #000">
                                {{$device->hardware_device}}
                            </span>
                        </div>
                        <div class="device-detail-item">
                            <span class="detail-underline" style="color: #000">
                                Purpose : {{$device->purpose}}
                            </span>
                        </div>
                        <div class="device-detail-item">
                            <span class="detail-underline" style="color: #000">
                                Restriction : {{$device->restriction}}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="qty-cell other-devices-qty">
                    @foreach($otherDevices as $device)
                    <br><br><br>
                    <div class="">
                        <center>
                            <div class="qty-box">
                                {{$device->qty}}
                            </div>
                        </center>
                    </div>
                    @endforeach
                </td>
                <td class="approval-cell other-devices-approval">
                    @foreach($otherDevices as $device)
                    <br><br><br>
                    <div class="approval-details">
                        <div style="vertical-align: middle; align-items: center; justify-content: center;">
                            <div class="approval-options">
                                <input type="checkbox" id="monitor-yes" {{$device->status_approved == 'true' ? 'checked' : ''}} disabled>
                                <label for="monitor-yes">Yes</label>
                                <input type="checkbox" id="monitor-no" {{ $device->status_approved == 'false' ? 'checked' : ''}} disabled>
                                <label for="monitor-no">No</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
            @endif

        </tbody>
    </table>
</div>

@if(count($userAccounts) > 0)
<!-- User Account Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell">
                    <div class="checkbox-item">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="computer">Akun Pengguna Domain Perusahaan/ Company Domain User Account</label>
                    </div>
                    @foreach($userAccounts as $account)
                    <div class="device-details">
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value"> Nama akun/ Account Name : </span>
                                {{$account->account_name}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    <br>
                    @foreach($userAccounts as $account)
                    <div class="approval-item">
                        <div class="approval-options">
                            <input type="checkbox" id="monitor-yes" {{$account->status_approved == 'true' ? 'checked' : ''}} disabled>
                            <label for="monitor-yes">Yes</label>
                            <input type="checkbox" id="monitor-no" {{ $account->status_approved == 'false' ? 'checked' : ''}} disabled>
                            <label for="monitor-no">No</label>
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

@if(count($emailAccount) > 0)
<!-- Email Address Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell">
                    <div class="checkbox-item">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="computer">Alamat email / Email Address:</label>
                    </div>
                    @foreach($emailAccount as $email)
                    <div class="device-details" style="margin-bottom: 3px;">
                        <div class="device-detail-item">
                            <div class="detail-underline" style="margin-bottom: 5px">
                                <span class="detail-value"> Email Address :</span> 
                                {{$email->email_address}}
                            </div>
                            <div class="detail-underline" style="margin-bottom: 5px">
                                <span class="detail-value"> Tujuan/Purpose :</span>
                                {{$email->purpose}}
                            </div>
                            <div class="detail-underline">
                                <span class="detail-value"> Pembatasan/Restriction :</span>
                                {{$email->restriction}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    <br><br>
                    @foreach($emailAccount as $email)
                    <div class="approval-item" style="height: 10px;">
                        <div class="approval-options" style="gap: 0;">
                            <input type="checkbox" id="monitor-yes" {{$email->status_approved == 'true' ? 'checked' : ''}} disabled>
                            <label for="monitor-yes">Yes</label>
                            <input type="checkbox" id="monitor-no" {{$email->status_approved == 'false' ? 'checked' : ''}} disabled> 
                            <label for="monitor-no">No</label>
                        </div>
                    </div>
                    <br><br><br><br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

@if(count($internetAccess) > 0)
<!-- Internet Access Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell">
                    <div class="checkbox-item">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="computer">Akses Internet/Internet Access :</label>
                    </div>
                    @foreach($internetAccess as $internet)
                    <div class="device-details" style="margin-bottom: 3px;">
                        <div class="device-detail-item">
                            <div class="detail-underline" style="margin-bottom: 5px">
                                {{-- <span class="number"></span> --}}
                                <span class="detail-value"> Tujuan/Purpose :</span>
                                {{$internet->purpose}}
                            </div>
                            <div class="detail-underline">
                                <span class="detail-value"> Pembatasan/Restriction :</span>
                                {{$internet->restriction}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    @foreach($internetAccess as $internet)
                    <br>
                    <br>
                    <div class="approval-item">
                        <div class="approval-options">
                            <input type="checkbox" id="monitor-yes" {{$internet->status_approved  == 'true' ? 'checked' : ''}} disabled>
                            <label for="monitor-yes">Yes</label>
                            <input type="checkbox" id="monitor-no" {{$internet->status_approved == 'false' ? 'checked' : ''}} disabled>
                            <label for="monitor-no">No</label>
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

@if(count($fileFolderAccesses) > 0)
<!-- File Folder Access Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="access-right">
                <td class="device-row other-devices-cell" style="width: 280px">
                    <div class="checkbox-item align-items-start">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="computer">Akses file dan folder/ File and folder Access :</label>
                    </div>
                    @foreach($fileFolderAccesses as $fileFolder)
                    <div class="device-details">
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value">
                                    {{$fileFolder->file_folder_name}}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="qty-cell other-devices-qty">
                    <br>
                    @foreach($fileFolderAccesses as $fileFolder)
                    <div class="qty-details">
                        <div class="access-right-item">
                            <div class="qty-box">Hak Akses/Access Right : 
                                <input type="checkbox" id="monitor-yes" {{$fileFolder->read == 'true' ? 'checked' : ''}} disabled>
                                <label for="monitor-yes">R</label>
                                <input type="checkbox" id="monitor-no" {{$fileFolder->write == 'true' ? 'checked' : ''}} disabled>
                                <label for="monitor-no">W</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    <br>
                    @foreach($fileFolderAccesses as $fileFolder)
                    <div class="approval-item">
                        <div class="approval-options">
                            <input type="checkbox" id="monitor-yes" {{$fileFolder->status_approved == 'true' ? 'checked' : ''}} disabled>
                            <label for="monitor-yes">Yes</label>
                            <input type="checkbox" id="monitor-no" {{$fileFolder->status_approved == 'false' ? 'checked' : ''}} disabled>
                            <label for="monitor-no">No</label>
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

@if(count($applicationPrograms) > 0)
<!-- Application Program Access Table -->
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell" style="width: 280px">
                    <div class="checkbox-item align-items-start">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="computer">Akses program aplikasi/ Application Program :</label>
                    </div>
                    @foreach($applicationPrograms as $application)
                    <div class="device-details">
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value">
                                    {{$application->application_name}}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="qty-cell other-devices-qty">
                    <br>
                    @foreach($applicationPrograms as $application)
                    <div class="qty-details">
                        <div class="access-right-item align-items-start" style="margin-top: 8px;">
                            <div class="" style="border-bottom: 1px solid #000; display: flex; align-items: flex-start;">Nama Masuk/Login Name : {{$application->login_name}}</div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    <br>
                    @foreach($applicationPrograms as $application)
                    <div class="approval-item">
                        <div class="approval-options">
                            <input type="checkbox" id="monitor-yes" {{$application->status_approved == 'true' ? 'checked' : '' }} disabled>
                            <label for="monitor-yes">Yes</label>
                            <input type="checkbox" id="monitor-no" {{$application->status_approved == 'false' ? 'checked' : ''}} disabled>
                            <label for="monitor-no">No</label>
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

@if(count($otherRequests) > 0)
<div class="hardware-section">
    <table class="hardware-table">
        <tbody>
            <tr class="other-devices-row">
                <td class="device-row other-devices-cell">
                    <div class="checkbox-item align-items-start">
                        <input type="checkbox" id="other-devices" checked disabled>
                        <label for="other-devices">Permintaan Lainnya/ <i>Other Request</i> :</label>
                    </div>
                    @foreach($otherRequests as $other)
                    <div class="device-details">
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value">
                                    {{$other->other_request}}
                                </span>
                            </div>
                        </div>
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value">
                                    Purpose : {{$other->purpose}}
                                </span>
                            </div>
                        </div>
                        <div class="device-detail-item">
                            <div class="detail-underline">
                                <span class="detail-value">
                                    Restriction : {{$other->restriction}}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </td>
                <td class="approval-column">
                    <div><center>Persetujuan/ Approval</center></div>
                    <br><br>
                    @foreach($otherRequests as $other)
                    <div class="approval-item" style="height: 10px;">
                        <div class="approval-options" style="gap: 0;">
                            <input type="checkbox" id="request-yes" {{$other->status_approved == 'true' ? 'checked' : ''}} disabled>
                            <label for="request-yes" style="vertical-align: end; margin-top: 0;">Yes</label>
                            <input type="checkbox" id="request-no" {{$other->status_approved == 'false' ? 'checked' : ''}} disabled>
                            <label for="request-no" style="vertical-align: end; margin-top: 0;">No</label>
                        </div>
                    </div>
                    <br><br><br><br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

<div class="signature-container">
    <table class="signature-table">
        
        <tr>
            <td class="signature-cell">
                <div class="signature-title">Orang yang Meminta</div>
                <div class="signature-subtitle">Requesting Person</div>
                @if($accessRequest[0]->approval_progress == '3')
                    @php
                        $imagePathSign3 = public_path('storage/signature/'. $accessRequest[0]->signature_img);
                        $imageSign3 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign3));
                    @endphp
                    <div class="signature-image">
                        <img src="{{$imageSign3}}" alt="Requesting Person Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <center>
                        <p class="signature-name">{{$accessRequest[0]->name}}</p>
                    </center>
                @else
                    <div class="signature-image"></div>
                @endif
                <div class="signature-line"></div>
            </td>
            
            <td class="signature-cell">
                <div class="signature-title">Disetujui oleh kepala Departemen</div>
                <div class="signature-subtitle">Approved by Department Head</div>
                @if($accessRequest[0]->approval_progress == '3')
                    @php
                        $imagePathSign2 = public_path('storage/signature/'. $accessRequest[1]->signature_img);
                        $imageSign2 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign2));
                    @endphp
                    <div class="signature-image">
                        <img src="{{$imageSign2}}" alt="Department Head Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <center>
                        <p class="signature-name">{{$accessRequest[1]->name}}</p>
                    </center>
                @else
                    <div class="signature-image"></div>
                @endif
                <div class="signature-line"></div>
            </td>
            
            <td class="signature-cell">
                <div class="signature-title">Disetujui oleh BOD</div>
                <div class="signature-subtitle">Approved by BOD</div>
                @if($accessRequest[0]->approval_progress == '3')
                    @php
                        $imagePathSign1 = public_path('storage/signature/'. $accessRequest[2]->signature_img);
                        $imageSign1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign1));
                    @endphp
                    <div class="signature-image">
                        <img src="{{$imageSign1}}" alt="BOD Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <center>
                        <p class="signature-name">{{$accessRequest[2]->name}}</p>
                    </center>
                @else
                    <div class="signature-image"></div>
                @endif
                <div class="signature-line"></div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
