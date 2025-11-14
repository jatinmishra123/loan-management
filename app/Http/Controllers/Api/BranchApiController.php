<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchApiController extends Controller
{
    // 📋 List branches with bank info
    public function index()
    {
        $branches = Branch::with('bank')->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $branches
        ]);
    }

    // ➕ Add new branch
    public function store(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'branch_address' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $branch = Branch::create($request->only(['bank_id', 'branch_address', 'is_active']));

        return response()->json([
            'status' => true,
            'message' => 'Branch created successfully.',
            'data' => $branch
        ], 201);
    }

    // 👁 Show single branch
    public function show($id)
    {
        $branch = Branch::with('bank')->find($id);

        if (!$branch) {
            return response()->json([
                'status' => false,
                'message' => 'Branch not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $branch
        ]);
    }

    // ✏️ Update branch
    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json([
                'status' => false,
                'message' => 'Branch not found.'
            ], 404);
        }

        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'branch_address' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $branch->update($request->only(['bank_id', 'branch_address', 'is_active']));

        return response()->json([
            'status' => true,
            'message' => 'Branch updated successfully.',
            'data' => $branch
        ]);
    }

    // ❌ Delete branch
    public function destroy($id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json([
                'status' => false,
                'message' => 'Branch not found.'
            ], 404);
        }

        $branch->delete();

        return response()->json([
            'status' => true,
            'message' => 'Branch deleted successfully.'
        ]);
    }
}
