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
            'body' => 'Testing Kirim Email di Chutex System',
            'url' => 'http://signature.test:8080/home'
        ];

        Mail::send(array('html' => 'email.sendemailhtml'), array('data' => $data), function ($message) {
            $message->to('kiritoooookun@gmail.com')->subject('Chutex E-Signature');
        });

        // Mail::to('kiritoooookun@gmail.com')->send(new SendEmail($data));
        // return view('email.sendemailhtml', compact('data'));
    }
}
