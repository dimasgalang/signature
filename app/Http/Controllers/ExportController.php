<?php

namespace App\Http\Controllers;

use App\Exports\LPPExport;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function lpp()
    {
        return Excel::download(new LPPExport, 'lpp.xlsx');
    }

    public function lpp_pdf()
    {
        $pdf = PDF::loadView('template.lpp');
        Storage::put('public/document/test.pdf', $pdf->output());
        // return $pdf->download('lpp.pdf');
    }
}
