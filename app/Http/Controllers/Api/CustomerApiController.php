<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    /**
     * List all customers (admin wise)
     */
    public function index(Request $request)
    {
        if (!$request->admin_id) {
            return response()->json([
                'status' => false,
                'message' => 'admin_id is required'
            ], 400);
        }

        $query = Customer::with(['bank', 'branch'])
            ->where('admin_id', $request->admin_id);

        if (!empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brauser_name', 'LIKE', "%$search%")
                    ->orWhere('loan_number', 'LIKE', "%$search%")
                    ->orWhere('ladger_number', 'LIKE', "%$search%");
            });
        }

        if (!empty($request->status)) {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        return response()->json([
            'status' => true,
            'data' => $query->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Store new customer
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id'        => 'required|integer',
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
            'customer_remarks'=> 'nullable|string',
            'cash_incharge_additional' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully.',
            'data' => $customer
        ], 201);
    }

    /**
     * Show customer details
     */
    public function show($id)
    {
        $customer = Customer::with(['bank', 'branch'])->find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $customer
        ]);
    }

    /**
     * Update customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
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
            'customer_remarks'=> 'nullable|string',
            'cash_incharge_additional' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $customer->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully.',
            'data' => $customer
        ]);
    }

    /**
     * Delete customer
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully.'
        ]);
    }

    /**
     * Get branches based on bank
     */
    public function getBranches(Request $request)
    {
        if (!$request->bank_id) {
            return response()->json([
                'status' => false,
                'message' => 'bank_id is required'
            ], 400);
        }

        $branches = Branch::where('bank_id', $request->bank_id)
            ->where('is_active', 1)
            ->get(['id', 'branch_address', 'cash_incharge']);

        return response()->json([
            'status' => true,
            'data' => $branches
        ]);
    }
}
