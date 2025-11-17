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
     * Display list (Admin Wise)
     */
    public function index(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        $query = Invoice::with('customer')
            ->where('admin_id', $adminId)
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

        // Filter by customer dropdown
        if ($request->filled('customer')) {
            $query->where('customer_id', $request->customer);
        }

        $invoices = $query->paginate(10);

        // Admin-wise customers dropdown
        $customers = Customer::where('admin_id', $adminId)
            ->select('id', 'brauser_name')
            ->get();

        // AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'table_html' => view('admin.invoices.partials.table', compact('invoices'))->render(),
                'pagination_html' => $invoices->links('pagination::bootstrap-5')->toHtml(),
            ]);
        }

        return view('admin.invoices.index', compact('invoices', 'customers'));
    }

    /**
     * Show Create Page
     */
    public function create()
    {
        $adminId = auth()->guard('admin')->id();

        $customers = Customer::where('admin_id', $adminId)
            ->select('id', 'brauser_name')
            ->get();

        // Generate invoice number
        $prefix = 'VSJ/SBI/DAR/';
        $datePart = now()->format('ymd');

        $lastInvoice = Invoice::where('admin_id', $adminId)
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
     * Store Invoice
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
        $data['admin_id'] = auth()->guard('admin')->id();

        Invoice::create($data);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice added successfully!');
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $adminId = auth()->guard('admin')->id();

        $invoice = Invoice::where('admin_id', $adminId)->findOrFail($id);

        $customers = Customer::where('admin_id', $adminId)
            ->select('id', 'brauser_name')
            ->get();

        return view('admin.invoices.edit', compact('invoice', 'customers'));
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $adminId = auth()->guard('admin')->id();

        $invoice = Invoice::where('admin_id', $adminId)->findOrFail($id);

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
        $data['admin_id'] = $adminId;

        $invoice->update($data);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $adminId = auth()->guard('admin')->id();

        $invoice = Invoice::where('admin_id', $adminId)->findOrFail($id);

        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully.'
        ]);
    }

    /**
     * Show Invoice
     */
    public function show($id)
    {
        $adminId = auth()->guard('admin')->id();

        $invoice = Invoice::where('admin_id', $adminId)
            ->with('customer')
            ->findOrFail($id);

        $admin = auth('admin')->user();

        return view('admin.invoices.show', compact('invoice', 'admin'));
    }

    /**
     * Download PDF
     */
    public function downloadPDF($id)
    {
        $adminId = auth()->guard('admin')->id();

        $invoice = Invoice::where('admin_id', $adminId)
            ->with('customer')
            ->findOrFail($id);

        $admin = auth('admin')->user();

        $fileName = 'Invoice_' . Str::slug($invoice->invoice_no, '_') . '.pdf';

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice', 'admin'))
            ->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }
}
