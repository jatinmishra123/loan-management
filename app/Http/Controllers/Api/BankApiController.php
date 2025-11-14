<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankApiController extends Controller
{
    // 📋 List banks
    public function index()
    {
        $banks = Bank::latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $banks
        ]);
    }

    // ➕ Add new bank
    public function store(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'bank_code' => 'required|string|max:50|unique:banks,bank_code',
            'is_active' => 'required|boolean',
        ]);

        $bank = Bank::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Bank created successfully.',
            'data' => $bank
        ], 201);
    }

    // 👁 Show single bank
    public function show($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $bank
        ]);
    }

    // ✏️ Update bank
    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found.'
            ], 404);
        }

        $request->validate([
            'bank' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'bank_code' => 'required|string|max:50|unique:banks,bank_code,' . $bank->id,
            'is_active' => 'required|boolean',
        ]);

        $bank->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Bank updated successfully.',
            'data' => $bank
        ]);
    }

    // ❌ Delete bank
    public function destroy($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found.'
            ], 404);
        }

        $bank->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bank deleted successfully.'
        ]);
    }
}
