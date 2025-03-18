<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class ConverterController extends Controller
{
    public function index()
    {
        return view('converter.index');
    }

    public function converter(Request $request)
    {
        $file = $request->file;
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file);
        $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
        $pdf_file = $file->getClientOriginalName();
        $writer->save($pdf_file . '.pdf');
        return response()->download($pdf_file . '.pdf');
    }
}
