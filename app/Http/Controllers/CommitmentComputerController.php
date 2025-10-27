<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CommitmentComputerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->void) {
            $commitments = Commitment::all()->where('void', $request->void);
        } else {
            $commitments = Commitment::all()->where('void', 'false');
        }
        return view('commitment.index', compact('commitments'));
    }

    public function create()
    {
        $commitment = Commitment::orderBy('id', 'desc')->first();
        $prefix = 'CCU';
        $defaultNumber = 1;
        $todayDate = date('ymd');

        if (isset($commitment) && preg_match('/^CCU(\d{6})(\d{2})$/', $commitment->document_name, $matches)) {
            $lastDate = $matches[1];
            if ($lastDate === $todayDate) {
                $nextNumber = intval($matches[2]) + 1;
            } else {
                $nextNumber = $defaultNumber;
            }
        } else {
            $nextNumber = $defaultNumber;
        }
        $newDocumentName = $prefix . $todayDate . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $commitment = Commitment::all()->last();
        $users = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->get();
        return view('commitment.create', compact('users', 'commitment', 'newDocumentName'));
    }

    public function fetchEmployee($npk)
    {
        $employee = DB::connection('cii')->table('BIODATA')->select('BIODATA.NPK', 'NAMA_KARYAWAN', 'BAG', 'DEPT.DEPARTEMENT', 'PKWT.TMK')->leftJoin('DEPT', 'BIODATA.ID_DEPT', '=', 'DEPT.ID_DEPT')->leftJoin('PKWT', 'BIODATA.NPK', '=', 'PKWT.NPK')->where('BIODATA.NPK', '=', $npk)->get();
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $commitments = Commitment::create([
            'npk' => $request->npk,
            'name' => $request->name,
            'dept' => $request->dept,
            'position' => $request->position,
            'date' => $request->date,
            'joining_date' => $request->joining_date,
            'void' => 'false',
        ]);

        // Generate PDF and save it to storage
        $pdfCommitment = $this->generatePDF($commitments->id, $request->document_name);

        // // Convert the PDF to base64
        $pdfToBase64 = 'data:application/pdf;base64, ' . base64_encode($pdfCommitment->output());

        // // Set the file name and save the PDF to storage
        $originalName = sha1($request->document_name) . '.pdf';

        Storage::put('public/commitment_pdfs/' . $originalName, $pdfCommitment->output());

        // updating handover to saving document name and base64
        $commitments->document_name = $request->document_name;
        $commitments->original_name = $originalName;
        $commitments->base64 = $pdfToBase64;
        $commitments->save();

        Alert::success('Upload Successfully!', 'Document successfully uploaded!');
        return redirect()->intended('commitment/index');
    }

    public function generatePDF(String $id, String $document_name)
    {
        $commitment = Commitment::all()->find($id);
        // dd($handover);

        $pdf = Pdf::loadView('template.commitment', compact(['commitment']));

        return $pdf;
    }

    public function createApproval($id)
    {
        $commitment = Commitment::findOrFail($id);
        $users = User::all();
        return view('commitment.createApprove', compact(['users', 'commitment']));
    }

    public function void(Request $request)
    {
        $commitment = Commitment::find($request->commitment_id);
        $commitment->void = 'true';
        $commitment->save();
        Alert::success('Void Successfully!', 'Document successfully void!');
        return redirect()->intended('commitment/index');
    }
    public function restore(Request $request)
    {
        $commitment = Commitment::find($request->commitment_id);
        $commitment->void = 'false';
        $commitment->save();
        Alert::success('Restore Successfully!', 'Document successfully restore!');
        return redirect()->intended('commitment/index');
    }

    public function fetchCommitment($id)
    {
        $fetchCommitment = Commitment::select('commitments.*', 'users.name')->leftJoin('users', 'users.npk', 'commitments.npk')->where('commitments.id', '=', $id)->get();
        // dd($fetchCommitment);
        return response()->json($fetchCommitment);
    }
}
