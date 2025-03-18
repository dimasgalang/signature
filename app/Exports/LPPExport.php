<?php

namespace App\Exports;

use App\Models\LPP;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LPPExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return LPP::all();
    }

    public function view(): View
    {
        return view('template.lpp');
    }
}
