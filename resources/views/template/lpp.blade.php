<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Persetujuan Pembayaran</title>
    <style>
        table {
            width: 100%;
            /* border-collapse: collapse; */
            /* margin: 20px 0; */
        }
        th, td {
            /* border: 1px solid #000; */
            /* padding: 2px; */
            text-align: left;
        }
    </style>
</head>
<body>
<hr>
<table>
    <tr>
        <td>
            <center>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('/storage/images/chutex_logo.png'))) }}" style="width: 70px;">
            </center>
        </td>
        <td>
            <center>
                <h3>LEMBAR PERSETUJUAN PEMBAYARAN</h3>
            </center>
        </td>
        <td>
                <p style="font-size: x-small;"><b>No. </b>B25A000106</p>
                <p style="font-size: x-small;"><b>Tgl. </b>{{ now() }}</p>
        </td>
    </tr>
</table>
<hr>

<table>
    <tr>
        <th width="35%">Dibayarkan kepada</th>
        <td>KARYAWAN</td>
    </tr>
    <tr>
        <td></td>
        <td>KAR0063</td>
    </tr>
    <tr>
        <th>Uang sejumlah</th>
        <td>IDR 390.683.900,00</td>
    </tr>
    <tr>
        <td></td>
        <td>Tiga Ratus Sembilan Puluh Juta Enam Ratus Delapan Puluh Tiga Ribu Sembilan Ratus Rupiah</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>Untuk pembayaran</th>
        <td>BY GAJI KARYAWAN BULAN MAR'25 VIA BRI SECT-01</td>
    </tr>
    <tr>
        <th>Setuju bayar dengan</th>
        <td></td>
    </tr>
</table>
<hr>
<table>
    <tr>
        <th width="35%">Lampirkan Bukti Pendukung</th>
        <td>RINCIAN GAJI</td>
    </tr>
</table>
<hr>
<table>
    <tr>
        <th>
            <center>
                Disiapkan oleh,
            </center>
        </th>
        <th>
            <center>
                Diperiksa,
            </center>
        </th>
        <th>
            <center>
                Disetujui,
            </center>
        </th>
    </tr>
    
    <tr>
        <th>
            <center>
                <img src="{{ asset('/storage/images/chutex_logo.png') }}" style="width: 70px;">
            </center>
        </th>
        <th>
            <center>
                <img src="{{ asset('/storage/images/chutex_logo.png') }}" style="width: 70px;">
            </center>
        </th>
        <th>
            <center>
                <img src="{{ asset('/storage/images/chutex_logo.png') }}" style="width: 70px;">
            </center>
        </th>
    </tr>
    <tr>
        <th>
            <center>
                (____________________)
            </center>
        </th>
        <th>
            <center>
                (____________________)
            </center>
        </th>
        <th>
            <center>
                (____________________)
            </center>
        </th>
    </tr>
    <tr>
        <th>
            <center>
                Akuntansi
            </center>
        </th>
        <th>
            <center>
                Treasurer
            </center>
        </th>
        <th>
            <center>
                Direksi
            </center>
        </th>
    </tr>
</table>
<hr>
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