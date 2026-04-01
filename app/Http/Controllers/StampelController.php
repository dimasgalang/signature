<?php

namespace App\Http\Controllers;

use App\Models\Stampel;
use App\Mail\SendEmail;
use App\Models\SysLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use setasign\Fpdi\PdfParser\StreamReader;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\Facades\DataTables;

class StampelController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $stampels = DB::select("select stampel.id, preparer_id, users.name, document_name, document_stamp, original_name from stampel left join users on users.id = preparer_id");
        } else {
            $stampels = DB::select("select stampel.id, preparer_id, users.name, document_name, document_stamp, original_name from stampel left join users on users.id = preparer_id");
        }
        return view('stampel.index', compact('stampels'));
    }

    public function create()
    {
        $users = User::all();
        return view('stampel.create', compact('users'));
    }

    public function store(Request $request)
    {
        if ($request->file) {
            $request->validate([
                'file' => 'required|mimes:docx,pdf|max:10240'
            ]);
            $file = $request->file('file');
            $fileName = $file->hashName();
        }
        // dd($request->all());

        $random = Str::random();

        $item = new Stampel();
        $item->preparer_id = $request->preparer_id;
        $item->document_name = $request->document_name;
        $item->original_name = $fileName ?? $request->original_name;
        $item->base64 = $request->base64;
        $item->document_stamp = '';
        $item->stamp_base64 = '';
        $item->void = 'false';
        $item->token = $random;
        $item->save();

        if ($request->file) {
            Storage::put('public/document/', $file);
        } else {
            Storage::put('public/document/' . $request->original_name, base64_decode(str_replace('data:application/pdf;base64,', '', $request->base64)));
        }
        $file->storeAs('', $fileName, 'pdf_uploads');

        Alert::success('Upload Successfully!', 'Document "' . $request->document_name . '" successfully uploaded!');
        return redirect()->intended('stampel/index');
    }

    public function stamp($id)
    {
        $stampel = Stampel::select('*')->where('id', '=', $id)->get();
        return view('stampel.stamp', compact('stampel'));
    }

    public function stamping(Request $request)
    {
        $data = $request->all();
        $stampel = Stampel::findOrFail($request->id);

        $stampX = ($data['stampX'] / 1);
        $stampY = ($data['stampY'] / 1);
        $stampHeight = ($data['stampHeight'] / 1.8);
        $stampWidth = ($data['stampWidth'] / 1.8);
        $canvasHeight = ($data['canvasHeight'] / 0.995);
        $canvasWidth = ($data['canvasWidth'] / 0.995);

        $pageNumber = $data['pageNumber'];
        $qrPath = Storage::disk('signature_uploads')->path($request->stamp_img);
        // dd($qrPath);

        try {
            $fileContent = Storage::disk('pdf_uploads')->get($request->original_name);
            $pageCount = Pdf::setSourceFile(StreamReader::createByString($fileContent));
        } catch (Exception $e) {
            Alert::error("PDF may be in compression process, please replace PDF with uncompressed one.");
            return redirect('stampel/index');
        }

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
        $new_filename = substr($request->original_name, 0, -4) . '_stamping.pdf';
        // return PDF::Output('Signature.pdf', 'I');
        PDF::Output(storage_path('app/public/document/') . $new_filename, 'F');
        $new_base64 = "data:application/pdf;base64," . base64_encode(Storage::disk('pdf_uploads')->get($new_filename));

        Stampel::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'document_stamp' => $new_filename,
            'stamp_base64' => $new_base64,
        ]);

        Alert::success('Stamping Successfully!', 'Document "' . $stampel->document_name . '" successfully stamped!');

        // return PDF::Output('Signature.pdf', 'I');
        return redirect('stampel/index');
    }
}
