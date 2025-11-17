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
     * Handles both initial load and AJAX filtering.
     */
    public function index(Request $request)
    {
        $admin = auth('admin')->user();

        // Base query with relationships
        $query = Customer::with(['bank', 'branch', 'admin']);

        // Filter by Admin role
        if (!$admin->isSuperAdmin()) {
            $query->where('admin_id', $admin->id);
        }

        // Apply Search Filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brauser_name', 'LIKE', "%{$search}%")
                    ->orWhere('ralative_name', 'LIKE', "%{$search}%")
                    ->orWhere('loan_number', 'LIKE', "%{$search}%")
                    ->orWhere('ladger_number', 'LIKE', "%{$search}%")
                    ->orWhere('cash_incharge', 'LIKE', "%{$search}%");
            });
        }

        // Apply Status Filter
        if ($request->has('status') && !empty($request->status)) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        $customers = $query->latest()->paginate(10);

        // Handle AJAX requests for pagination and filtering
        if ($request->ajax()) {
            $html = view('admin.customers.partials.table_rows', compact('customers'))->render();
            $pagination = $customers->links('pagination::bootstrap-5')->toHtml();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

        return view('admin.customers.index', compact('customers'));
    }


    /**
     * Show form for creating a new customer.
     */
    public function create()
    {
        $adminId = auth('admin')->id();

        // Only admin-wise active banks
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
            'brauser_name'    => 'required|string|max:255',
            'ralative_name'   => 'required|string|max:255',
            'address'         => 'required|string|max:255',
            'date'            => 'required|date',
            'bank_id'         => 'required|exists:banks,id',
            'branch_id'       => 'required|exists:branches,id',
            'cash_incharge'   => 'required|string|max:255',
            'account_number'  => 'required|string|max:100',
            'loan_number'     => 'required|string|max:100',
            'saving_number'   => 'required|string|max:100',
            'ladger_number'   => 'required|string|max:100',
            'ledger_folio_no' => 'nullable|string|max:255',
            'gold_loan_alc_no'=> 'nullable|string|max:255',
            'is_active'       => 'required|boolean',
            'alter_address'   => 'nullable|string',
            'paid'            => 'required|integer|in:0,1,2',
            'tenure_days'     => 'nullable|integer',
            'customer_remarks' => 'nullable|string',
            'cash_incharge_additional' => 'nullable|string|max:255',
        ]);

        Customer::create([
            'admin_id'        => auth('admin')->id(),
            'brauser_name'    => $request->brauser_name,
            'ralative_name'   => $request->ralative_name,
            'address'         => $request->address,
            'date'            => $request->date,
            'bank_id'         => $request->bank_id,
            'branch_id'       => $request->branch_id,
            'cash_incharge'   => $request->cash_incharge,
            'account_number'  => $request->account_number,
            'loan_number'     => $request->loan_number,
            'saving_number'   => $request->saving_number,
            'ladger_number'   => $request->ladger_number,
            'ledger_folio_no' => $request->ledger_folio_no,
            'gold_loan_alc_no'=> $request->gold_loan_alc_no,
            'is_active'       => $request->is_active,
            'alter_address'   => $request->alter_address,
            'paid'            => $request->paid,
            'tenure_days'     => $request->tenure_days,
            'customer_remarks' => $request->customer_remarks,
            'cash_incharge_additional' => $request->cash_incharge_additional,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
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

    /**
     * Edit customer
     */
    public function edit(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            abort(403, 'Unauthorized access.');
        }

        $adminId = $customer->admin_id; // Use customer's admin_id for consistency

        // Admin-wise banks
        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        // Branches for the *currently selected* bank (needed for page load)
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
            'brauser_name'    => 'required|string|max:255',
            'ralative_name'   => 'required|string|max:255',
            'address'         => 'required|string|max:255',
            'date'            => 'required|date',
            'bank_id'         => 'required|exists:banks,id',
            'branch_id'       => 'required|exists:branches,id',
            'cash_incharge'   => 'required|string|max:255',
            'account_number'  => 'required|string|max:100',
            'loan_number'     => 'required|string|max:100',
            'saving_number'   => 'required|string|max:100',
            'ladger_number'   => 'required|string|max:100',
            'ledger_folio_no' => 'nullable|string|max:255',
            'gold_loan_alc_no'=> 'nullable|string|max:255',
            'is_active'       => 'required|boolean',
            'alter_address'   => 'nullable|string',
            'paid'            => 'required|integer|in:0,1,2',
            'tenure_days'     => 'nullable|integer',
            'customer_remarks' => 'nullable|string',
            'cash_incharge_additional' => 'nullable|string|max:255',
        ]);

        $customer->update([
            'brauser_name'    => $request->brauser_name,
            'ralative_name'   => $request->ralative_name,
            'address'         => $request->address,
            'date'            => $request->date,
            'bank_id'         => $request->bank_id,
            'branch_id'       => $request->branch_id,
            'cash_incharge'   => $request->cash_incharge,
            'account_number'  => $request->account_number,
            'loan_number'     => $request->loan_number,
            'saving_number'   => $request->saving_number,
            'ladger_number'   => $request->ladger_number,
            'ledger_folio_no' => $request->ledger_folio_no,
            'gold_loan_alc_no'=> $request->gold_loan_alc_no,
            'is_active'       => $request->is_active,
            'alter_address'   => $request->alter_address,
            'paid'            => $request->paid,
            'tenure_days'     => $request->tenure_days,
            'customer_remarks' => $request->customer_remarks,
            'cash_incharge_additional' => $request->cash_incharge_additional,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Delete customer
     * Logic: Super Admin OR The Creator Admin can delete.
     */
    public function destroy(Customer $customer)
    {
        $admin = auth('admin')->user();

        // CONDITION CHECK:
        // 1. Agar user Super Admin hai -> ALLOW
        // 2. YA FIR, agar user wahi hai jisne customer create kiya ($customer->admin_id == $admin->id) -> ALLOW
        if ($admin->isSuperAdmin() || $customer->admin_id == $admin->id) {
            
            try {
                $customer->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Customer deleted successfully.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete customer.'
                ], 500);
            }
        }

        // Agar upar wali condition match nahi hui, to permission nahi hai
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized action. You can only delete customers created by you.',
        ], 403);
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
            ->where('is_active', 1) // Only show active branches
            ->get(['id', 'branch_address', 'cash_incharge']); // 👈 Correct!

        return response()->json($branches);
    }

    /**
     * Toggle Status (AJAX)
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
}