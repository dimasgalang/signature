<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Berita Acara Serah Terima Barang</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
    }
    h1 {
      text-align: center;
      text-transform: uppercase;
      font-size: 20px;
      margin-bottom: 30px;
    }
    .section {
      margin-bottom: 20px;
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
      margin-top: 15px;
    }
    table {
      width: 100%;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #000;
      padding: 8px;
      text-align: center;
    }
    .header {
      border: none;
    }
    .note {
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <table>
      <tr>
          <td class="header">
              <center>
                  {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('/storage/images/chutex_logo.png'))) }}" style="width: 70px;"> --}}
              </center>
          </td>
          <td class="header">
              <center>
                  <h3>BERITA ACARA SERAH TERIMA BARANG</h3>
              </center>
          </td>
          <td class="header">
                  <p style="font-size: x-small;"><b>No. </b>B25A000106</p>
                  <p style="font-size: x-small;"><b>Tgl. </b>{{ now() }}</p>
          </td>
      </tr>
  </table>
  <hr>

  <div class="section">
    Kami yang bertanda tangan di bawah ini. Pada hari ini ……… Tanggal …… Bulan ……… Tahun ………
  </div>

  <div class="section">
    <div class="form-field"><span class="form-label">Nama:</span> ____________________________________________</div>
    <div class="form-field"><span class="form-label">Department:</span> ____________________________________________</div>
    <div>Selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong></div>
  </div>

  <div class="section">
    <div class="form-field"><span class="form-label">Nama:</span> ____________________________________________</div>
    <div class="form-field"><span class="form-label">Department:</span> ____________________________________________</div>
    <div>Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong></div>
  </div>

  <div class="section">
    PIHAK PERTAMA menyerahkan barang kepada PIHAK KEDUA, dan PIHAK KEDUA
    menyatakan telah menerima barang dari PIHAK PERTAMA dengan baik sesuai dengan
    informasi yang tercantum di dalam daftar terlampir:
  </div>

  <table id="handover-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
        
    </tbody>
  </table>

  <div class="note">
    Demikian berita acara serah terima barang ini telah dibuat oleh kedua belah pihak. Adapun
    barang-barang tersebut diserahkan dalam keadaan baik dan lengkap. Sejak penandatanganan
    berita acara ini, maka barang tersebut menjadi tanggung jawab dari PIHAK KEDUA dan wajib
    untuk memelihara/merawat dengan baik serta dipergunakan untuk keperluan sesuai kebutuhan.
  </div>

  <table class="signature">
    <tr>
      <td style="text-align: center; padding-right: 50px; border: none;">
        Yang Menyerahkan:<br/>
        <strong>PIHAK PERTAMA</strong><br/><br/><br/><br/>
        (......................................)
      </td>
      <td style="text-align: center; border: none;">
        Yang Menerima:<br/>
        <strong>PIHAK KEDUA</strong><br/><br/><br/><br/>
        (......................................)
      </td>
    </tr>
  </table>



<hr>
<table>
    <tr>
        <td>
            <i>
                <p style="font-size: x-small;">ISO 9001</p>
            </i>
        </td>
        <td>
            <i>
                <p style="font-size: x-small;">No. Dok. F.M.A-GA</p>
            </i>
        </td>
        <td>
            <i>
                <p style="font-size: x-small;">Rev. 00      0.10.2010</p>
            </i>
        </td>
        <td>
            <i>
                <p style="font-size: x-small;">0.10.2010</p>
            </i>
        </td>
    </tr>
</table>
<hr>

</body>
</html>
