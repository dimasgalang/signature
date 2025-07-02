<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FORMULIR PERMINTAAN AKSES IT</title>
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
    table #leaver-table {
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
    .note {
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <table id="leaver-table">
      <tr>
          <td class="header">
              <center>
                <img src="{{ public_path('img/chutex_logo.png') }}" style="width: 70px;">
              </center>
          </td>
          <td class="header">
              <center>
                  <h3>FORMULIR PERMINTAAN AKSES IT</h3>
                  <h3><i>IT Access Request Form</i></h3>
              </center>
          </td>
          <td class="header" style="text-align: center; vertical-align: middle;">
                  <p style="font-size:7px; x-small; margin:0; text-align: left;">Doc#</p>
                  <p style="font-size:7px; x-small; margin:0; text-align: left;">Revision: 00</p>
                  <p style="font-size:7px; x-small; margin:0; text-align: left;">Date: 13/5/2025</p>
          </td>
      </tr>
  </table>
  <hr>
  <table id="leaver-table" style="border: none">
    <tr>
        <td class="header">
          <div><span class="form-label">Tanggal/Date :</span> </div>
          <div><span class="form-label">Nama/Name : </span> </div>
        </td>
        <td class="header">
            <center>
              <div><span class="form-label"></div>
              <div><span class="form-label">ID Karyawan/ Employee ID </span> </div>
            </center>
        </td>
        <td class="header">
            <center>
              <div><span class="form-label"></div>
              <div><span class="form-label">Dept/Dept : </span> </div>
            </center>
        </td>
    </tr>
</table>

  
<hr>

</body>
</html>
