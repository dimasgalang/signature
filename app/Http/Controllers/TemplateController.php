<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function lpp()
    {
        return view('template.lpp');
    }

    public function handover()
    {
        return view('template.handover');
    }

    public function it_access()
    {
        return view('template.it-access');
    }
}
