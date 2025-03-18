<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Approval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use setasign\Fpdi\PdfParser\StreamReader;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "' . $request->void . '"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id');
        } else {
            $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "false"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id');
        }
        // dd($approvals);
        return view('approval.index', compact('approvals'));
    }

    public function create()
    {
        $users = User::all();
        return view('approval.create', compact('users'));
    }

    public function approve($id)
    {
        $user = User::select('users.*', 'signatures.signature_img')
            ->leftJoin('signatures', 'users.id', '=', 'signatures.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->get();
        $approval = Approval::select('*')->where('id', '=', $id)->get();
        return view('approval.approve', compact('user', 'approval'));
    }

    public function approved(Request $request)
    {
        $data = $request->all();
        $approval = Approval::findOrFail($request->id);
        $totalData = Approval::select('approval.*', 'users.name', 'users.email')->leftJoin('users', 'approval.preparer_id', '=', 'users.id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.created_at', '=', $request->created_at)->get();
        // dd($totalData[0]->email);
        // Stamp scale is 1.7, change to 1.
        $stampX = ($data['stampX'] / 1.7);
        $stampY = ($data['stampY'] / 1.7);
        $stampHeight = ($data['stampHeight'] / 4.7);
        $stampWidth = ($data['stampWidth'] / 4.7);
        $canvasHeight = ($data['canvasHeight'] / 1.7);
        $canvasWidth = ($data['canvasWidth'] / 1.7);
        $pageNumber = $data['pageNumber'];
        $qrPath = Storage::disk('signature_uploads')->path($request->signature_img);
        // dd($qrPath);

        // Get stream of uploaded file
        $fileContent = Storage::disk('pdf_uploads')->get($request->original_name);;
        // dd($fileContent);
        $pageCount = PDF::setSourceFile(StreamReader::createByString($fileContent));

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
        $new_filename = substr($request->original_name, 0, -4) . "_approved_" . $approval->approval_level . '.pdf';
        PDF::Output(storage_path('app/public/document/') . $new_filename, 'F');
        $new_base64 = "data:application/pdf;base64," . base64_encode(Storage::disk('pdf_uploads')->get($new_filename));

        $approval->fill([
            'document_approve' => $new_filename,
            'approval_base64' => $new_base64,
            'approval_date' => Carbon::now()
        ]);
        $approval->save();

        Approval::where('preparer_id', '=', $request->preparer_id)->where('approval_level', '>', $approval->approval_level)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
            'original_name' => $new_filename,
            'base64' => $new_base64,
        ]);

        if ($approval->approval_level < count($totalData)) {
            Approval::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
                'approval_progress' => $request->approval_progress + 1,
            ]);
        } else {
            $approvalProgress = $request->approval_progress;
            Approval::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
                'approval_progress' => $request->approval_progress,
                'document_approve' => $new_filename,
                'approval_base64' => $new_base64,
                'status' => 'approved',
            ]);
        }

        $sendTo = Approval::select('users.email')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.created_at', '=', $request->created_at)->where('approval.approval_level', '=', $request->approval_progress + 1)->get();

        $email = [
            'name' => 'Chutex E-Signature Notification',
            'body' => 'Please check and give an approval on your pending document "' . $approval->document_name . '" from "' . $totalData[0]->name . '"'
        ];

        if (count($sendTo) > 0) {
            Mail::to($sendTo[0]->email)->send(new SendEmail($email));
        }
        Alert::success('Approval Successfully!', 'Document ' . $approval->document_name . ' successfully approved!');

        // return PDF::Output('Signature.pdf', 'I');
        return redirect('approval/index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:docx,pdf|max:10240'
        ]);

        $file = $request->file('file');
        $fileName = $file->hashName();

        $level = 1;
        foreach ($request->approval_id as $key => $value) {
            $item = new Approval();
            $item->preparer_id = $request->preparer_id;
            $item->document_name = $request->document_name;
            $item->original_name = $fileName;
            $item->base64 = $request->base64;
            $item->approval_id = $request->approval_id[$key];
            $item->approval_level = $level;
            $item->approval_progress = '1';
            $item->status = 'pending';
            $item->void = 'false';
            $item->save();
            $level++;
        }

        Storage::put('public/document/', $file);
        // $file->storeAs('', $fileName, 'pdf_uploads');

        Alert::success('Upload Successfully!', 'Document ' . $request->document_name . ' successfully uploaded!');
        return redirect()->intended('approval/index');
    }

    public function fetchapproval($id)
    {
        $fetchapproval = Approval::select('approval.*', 'users.name')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.id', '=', $id)->get();
        // dd($fetchapproval);
        return response()->json($fetchapproval);
    }

    public function revision(Request $request)
    {
        // dd($request->comment);
        Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
            'status' => 'revision',
            'comment' => $request->comment,
        ]);

        Alert::success('Comment to Revision Successfully!', 'Approval ' . $request->document_name . ' successfully commented!');
        return redirect('approval/index');
    }

    public function void(Request $request)
    {
        $approval = Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
            'void' => 'true',
        ]);

        Alert::success('Void Successfully!', 'Approval ' . $request->document_name . ' successfully voided!');
        return redirect('approval/index');
    }

    public function restore(Request $request)
    {
        $approval = Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('created_at', '=', $request->created_at)->update([
            'void' => 'false',
        ]);

        Alert::success('Restore Successfully!', 'Approval ' . $request->document_name . ' successfully restored!');
        return redirect('approval/index');
    }
}
