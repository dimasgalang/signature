<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->void) {
            $attachments = DB::select('select distinct attachment.id,attachment.token,attachment.document_name,attachment.original_name,attachment.created_at,attachment.updated_at,approval.document_name as approval_document from attachment left join approval on attachment.token = approval.token where attachment.void = "' . $request->void . '"');
        } else {
            $attachments = DB::select('select distinct attachment.id,attachment.token,attachment.document_name,attachment.original_name,attachment.created_at,attachment.updated_at,approval.document_name as approval_document from attachment left join approval on attachment.token = approval.token where attachment.void = "false"');
        }

        return view('attachment.index', compact('attachments'));
    }

    public function create()
    {
        $approvals = DB::select('select DISTINCT document_name,token from approval where void = "false"');
        return view('attachment.create', compact('approvals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240'
        ]);

        $file = $request->file('file');
        $fileName = $file->hashName();

        Attachment::create([
            'token' => $request->token,
            'document_name' => $request->document_name,
            'original_name' => $fileName,
            'void' => 'false',
        ]);

        Storage::put('public/attachment/', $file);

        Alert::success('Upload Successfully!', 'Attachment "' . $request->document_name . '" successfully uploaded!');
        return redirect()->intended('attachment/index');
    }


    public function fetchattachment($id)
    {
        $fetchattachment = DB::select('select attachment.* from attachment left join approval on attachment.token = approval.token where attachment.id = "' . $id . '"');
        return response()->json($fetchattachment);
    }

    public function void(Request $request)
    {
        $attachments = Attachment::select('*')->where('id', '=', $request->id)->update([
            'void' => 'true',
        ]);

        Alert::success('Void Successfully!', 'Attachment "' . $request->document_name . '" successfully voided!');
        return redirect('attachment/index');
    }

    public function restore(Request $request)
    {
        $attachments = Attachment::select('*')->where('id', '=', $request->id)->update([
            'void' => 'false',
        ]);

        Alert::success('Restore Successfully!', 'Attachment "' . $request->document_name . '" successfully restored!');
        return redirect('attachment/index');
    }
}
