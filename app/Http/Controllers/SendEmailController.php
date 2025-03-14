<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function send()
    {
        $data = [
            'name' => 'Chutex E-Signature Notification',
            'body' => 'Testing Kirim Email di Chutex System'
        ];

        Mail::to('sigitpriyoga@chutex.id')->send(new SendEmail($data));
    }
}
