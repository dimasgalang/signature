<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function lpp()
    {
        return view('template.lpp');
    }

    public function serah_terima()
    {
        return view('template.serah-terima');
    }
}
