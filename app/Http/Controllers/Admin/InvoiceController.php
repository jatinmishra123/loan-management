<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices (Admin Wise)
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer')
            ->where('admin_id', auth()->guard('admin')->id())  // ADMIN FILTER
            ->latest();

        // 🔍 Search Filter
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%$search%")
                  ->orWhere('bank_name', 'like', "%$search%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('brauser_name', 'like', "%$search%");
                  });
            });
        }

        // Filter by customer
        if ($request->filled('customer')) {
            $query->where('customer_id', $request->customer);
        }

        $invoices = $query->paginate(10);

        // Only admin's customers
        $customers = Customer::where('admin_id', auth()->guard('admin')->id())
            ->select('id', 'brauser_name')
            ->get();

        // AJAX request for live search
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.invoices.partials.table', compact('invoices'))->render(),
                'pagination' => $invoices->links('pagination::bootstrap-5')->toHtml()
            ]);
        }

        return view('admin.invoices.index', compact('invoices', 'customers'));
    }

    /**
     * Show invoice create page
     */
    public function create()
    {
        // Only admin’s customers
        $customers = Customer::where('admin_id', auth()->guard('admin')->id())
            ->select('id', 'brauser_name')
            ->get();

        // Unique Invoice Number (ADMIN WISE)
        $prefix = 'VSJ/SBI/DAR/';
        $datePart = now()->format('ymd');

        $lastInvoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->latest('id')
            ->first();

        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $invoiceNo = $prefix . $datePart . '-' . $nextId;

        return view('admin.invoices.create', [
            'customers' => $customers,
            'generatedInvoiceNo' => $invoiceNo,
        ]);
    }

    /**
     * Store invoice
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'invoice_no'      => 'required|string|max:255|unique:invoices,invoice_no',
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string|max:255',
            'round_off'       => 'nullable|numeric',
            'company_pan'     => 'nullable|string|max:10',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_name'       => 'nullable|string|max:100',
            'ifsc_code'       => 'nullable|string|max:20',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->guard('admin')->id(); // SAVE ADMIN ID

        Invoice::create($data);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice added successfully!');
    }

    /**
     * Edit invoice
     */
    public function edit($id)
    {
        $invoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->findOrFail($id);

        $customers = Customer::where('admin_id', auth()->guard('admin')->id())
            ->select('id', 'brauser_name')
            ->get();

        return view('admin.invoices.edit', compact('invoice', 'customers'));
    }

    /**
     * Update invoice
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->findOrFail($id);

        $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'invoice_no'      => 'required|string|max:255|unique:invoices,invoice_no,' . $invoice->id,
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string|max:255',
            'round_off'       => 'nullable|numeric',
            'company_pan'     => 'nullable|string|max:10',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_name'       => 'nullable|string|max:100',
            'ifsc_code'       => 'nullable|string|max:20',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->guard('admin')->id();

        $invoice->update($data);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    /**
     * Delete invoice
     */
    public function destroy($id)
    {
        $invoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->findOrFail($id);

        $invoice->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Show Invoice Details
     */
    public function show($id)
    {
        $invoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->with('customer')
            ->findOrFail($id);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Download Invoice PDF
     */
    public function downloadPDF($id)
    {
        $invoice = Invoice::where('admin_id', auth()->guard('admin')->id())
            ->with('customer')
            ->findOrFail($id);

        // Clean filename
        $safeInvoiceNo = Str::slug($invoice->invoice_no, '_');
        $fileName = 'Invoice_' . $safeInvoiceNo . '.pdf';

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))
            ->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }
}
