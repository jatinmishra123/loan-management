<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchApiController extends Controller
{
    /**
     * List Branches (Admin Wise)
     */
    public function index(Request $request)
    {
        if (!$request->admin_id) {
            return response()->json([
                'status' => false,
                'message' => 'admin_id is required'
            ], 400);
        }

        $branches = Branch::with('bank')
            ->where('admin_id', $request->admin_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $branches
        ]);
    }

    /**
     * Create Branch
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id'       => 'required|integer',
            'bank_id'        => 'required|exists:banks,id',
            'cash_incharge'  => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_email'   => 'required|string|max:255',
            'is_active'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $branch = Branch::create([
            'admin_id'       => $request->admin_id,
            'bank_id'        => $request->bank_id,
            'cash_incharge'  => $request->cash_incharge,
            'branch_address' => $request->branch_address,
            'branch_email'   => $request->branch_email,
            'is_active'      => $request->is_active,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Branch created successfully.',
            'data'    => $branch
        ], 201);
    }

    /**
     * Show Single Branch
     */
    public function show($id)
    {
        $branch = Branch::with('bank')->find($id);

        if (!$branch) {
            return response()->json([
                'status'  => false,
                'message' => 'Branch not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $branch
        ]);
    }

    /**
     * Update Branch
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json([
                'status'  => false,
                'message' => 'Branch not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'bank_id'        => 'required|exists:banks,id',
            'cash_incharge'  => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_email'   => 'required|string|max:255',
            'is_active'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $branch->update([
            'bank_id'        => $request->bank_id,
            'cash_incharge'  => $request->cash_incharge,
            'branch_address' => $request->branch_address,
            'branch_email'   => $request->branch_email,
            'is_active'      => $request->is_active,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Branch updated successfully.',
            'data'    => $branch
        ]);
    }

    /**
     * Delete Branch
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json([
                'status'  => false,
                'message' => 'Branch not found'
            ], 404);
        }

        $branch->delete();

        return response()->json([
            'status' => true,
            'message' => 'Branch deleted successfully.'
        ]);
    }
}
