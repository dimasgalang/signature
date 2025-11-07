<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Perawatan IT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            /* padding: 10px; */
            background: white;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
        }

        .header {
            text-align: center;
            border: 2px solid #000;
            padding: 3px;
            margin-bottom: 2px;
        }

        .header h1 {
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
            font-size: 8px;
        }

        .info-table td {
            border: 1px solid #000;
            padding: 4px 8px;
        }

        .info-label {
            width: 150px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: start;
        }

        th {
            background: #e0e0e0;
            font-weight: bold;
            font-size: 8px;
        }

        .category-header {
            background: #d0d0d0;
            font-weight: bold;
            text-align: left;
            padding: 4px 8px;
            font-size: 8px;
        }

        .item-name {
            text-align: left;
            padding-left: 12px;
            font-size: 8px;
        }

        .no-col {
            width: 30px;
        }

        .item-col {
            text-align: center;
            width: 150px;
        }

        .month-col {
            width: auto;
            font-size: 8px;
        }

        .checked {
            font-size: 10px;
            font-weight: bold;
        }

        .notes-section {
            margin-top: 8px;
            padding: 8px;
            border: 1px solid #000;
            font-size: 10px;
        }

        .notes-section strong {
            display: block;
            margin-bottom: 4px;
        }

        .signature-section {
            /* margin-top: 20px; */
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 4px;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }
        }

        @page {
            size: A4;
            margin-top: 0mm;
            margin-bottom: 0mm;
            margin-left: 2mm;
            margin-right: 2mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CEKLIST PERAWATAN IT</h1>
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label">NAMA PERANGKAT</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>PC-24 (PC Follow Up 4)</td>
            </tr>
            <tr>
                <td class="info-label">LOKASI</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>Ruang Follow Up</td>
            </tr>
            <tr>
                <td class="info-label">TAHUN PELAKSANAAN</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>2025</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="no-col">No</th>
                    <th rowspan="2" class="item-col">PARAMETER<br>PENGECEKAN</th>
                    <th colspan="12" style="text-align: center">BULAN</th>
                </tr>
                <tr>
                    <th class="month-col">JANUARI</th>
                    <th class="month-col">FEBRUARI</th>
                    <th class="month-col">MARET</th>
                    <th class="month-col">APRIL</th>
                    <th class="month-col">MEI</th>
                    <th class="month-col">JUNI</th>
                    <th class="month-col">JULI</th>
                    <th class="month-col">AGUSTUS</th>
                    <th class="month-col">SEPTEMBER</th>
                    <th class="month-col">OKTOBER</th>
                    <th class="month-col">NOVEMBER</th>
                    <th class="month-col">DESEMBER</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="14" class="category-header">HARDWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BODY PC</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">KIPAS</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">MOTHERBOARD</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="item-name">RAM</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="item-name">HARDDISK</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="item-name">KABEL</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td class="item-name">MONITOR</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td class="item-name">MOUSE</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td class="item-name">KEYBOARD</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="14" class="category-header">SOFTWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">APLIKASI</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">ANTI VIRUS</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">LISENSI</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="14" class="category-header">KONDISI</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BAIK</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">PERBAIKAN/SERVIS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        {{-- <div class="flex notes-section justify-content-between">
            <div>
                <strong>KETERANGAN</strong>
                Beri tanda ☑ jika dikerjakan<br>
                Beri tanda ☑ jika terjadi kerusakan
            </div>
            <div class="signature-section">
                <div class="signature-box">
                    <div>Penanggung Jawab</div>
                    <div class="signature-line">
                        Siqin Pinjaya
                    </div>
                </div>
            </div>
        </div> --}}
        
        <div class="justify-content-between" style="display:flex; justify-content:space-between; align-items:flex-start; margin-top:8px; padding:8px; border:1px solid #000; font-size:10px;">
            <div>
                <strong>KETERANGAN</strong>
                <div>
                    Beri tanda ☑ jika dikerjakan<br>
                    Beri tanda ☑ jika terjadi kerusakan
                </div>
            </div>
            <div class="signature-section">
                <div class="signature-box">
                    <div>Penanggung Jawab</div>
                    <div class="signature-line">
                        Siqin Pinjaya
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="container">
        <div class="header">
            <h1>CEKLIST PERAWATAN IT</h1>
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label">NAMA PERANGKAT</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>PC-24 (PC Follow Up 4)</td>
            </tr>
            <tr>
                <td class="info-label">LOKASI</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>Ruang Follow Up</td>
            </tr>
            <tr>
                <td class="info-label">TAHUN PELAKSANAAN</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>2025</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="no-col">No</th>
                    <th rowspan="2" class="item-col">PARAMETER<br>PENGECEKAN</th>
                    <th colspan="12" style="text-align: center">BULAN</th>
                </tr>
                <tr>
                    <th class="month-col">JANUARI</th>
                    <th class="month-col">FEBRUARI</th>
                    <th class="month-col">MARET</th>
                    <th class="month-col">APRIL</th>
                    <th class="month-col">MEI</th>
                    <th class="month-col">JUNI</th>
                    <th class="month-col">JULI</th>
                    <th class="month-col">AGUSTUS</th>
                    <th class="month-col">SEPTEMBER</th>
                    <th class="month-col">OKTOBER</th>
                    <th class="month-col">NOVEMBER</th>
                    <th class="month-col">DESEMBER</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="14" class="category-header">HARDWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BODY PC</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">KIPAS</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">MOTHERBOARD</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="item-name">RAM</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="item-name">HARDDISK</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="item-name">KABEL</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td class="item-name">MONITOR</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td class="item-name">MOUSE</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td class="item-name">KEYBOARD</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="14" class="category-header">SOFTWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">APLIKASI</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">ANTI VIRUS</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">LISENSI</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="14" class="category-header">KONDISI</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BAIK</td>
                    <td><span class="checked">✓</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">PERBAIKAN/SERVIS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        {{-- <div class="flex notes-section justify-content-between">
            <div>
                <strong>KETERANGAN</strong>
                Beri tanda ☑ jika dikerjakan<br>
                Beri tanda ☑ jika terjadi kerusakan
            </div>
            <div class="signature-section">
                <div class="signature-box">
                    <div>Penanggung Jawab</div>
                    <div class="signature-line">
                        Siqin Pinjaya
                    </div>
                </div>
            </div>
        </div> --}}
        
        <div class="justify-content-between" style="display:flex; justify-content:space-between; align-items:flex-start; padding:8px; border:1px solid #000; font-size:10px;">
            <div>
                <strong>KETERANGAN</strong>
                <div>
                    Beri tanda ☑ jika dikerjakan<br>
                    Beri tanda ☑ jika terjadi kerusakan
                </div>
            </div>
            <div class="signature-section">
                <div class="signature-box">
                    <div>Penanggung Jawab</div>
                    <div class="signature-line">
                        Siqin Pinjaya
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>