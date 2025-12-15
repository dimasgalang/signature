
@php
    $a = 1;
@endphp
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
            margin-top: 4mm;
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
            /* display: flex;
            justify-content: space-between; */
            align-items: flex-end;
            text-align: right;
            font-size: 10px;
        }

        .signature-box {
            text-align: right;
            align-items: flex-end;
            width: 100px;
        }

        .signature-line {
            text-align: center;
            border-top: 1px solid #000;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }
        }

        @page {
            size: Legal;
            margin-top: 100mm;
            margin-bottom: 0mm;
            margin-left: 2mm;
            margin-right: 2mm;
        }
    </style>
</head>
<body>
    @php
        $i = 0;
    @endphp
        @foreach ($computerList as $computer)
    @php
        $i++;
    @endphp

    <div class="container">
        <div class="header">
            <h1>CEKLIST PERAWATAN IT</h1>
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label">NAMA PERANGKAT</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>{{ $computer->device_name }} {{ $computer->user }}</td>
            </tr>
            <tr>
                <td class="info-label">LOKASI</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>{{ $computer->location }}</td>
            </tr>
            <tr>
                <td class="info-label">TAHUN PELAKSANAAN</td>
                {{-- <td style="white-space: nowrap">:</td> --}}
                <td>{{ date('Y', strtotime($computer->date_of_inspection)) }}</td>
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
                    @for($month = $a; $month <= 12; $month++)
                        <th class="month-col">{{ strtoupper(date('F', mktime(0, 0, 0, $month, 1))) }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="14" class="category-header">HARDWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BODY PC</td>
                    <!-- Looping 89x -->
                    @foreach($bodyPCAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">KIPAS</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($kipasAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">MOTHERBOARD</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($motherboardAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>4</td>
                    <td class="item-name">RAM</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($ramAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>5</td>
                    <td class="item-name">HARDDISK</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($storageAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>6</td>
                    <td class="item-name">KABEL</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($cabelAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>7</td>
                    <td class="item-name">MONITOR</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($monitorAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>8</td>
                    <td class="item-name">MOUSE</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($mouseAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>9</td>
                    <td class="item-name">KEYBOARD</td>
                    <!-- <td><span class="checked">V</span></td>
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
                    <td></td> -->
                    <!-- Looping 89x -->
                    @foreach($keyboardAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>

                <tr>
                    <td colspan="14" class="category-header">SOFTWARE</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">APLIKASI</td>
                    <!-- Looping 89x -->
                    @foreach($applicationAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">ANTI VIRUS</td>
                    <!-- Looping 89x -->
                    @foreach($antivirusAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>3</td>
                    <td class="item-name">LISENSI</td>
                    <!-- Looping 89x -->
                    @foreach($licenseAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>

                <tr>
                    <td colspan="14" class="category-header">KONDISI</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td class="item-name">BAIK</td>
                    <!-- Looping 89x -->
                    @foreach($conditionAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'true' ? 'V' : 'X'}}</span></td>
                                    
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <= 12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>2</td>
                    <td class="item-name">PERBAIKAN/SERVIS</td>
                    <!-- Looping 89x -->
                    @foreach($conditionAnswersGrouped as $key => $array)
                        @if($computer->device_name == $key)
                            @php
                                $cekmonth = 1;
                            @endphp
                        <!-- Looping 2x -->
                            @foreach($array as $answer)
                                @if(intval($answer->month) == $cekmonth)
                                    <td><span class="checked">{{$answer->answer == 'false' ? 'V' : 'X'}}</span></td>
                                @elseif($cekmonth < intval($answer->month))
                                    @for($cekmonth = $cekmonth; $cekmonth < intval($answer->month); $cekmonth++)
                                        <td></td>
                                    @endfor
                                    <td><span class="checked">{{$answer->answer == 'false' ? 'V' : 'X'}}</span></td>
                                @endif
                                @php
                                    $cekmonth = intval($answer->month) + 1;
                                @endphp
                            @endforeach
                            @for($isibelakang = $cekmonth; $isibelakang <=12; $isibelakang++)
                                <td></td>
                            @endfor
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>
        
        <table style="width:100%; margin-top:8px; border:1px solid #000; font-size:10px; border-collapse:collapse;">
            <tr>
                <td style="vertical-align:top; width:65%; border:none; padding:0;">
                    <div style="padding: 4px">
                        <strong style="display:block; margin-bottom:8px;">KETERANGAN</strong>
                        @php $iteration = 1; @endphp
                        @foreach($conditionAnswersGrouped as $key => $array)
                            @if($computer->device_name == $key)
                                @foreach($array as $answer)
                                    @if($answer->notes != null)
                                        <div style="margin-bottom:5px;">
                                            {{$iteration++}}. {{ ucfirst(date('F', mktime(0, 0, 0, intval($answer->month), 1))) . ' ' . $answer->year  }} : {{ $answer->notes }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </td>
                <td style="border: none; width:10%;">

                </td>
                <td style="vertical-align:top; width:25%; text-align:center; border:none; padding:0;">
                    <div style="padding: 4px">
                        <strong style="display:block; margin-bottom:8px;">Penanggung Jawab</strong>
                        @php
                            $imagePathSign2 = public_path('storage/signature/'. $inspectionPerson->signature_img);
                            $imageSign2 = "data:image/png;base64," . base64_encode(file_get_contents($imagePathSign2));
                        @endphp
                            <img src="{{$imageSign2}}" alt="Requesting Person Signature" style="max-height:70px;">
                            <div class="signature-line" style="font-size:12px; text-align:center;">
                                &nbsp;{{ $inspectionPerson->name }}
                            </div>
                    </div>
                </td>
            </tr>
        </table>
        <div style="font-size:10px; margin-top:4px;">
            Beri tanda ☑ jika dikerjakan<br>
            Beri tanda ☑ jika terjadi kerusakan
        </div>
    </div>
    <br>
    @php
        if( $i % 2 == 0 ){ 
    @endphp
        <div class='page-break'></div>
    @php
        }
    @endphp
    @endforeach
</body>
</html>