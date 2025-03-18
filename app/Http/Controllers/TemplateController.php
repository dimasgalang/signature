<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function lpp()
    {
        return view('template.lpp');
    }
}
