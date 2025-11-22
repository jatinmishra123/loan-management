<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecondAppraisal;
use App\Models\FinalAppraisalCertificate; // 👈 NEW: Import the model for saving generated certificates
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage; // 👈 NEW: Import Storage facade for saving files

class SecondAppraisalController extends Controller
{
    /**
     * Display a listing of the Second Appraisals (Raw Data List).
     */
    public function index()
    {
        $adminId = auth('admin')->id();

        $appraisals = SecondAppraisal::with(['bank', 'branch'])
            ->where('admin_id', $adminId)
            ->latest()
            ->paginate(10);

        return view('admin.second-appraisal.index', compact('appraisals'));
    }

    /**
     * Show the form for creating a new Second Appraisal.
     */
    public function create()
    {
        $adminId = auth('admin')->id();

        return view('admin.second-appraisal.create', [
            'banks'    => \App\Models\Bank::where('admin_id', $adminId)->get(),
            'branches' => \App\Models\Branch::where('admin_id', $adminId)->get()
        ]);
    }

    /**
     * Store a newly created Second Appraisal in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gold_loan_account_no'  => 'required',
            'ledger_folio_no'       => 'required',
            'bank_id'               => 'required|exists:banks,id',
            'branch_id'             => 'required|exists:branches,id',
            'second_appraisal_date' => 'required|date',
            // Add other field validations here
        ]);

        SecondAppraisal::create([
            'admin_id'              => auth('admin')->id(),
            'gold_loan_account_no'  => $request->gold_loan_account_no,
            'ledger_folio_no'       => $request->ledger_folio_no,
            'bank_id'               => $request->bank_id,
            'branch_id'             => $request->branch_id,
            'second_appraisal_date' => $request->second_appraisal_date,
            'cash_incharge'         => $request->cash_incharge,
            'joint_custody_officer' => $request->joint_custody_officer,
        ]);

        return redirect()->route('admin.second-appraisal.index')
            ->with('success', 'Second appraisal added successfully.');
    }

    /**
     * Show the generator page where users select the ledger and range.
     */
    public function generator()
    {
        $adminId = auth('admin')->id();

        $ledgers = SecondAppraisal::where('admin_id', $adminId)
            ->select('id', 'ledger_folio_no')
            ->orderBy('ledger_folio_no')
            ->get();

        return view('admin.second-appraisal.second-appraisal-generator', compact('ledgers'));
    }

    /**
     * AJAX PREVIEW: Fetches data and returns the certificate HTML preview.
     */
    public function getData(Request $request, $id)
    {
        $appraisal = SecondAppraisal::with(['bank', 'branch', 'items'])
                                    ->where('admin_id', auth('admin')->id())
                                    ->findOrFail($id);

        $range = $request->range;
        $items = $appraisal->items;

        if ($range) {
            [$start, $end] = explode('-', $range);
            $items = collect($items)->slice($start - 1, ($end - $start) + 1);
        }

        $qrCode = base64_encode(
            QrCode::format('png')->size(120)->generate("Second Appraisal ID: {$appraisal->id}")
        );

        return view('admin.second-appraisal.pdf', [
            'customer' => $appraisal,
            'admin'    => auth('admin')->user(),
            'items'    => $items,
            'qrCode'   => $qrCode
        ])->render();
    }

    /**
     * Generates and downloads the PDF certificate, and SAVES the record.
     */
    public function downloadPdf(Request $request, $id)
    {
        $appraisal = SecondAppraisal::with(['bank', 'branch', 'items'])
                                    ->where('admin_id', auth('admin')->id())
                                    ->findOrFail($id);

        $range = $request->range;
        $items = $appraisal->items;

        if ($range) {
            [$start, $end] = explode('-', $range);
            $items = collect($items)->slice($start - 1, ($end - $start) + 1);
        }

        $qrCode = base64_encode(
            QrCode::format('png')->size(120)->generate("Second Appraisal ID: {$appraisal->id}")
        );

        $pdf = Pdf::loadView('admin.second-appraisal.pdf', [
            'customer' => $appraisal,
            'admin'    => auth('admin')->user(),
            'items'    => $items,
            'qrCode'   => $qrCode
        ]);

        // 1. Generate filename and path for storage
        $filename = "Second-Appraisal-{$appraisal->ledger_folio_no}-" . time() . ".pdf";
        $path = "public/certificates/" . $filename;
        
        // 2. Save the PDF file to storage (storage/app/public/certificates/)
        Storage::put($path, $pdf->output());

        // 3. Save a record of the generated certificate to the new table
        FinalAppraisalCertificate::create([
            'admin_id'                => auth('admin')->id(),
            'second_appraisal_id'     => $appraisal->id,
            'ledger_folio_no'         => $appraisal->ledger_folio_no,
            'gold_loan_account_no'    => $appraisal->gold_loan_account_no,
            'borrower_name'           => $appraisal->brauser_name ?? null, // Assuming 'brauser_name' holds the borrower's name
            'generated_pdf_path'      => $path,
        ]);


        // 4. Return the download response to the user
        return $pdf->download($filename);
    }
    
    /**
     * Downloads the saved certificate file from storage (for the Dashboard list).
     * 💡 NEW METHOD
     */
    public function downloadSavedCertificate($certificateId)
    {
        $record = FinalAppraisalCertificate::where('admin_id', auth('admin')->id())
                                           ->findOrFail($certificateId);
        
        if (Storage::exists($record->generated_pdf_path)) {
            // Force download the file with a clean name
            return Storage::download($record->generated_pdf_path, "Appraisal-{$record->ledger_folio_no}.pdf");
        }

        // If file not found, redirect back with an error message
        return back()->with('error', 'Certificate file not found in storage.');
    }
    
    // You would typically add edit/update/show/delete methods here
}