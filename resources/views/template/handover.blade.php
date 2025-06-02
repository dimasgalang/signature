<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Berita Acara Serah Terima Barang</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.5;
      max-width: 800px;
      margin: 20px auto;
      padding: 15px;
    }
    h1 {
      text-align: center;
      text-transform: uppercase;
      font-size: 20px;
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
      border-collapse: collapse; /* Agar tabel tidak ada jarak antar sel */
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
    table #handover-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }
    table {
      width: 100%;
      margin-top: 5px;
    }
    th, td {
      border: 1px solid #000;
      padding: 5px;
      text-align: center;
    }
    .header {
      border: none;
    }
    .note {
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <table>
      <tr>
          <td class="header">
              <center>
                <img src="{{ public_path('img/chutex_logo.png') }}" style="width: 70px;">
              </center>
          </td>
          <td class="header">
              <center>
                  <h3>BERITA ACARA SERAH TERIMA BARANG</h3>
              </center>
          </td>
          <td class="header">
                  <p style="font-size: x-small;"><b>No. </b>{{$handover->document_name}}</p>
                  <p style="font-size: x-small;"><b>Tgl. </b>{{ date('Y-m-d', strtotime($handover->date)) }}</p>
          </td>
      </tr>
  </table>
  <hr>

  <div class="section">
    Kami yang bertanda tangan di bawah ini. Pada hari <b>{{\Carbon\Carbon::parse($handover->date)->locale('id_ID')->dayName}}, {{\Carbon\Carbon::parse($handover->date)->day}} {{\Carbon\Carbon::parse($handover->date)->translatedFormat('F')}} {{\Carbon\Carbon::parse($handover->date)->year}}.</b>
  </div>

  <div class="section">
    <div class="form-field"><span class="form-label">Nama:</span> {{$handover->handoverName->name}}</div>
    <div class="form-field"><span class="form-label">Department: </span> {{$handover->handoverName->dept}}</div>
    <div>Selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong></div>
  </div>

  <div class="section">
    <div class="form-field"><span class="form-label">Nama:</span> {{$handover->receiverName->name}} </div>
    <div class="form-field"><span class="form-label">Department:</span> {{$handover->department}}</div>
    <div>Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong></div>
  </div>

  <div class="section" style="text-align: justify;">
    PIHAK PERTAMA menyerahkan barang kepada PIHAK KEDUA, dan PIHAK KEDUA
    menyatakan telah menerima barang dari PIHAK PERTAMA dengan baik sesuai dengan
    informasi yang tercantum di dalam daftar berikut:
  </div>

  <table id="handover-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Item</th>
        <th>Qty</th>
        <th>Unit</th>
      </tr>
    </thead>
    <tbody>
        @foreach($itemData as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item['item_name'] }}</td>
          <td>{{ $item['quantity'] }}</td>
          <td>{{ $item['item_unit'] }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>

  <div class="note" style="text-align: justify;">
    Demikian berita acara serah terima barang ini telah dibuat oleh kedua belah pihak. Adapun barang-barang tersebut diserahkan dalam keadaan baik dan lengkap. Sejak penandatanganan berita acara ini, maka barang tersebut menjadi tanggung jawab dari PIHAK KEDUA dan wajib untuk memelihara/merawat dengan baik serta dipergunakan hanya untuk keperluan perusahaan.
  </div>

  <table class="signature">
    <tr>
      <td style="text-align: center; padding-right: 50px; border: none;">
        Yang Menyerahkan,<br/>
        <strong>PIHAK PERTAMA</strong><br/><br/><br/><br/>
        <b>{{$handover->handoverName->name}}</b><br>
        {{$handover->handoverName->dept}}
      </td>
      <td style="text-align: center; border: none;">
        Yang Menerima,<br/>
        <strong>PIHAK KEDUA</strong><br/><br/><br/><br/>
        <b>{{$handover->receiverName->name}}</b><br>
        {{$handover->department}}
      </td>
    </tr>
  </table>
<hr>

</body>
</html>
