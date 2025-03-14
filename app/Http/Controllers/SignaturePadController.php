<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use App\Models\User;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SignaturePadController extends Controller
{
    public function index()
    {
        return view('signature.index');
    }
    public function stamp()
    {
        $user = User::select('users.*', 'signatures.signature_img')
            ->leftJoin('signatures', 'users.id', '=', 'signatures.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->get();

        return view('signature.stamp', compact('user'));
    }

    public function create()
    {
        return view('signature.create');
    }

    public function upload(Request $request)
    {
        $data['image'] = $this->uploadSignature($request->signed);
        $pdf = PDF::loadView('pdf.pdfsignature', $data);
        return $pdf->download('signature.pdf');
    }

    public function stamping(Request $request)
    {
        $user = User::select('users.*', 'signatures.signature_img')
            ->leftJoin('signatures', 'users.id', '=', 'signatures.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->get();

        $data = $request->all();

        // Stamp scale is 1.5, change to 1.
        $stampX = ($data['stampX'] / 1.5);
        $stampY = ($data['stampY'] / 1.5);
        $stampHeight = ($data['stampHeight'] / 2.7);
        $stampWidth = ($data['stampWidth'] / 2.7);
        $canvasHeight = ($data['canvasHeight'] / 1.5);
        $canvasWidth = ($data['canvasWidth'] / 1.5);
        $pageNumber = $data['pageNumber'];
        $qrPath = asset('/signature/' . $user[0]->signature_img);

        // Get stream of uploaded file
        $file = $request->file('pdf-file');
        dd($file);
        $pageCount = PDF::setSourceFile($file);

        // Loop through all pages
        for ($i = 1; $i <= $pageCount; $i++) {
            $template = PDF::importPage($i);
            $size = PDF::getTemplateSize($template);

            PDF::AddPage($size['orientation'], array($size['width'], $size['height']));
            PDF::useTemplate($template);

            $widthDiffPercent = ($canvasWidth - $size['width']) / $canvasWidth * 100;
            $heightDiffPercent = ($canvasHeight - $size['height']) / $canvasHeight * 100;

            $realXPosition = $stampX - ($widthDiffPercent * $stampX / 100);
            $realYPosition = $stampY - ($heightDiffPercent * $stampY / 100);

            // Now we will add QR code to the page number that we want
            if ($i == $pageNumber) {
                PDF::SetAutoPageBreak(false);
                PDF::Image($qrPath, $realXPosition, $realYPosition, $stampWidth, $stampHeight, 'PNG');
            }
        }

        // I: Show to Browser, D: Download, F: Save to File, S: Return as String
        return PDF::Output('Signature.pdf', 'I');
    }

    public function store(Request $request)
    {
        $folderPath = public_path('signature/');
        $image = explode(";base64,", $request->signed);
        $image_type = explode("image/", $image[0]);
        $image_type_png = $image_type[1];
        $image_base64 = base64_decode($image[1]);
        $filename = uniqid() . '.' . $image_type_png;
        $file = $folderPath . $filename;

        Signature::updateOrCreate([
            'user_id' => $request->user_id,
        ], [
            'user_id' => $request->user_id,
            'signature_img' => $filename,
        ]);

        if ($request->signature_img) {
            File::delete(public_path('../../public/signature/' . $request->signature_img));
        }
        Storage::put('public/signature/' . $filename, $image_base64);

        Alert::success('Create Successfully!', 'Signature successfully created!');
        return redirect('user/profile');
    }
}
