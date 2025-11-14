<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display list of customers (Admin-wise)
     */
    public function index()
    {
        $admin = auth('admin')->user();

        $query = Customer::with(['bank', 'branch', 'admin'])->latest();

        // If NOT super admin → show only own customers
        if (!$admin->isSuperAdmin()) {
            $query->where('admin_id', $admin->id);
        }

        $customers = $query->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show form for creating a new customer.
     */
    public function create()
    {
        $adminId = auth('admin')->id();

        // Only admin-wise banks
        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        return view('admin.customers.create', compact('banks'));
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brauser_name'     => 'required|string|max:255',
            'ralative_name'    => 'required|string|max:255',
            'address'          => 'required|string|max:255',
            'date'             => 'required|date',

            'bank_id'          => 'required|exists:banks,id',
            'branch_id'        => 'required|exists:branches,id',

            'cash_incharge'    => 'required|string|max:255',

            'account_number'   => 'required|string|max:100',
            'loan_number'      => 'required|string|max:100',
            'saving_number'    => 'required|string|max:100',
            'ladger_number'    => 'required|string|max:100',

            'ledger_folio_no'  => 'nullable|string|max:255',
            'gold_loan_alc_no' => 'nullable|string|max:255',

            'is_active'        => 'nullable|boolean',

            'alter_address'    => 'nullable|string',
            'paid'             => 'required|boolean',
            'tenure_days'      => 'nullable|integer',
        ]);

        Customer::create([
            'admin_id'         => auth('admin')->id(),

            'brauser_name'     => $request->brauser_name,
            'ralative_name'    => $request->ralative_name,
            'address'          => $request->address,
            'date'             => $request->date,

            'bank_id'          => $request->bank_id,
            'branch_id'        => $request->branch_id,

            'cash_incharge'    => $request->cash_incharge,

            'account_number'   => $request->account_number,
            'loan_number'      => $request->loan_number,
            'saving_number'    => $request->saving_number,
            'ladger_number'    => $request->ladger_number,

            'ledger_folio_no'  => $request->ledger_folio_no,
            'gold_loan_alc_no' => $request->gold_loan_alc_no,

            'is_active'        => $request->boolean('is_active', true),

            'alter_address'    => $request->alter_address,
            'paid'             => $request->paid,
            'tenure_days'      => $request->tenure_days,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Edit customer
     */
    public function edit(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            abort(403, 'Unauthorized access.');
        }

        $adminId = auth('admin')->id();

        // Admin-wise banks
        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        // Admin-wise branches of selected bank
        $branches = Branch::where('admin_id', $adminId)
            ->where('bank_id', $customer->bank_id)
            ->get();

        return view('admin.customers.edit', compact('customer', 'banks', 'branches'));
    }

    /**
     * Update customer
     */
    public function update(Request $request, Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'brauser_name'     => 'required|string|max:255',
            'ralative_name'    => 'required|string|max:255',
            'address'          => 'required|string|max:255',
            'date'             => 'required|date',

            'bank_id'          => 'required|exists:banks,id',
            'branch_id'        => 'required|exists:branches,id',

            'cash_incharge'    => 'required|string|max:255',

            'account_number'   => 'required|string|max:100',
            'loan_number'      => 'required|string|max:100',
            'saving_number'    => 'required|string|max:100',
            'ladger_number'    => 'required|string|max:100',

            'ledger_folio_no'  => 'nullable|string|max:255',
            'gold_loan_alc_no' => 'nullable|string|max:255',

            'is_active'        => 'nullable|boolean',

            'alter_address'    => 'nullable|string',
            'paid'             => 'required|boolean',
            'tenure_days'      => 'nullable|integer',
        ]);

        $customer->update([
            'brauser_name'     => $request->brauser_name,
            'ralative_name'    => $request->ralative_name,
            'address'          => $request->address,
            'date'             => $request->date,

            'bank_id'          => $request->bank_id,
            'branch_id'        => $request->branch_id,

            'cash_incharge'    => $request->cash_incharge,

            'account_number'   => $request->account_number,
            'loan_number'      => $request->loan_number,
            'saving_number'    => $request->saving_number,
            'ladger_number'    => $request->ladger_number,

            'ledger_folio_no'  => $request->ledger_folio_no,
            'gold_loan_alc_no' => $request->gold_loan_alc_no,

            'is_active'        => $request->boolean('is_active', true),

            'alter_address'    => $request->alter_address,
            'paid'             => $request->paid,
            'tenure_days'      => $request->tenure_days,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Branches as per Bank (AJAX)
     * USED IN YOUR FRONTEND → MUST RETURN cash_incharge ALSO
     */
    public function getBranchesByBank($bankId)
    {
        $adminId = auth('admin')->id();

        $branches = Branch::where('admin_id', $adminId)
            ->where('bank_id', $bankId)
            ->get(['id', 'branch_address', 'cash_incharge']); // 👈 FIXED!

        return response()->json($branches);
    }

    /**
     * Toggle Status
     */
    public function toggleStatus(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $customer->update([
            'is_active' => !$customer->is_active
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Status updated successfully.',
            'is_active' => $customer->is_active,
        ]);
    }
    /**
 * Show single customer details
 */
public function show(Customer $customer)
{
    $admin = auth('admin')->user();

    // If not super admin → check owner
    if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
        abort(403, 'Unauthorized access.');
    }

    // Load bank, branch and gold items
    $customer->load(['bank', 'branch', 'goldItems']);

    return view('admin.customers.show', compact('customer'));
}

}
