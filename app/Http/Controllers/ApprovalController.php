<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Approval;
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
use Yajra\DataTables\Facades\DataTables;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->void) {
            $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "' . $request->void . '"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');
        } else {
            $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "false"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');
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
        $user_id = Auth::user()->id;
        $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "false"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');

        if ($approval[0]->status == 'approved') {
            Alert::error('Alert!', 'Document "' . $approval[0]->document_name . '" has been approved!');
            return redirect('/approval/index');
        } else if ($approval[0]->approval_level < $approval[0]->approval_progress) {
            Alert::error('Alert!', 'You have been approve document "' . $approval[0]->document_name . '".');
            return redirect('/approval/index');
        } else {
            return view('approval.approve', compact('user', 'approval'));
        }
    }

    public function approved(Request $request)
    {
        $data = $request->all();
        $approval = Approval::findOrFail($request->id);
        $totalData = Approval::select('approval.*', 'users.name', 'users.email')->leftJoin('users', 'approval.preparer_id', '=', 'users.id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->get();
        // dd($totalData[0]->email);
        // Stamp scale is 1.7, change to 1.
        $stampX = ($data['stampX'] / 1.7);
        $stampY = ($data['stampY'] / 1.7);
        $stampHeight = ($data['stampHeight'] / 4.2);
        $stampWidth = ($data['stampWidth'] / 3.2);
        $canvasHeight = ($data['canvasHeight'] / 1.7);
        $canvasWidth = ($data['canvasWidth'] / 1.7);
        $pageNumber = $data['pageNumber'];
        $qrPath = Storage::disk('signature_uploads')->path($request->signature_img);
        // dd($qrPath);
        try {
            $fileContent = Storage::disk('pdf_uploads')->get($request->original_name);
            $pageCount = PDF::setSourceFile(StreamReader::createByString($fileContent));
        } catch (Exception $e) {
            Alert::error("PDF may be in compression process, please replace PDF with uncompressed one.");
            return redirect('approval/index');
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
        $new_filename = substr($request->original_name, 0, -4) . "_approved_" . $approval->approval_level . '.pdf';
        PDF::Output(storage_path('app/public/document/') . $new_filename, 'F');
        $new_base64 = "data:application/pdf;base64," . base64_encode(Storage::disk('pdf_uploads')->get($new_filename));

        $approval->fill([
            'document_approve' => $new_filename,
            'approval_base64' => $new_base64,
            'approval_date' => Carbon::now()
        ]);
        $approval->save();

        Approval::where('preparer_id', '=', $request->preparer_id)->where('approval_level', '>', $approval->approval_level)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'original_name' => $new_filename,
            'base64' => $new_base64,
        ]);

        if ($approval->approval_level < count($totalData)) {
            Approval::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress + 1,
            ]);
        } else {
            $approvalProgress = $request->approval_progress;
            Approval::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
                'approval_progress' => $request->approval_progress,
                'document_approve' => $new_filename,
                'approval_base64' => $new_base64,
                'status' => 'approved',
            ]);
        }

        $sendTo = Approval::select('users.email', 'approval.id')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->where('approval.approval_level', '=', $request->approval_progress + 1)->get();
        // dd($sendTo);
        $finishTo = Approval::select('users.email', 'approval.id')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->where('approval.approval_level', '=', 1)->get();

        if (count($sendTo) > 0) {
            $email = [
                'name' => 'Chutex E-Signature',
                'body' => 'Please check and give an approval on your pending document "' . $approval->document_name . '" from "' . $totalData[0]->name . '". You can give document approval by opening the link below.',
                'url' => URL::to("/approval/approve/" . $sendTo[0]->id)
            ];
            Mail::to($sendTo[0]->email)->send(new SendEmail($email));
        } else {
            $email = [
                'name' => 'Chutex E-Signature',
                'body' => 'Your document "' . $approval->document_name . '" has been approved!',
                'url' => URL::to("/approval/index")
            ];
            Mail::to($finishTo[0]->email)->send(new SendEmail($email));
        }

        Alert::success('Approval Successfully!', 'Document "' . $approval->document_name . '" successfully approved!');

        // return PDF::Output('Signature.pdf', 'I');
        return redirect('approval/index');
    }

    public function stamp($id)
    {
        $user = User::select('users.*', 'signatures.signature_img')
            ->leftJoin('signatures', 'users.id', '=', 'signatures.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->get();
        $approval = Approval::select('*')->where('id', '=', $id)->get();
        $user_id = Auth::user()->id;
        $approvals = DB::select('with data1 as (select approval.*,users.name,(select users.name from approval t2 left join users on t2.approval_id = users.id where t2.preparer_id = approval.preparer_id and t2.approval_level = approval.approval_progress and t2.document_name = approval.document_name and t2.token = approval.token) as need_approve, case when preparer_id = lag(preparer_id) over (order by id) and document_name = lag(document_name) over (order by id) and token = lag(token) over (order by id) then 0 else 1 end as the_same from approval left join users on users.id = preparer_id where void = "false"),data2 as (select *, sum(the_same) over (order by id) group_num FROM data1), data3 as (select *,first_value(original_name) over (partition by group_num order by id) value_first,first_value(document_approve) over (partition by group_num order by id) value_last from data2 where approval_id = ' . $user_id . ') select * from data3 where approval_id = ' . $user_id . ' order by id desc');

        if ($approval[0]->status == 'approved') {
            return view('approval.stamp', compact('user', 'approval'));
            return redirect('/approval/index');
        } else {
            Alert::error('Alert!', 'Document "' . $approval[0]->document_name . '" need approval!');
            return redirect('/approval/index');
        }
    }

    public function stamping(Request $request)
    {
        $data = $request->all();
        $approval = Approval::findOrFail($request->id);
        $totalData = Approval::select('approval.*', 'users.name', 'users.email')->leftJoin('users', 'approval.preparer_id', '=', 'users.id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->get();
        // dd($totalData[0]->email);
        // Stamp scale is 1.7, change to 1.
        $stampX = ($data['stampX'] / 1.83);
        $stampY = ($data['stampY'] / 1.70);
        $stampHeight = ($data['stampHeight'] / 8.2);
        $stampWidth = ($data['stampWidth'] / 3.2);
        $canvasHeight = ($data['canvasHeight'] / 1.7);
        $canvasWidth = ($data['canvasWidth'] / 1.7);
        $pageNumber = $data['pageNumber'];
        $qrPath = Storage::disk('signature_uploads')->path($request->stamp_img);
        // dd($qrPath);
        try {
            $fileContent = Storage::disk('pdf_uploads')->get($request->original_name);
            $pageCount = PDF::setSourceFile(StreamReader::createByString($fileContent));
        } catch (Exception $e) {
            Alert::error("PDF may be in compression process, please replace PDF with uncompressed one.");
            return redirect('approval/index');
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
        $new_filename = substr($request->document_approve, 0, -4) . '_stamping.pdf';
        // return PDF::Output('Signature.pdf', 'I');
        PDF::Output(storage_path('app/public/document/') . $new_filename, 'F');
        $new_base64 = "data:application/pdf;base64," . base64_encode(Storage::disk('pdf_uploads')->get($new_filename));

        Approval::where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'document_stamp' => $new_filename,
            'stamp_base64' => $new_base64,
            'stamp' => 'true',
        ]);

        $sendTo = Approval::select('users.email', 'approval.id')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->where('approval.approval_level', '=', $request->approval_progress + 1)->get();
        // dd($sendTo);
        $finishTo = Approval::select('users.email', 'approval.id')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.preparer_id', '=', $request->preparer_id)->where('approval.document_name', '=', $request->document_name)->where('approval.token', '=', $request->token)->where('approval.approval_level', '=', 1)->get();

        // if (count($sendTo) > 0) {
        //     $email = [
        //         'name' => 'Chutex E-Signature',
        //         'body' => 'Please check and give an approval on your pending document "' . $approval->document_name . '" from "' . $totalData[0]->name . '". You can give document approval by opening the link below.',
        //         'url' => URL::to("/approval/approve/" . $sendTo[0]->id)
        //     ];
        //     Mail::to($sendTo[0]->email)->send(new SendEmail($email));
        // } else {
        //     $email = [
        //         'name' => 'Chutex E-Signature',
        //         'body' => 'Your document "' . $approval->document_name . '" has been approved!',
        //         'url' => URL::to("/approval/index")
        //     ];
        //     Mail::to($finishTo[0]->email)->send(new SendEmail($email));
        // }

        Alert::success('Stamping Successfully!', 'Document "' . $approval->document_name . '" successfully stamped!');

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
        $random = Str::random();


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
            $item->token = $random;
            $item->save();
            $level++;
        }

        Storage::put('public/document/', $file);
        // $file->storeAs('', $fileName, 'pdf_uploads');

        Alert::success('Upload Successfully!', 'Document "' . $request->document_name . '" successfully uploaded!');
        return redirect()->intended('approval/index');
    }

    public function fetchapproval($id)
    {
        $fetchapproval = Approval::select('approval.*', 'users.name')->leftJoin('users', 'users.id', '=', 'approval.approval_id')->where('approval.id', '=', $id)->get();
        // dd($fetchapproval);
        return response()->json($fetchapproval);
    }

    public function fetchattachment($token)
    {
        $fetchattachment = DB::select('select attachment.* from attachment left join approval on attachment.token = approval.token where attachment.token = "' . $token . '" and attachment.void = "false"');
        // return response()->json($fetchattachment);
        return DataTables::of($fetchattachment)
            ->addIndexColumn()
            ->addColumn('viewbadge', function ($row) {
                $storageurl = asset('/storage/attachment/' . $row->original_name);
                $statusBadge = '<center><a href="' . $storageurl . '" class="btn btn-primary btn-circle btn-sm" target="_blank"><i class="fas fa-eye"></i></a></center>';
                return $statusBadge;
            })
            ->rawColumns(['viewbadge'])
            ->make(true);
    }

    public function revision(Request $request)
    {
        // dd($request->comment);
        Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'status' => 'revision',
            'comment' => $request->comment,
        ]);

        Alert::success('Comment to Revision Successfully!', 'Approval "' . $request->document_name . '" successfully commented!');
        return redirect('approval/index');
    }

    public function void(Request $request)
    {
        $approval = Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'true',
        ]);

        Alert::success('Void Successfully!', 'Approval "' . $request->document_name . '" successfully voided!');
        return redirect('approval/index');
    }

    public function restore(Request $request)
    {
        $approval = Approval::select('*')->where('preparer_id', '=', $request->preparer_id)->where('document_name', '=', $request->document_name)->where('token', '=', $request->token)->update([
            'void' => 'false',
        ]);

        Alert::success('Restore Successfully!', 'Approval "' . $request->document_name . '" successfully restored!');
        return redirect('approval/index');
    }
}
