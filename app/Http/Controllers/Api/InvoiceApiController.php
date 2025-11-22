<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class InvoiceApiController extends Controller
{
    /**
     * 🟢 List Invoices (Admin Wise)
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $query = Invoice::with('customer')
            ->where('admin_id', $request->admin_id)
            ->latest();

        // 🔍 Search
        if ($request->filled('search')) {
            $s = $request->search;

            $query->where(function ($q) use ($s) {
                $q->where('invoice_no', 'LIKE', "%$s%")
                    ->orWhere('bank_name', 'LIKE', "%$s%")
                    ->orWhereHas('customer', function ($c) use ($s) {
                        $c->where('brauser_name', 'LIKE', "%$s%")
                          ->orWhere('phone', 'LIKE', "%$s%");
                    });
            });
        }

        // 👤 Customer Filter
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        return response()->json([
            'status' => true,
            'data' => $query->paginate(10)
        ]);
    }

    /**
     * 🟢 Create Invoice
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id'        => 'required|integer',
            'customer_id'     => 'required|exists:customers,id',
            'invoice_no'      => 'required|string|unique:invoices,invoice_no',
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string|max:255',
            'round_off'       => 'nullable|numeric',
            'company_pan'     => 'nullable|string|max:20',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_name'       => 'nullable|string|max:100',
            'ifsc_code'       => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $invoice = Invoice::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Invoice created successfully!',
            'data' => $invoice
        ]);
    }

    /**
     * 🟢 Show Single Invoice
     */
    public function show($id)
    {
        $invoice = Invoice::with('customer')->find($id);

        if (!$invoice) {
            return response()->json(['status' => false, 'message' => 'Invoice not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $invoice
        ]);
    }

    /**
     * 🟢 Update Invoice
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['status' => false, 'message' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_id'     => 'required|exists:customers,id',
            'invoice_no'      => 'required|string|max:255|unique:invoices,invoice_no,' . $invoice->id,
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string|max:255',
            'round_off'       => 'nullable|numeric',
            'company_pan'     => 'nullable|string|max:20',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_name'       => 'nullable|string|max:100',
            'ifsc_code'       => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $invoice->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Invoice updated successfully!',
            'data' => $invoice
        ]);
    }

    /**
     * 🟢 Delete Invoice
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['status' => false, 'message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json([
            'status' => true,
            'message' => 'Invoice deleted successfully!'
        ]);
    }

    /**
     * 🟢 Download PDF (API)
     */
    public function downloadPdf($id)
    {
        $invoice = Invoice::with('customer')->find($id);

        if (!$invoice) {
            return response()->json(['status' => false, 'message' => 'Invoice not found'], 404);
        }

        $fileName = 'Invoice_' . Str::slug($invoice->invoice_no, '_') . '.pdf';

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

        return $pdf->download($fileName);
    }
}
