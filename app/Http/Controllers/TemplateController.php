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
    public function commitment()
    {
        return view('template.commitment_comp_user');
    }

    public function cyber_user_account()
    {
        return view('template.cyber-user-account');
    }

    public function surveillance_system_maintenance()
    {
        return view('template.cctv-maintenance');
    }
}
