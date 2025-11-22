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
    public function index(Request $request)
    {
        $admin = auth('admin')->user();

        $query = Customer::with(['bank', 'branch', 'admin']);

        // Restrict to admin
        if (!$admin->isSuperAdmin()) {
            $query->where('admin_id', $admin->id);
        }

        // Search filter
        if (!empty($request->search)) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('brauser_name', 'LIKE', "%{$search}%")
                    ->orWhere('ralative_name', 'LIKE', "%{$search}%")
                    ->orWhere('loan_number', 'LIKE', "%{$search}%")
                    ->orWhere('ladger_number', 'LIKE', "%{$search}%")
                    ->orWhere('cash_incharge', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if (!empty($request->status)) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $customers = $query->latest()->paginate(10);

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.customers.partials.table_rows', compact('customers'))->render(),
                'pagination' => $customers->links('pagination::bootstrap-5')->toHtml(),
            ]);
        }

        return view('admin.customers.index', compact('customers'));
    }


    /**
     * Create Customer Form
     */
    public function create()
    {
        $adminId = auth('admin')->id();

        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        return view('admin.customers.create', compact('banks'));
    }


    /**
     * Store Customer
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
     * Show Customer Details
     */
    public function show(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            abort(403, 'Unauthorized access.');
        }

        $customer->load(['bank', 'branch']);

        return view('admin.customers.show', compact('customer'));
    }


    /**
     * Edit Customer Form
     */
    public function edit(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            abort(403, 'Unauthorized access.');
        }

        $adminId = $customer->admin_id;

        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        $branches = Branch::where('admin_id', $adminId)
            ->where('bank_id', $customer->bank_id)
            ->get();

        return view('admin.customers.edit', compact('customer', 'banks', 'branches'));
    }


    /**
     * Update Customer
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
     * Delete Customer
     */
    public function destroy(Customer $customer)
    {
        $admin = auth('admin')->user();

        if ($admin->isSuperAdmin() || $customer->admin_id == $admin->id) {
            try {
                $customer->delete();
                return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to delete customer.'], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized action.'
        ], 403);
    }


    /**
     * AJAX: Branch list based on bank
     */
    public function getBranchesByBank($bankId)
    {
        $adminId = auth('admin')->id();

        $branches = Branch::where('admin_id', $adminId)
            ->where('bank_id', $bankId)
            ->where('is_active', 1)
            ->get(['id', 'branch_address', 'cash_incharge']);

        return response()->json($branches);
    }


    /**
     * Toggle Status
     */
    public function toggleStatus(Customer $customer)
    {
        $admin = auth('admin')->user();

        if (!$admin->isSuperAdmin() && $customer->admin_id != $admin->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $customer->update(['is_active' => !$customer->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'is_active' => $customer->is_active,
        ]);
    }
}
