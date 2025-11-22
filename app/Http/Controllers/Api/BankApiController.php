<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;

class BankApiController extends Controller
{
    /**
     * Show all banks (Admin Wise)
     */
    public function index(Request $request)
    {
        if (!$request->admin_id) {
            return response()->json([
                'status' => false,
                'message' => 'admin_id is required'
            ], 400);
        }

        $banks = Bank::where('admin_id', $request->admin_id)
                    ->orderBy('id', 'DESC')
                    ->get();

        return response()->json([
            'status' => true,
            'banks' => $banks
        ]);
    }

    /**
     * Store new bank
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id'   => 'required|integer',
            'bank'       => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'ifsc_code'  => 'nullable|string|max:255',
            'bank_code'  => 'required|string|max:50|unique:banks,bank_code',
            'is_active'  => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bank = Bank::create([
            'admin_id'  => $request->admin_id,
            'bank'      => $request->bank,
            'address'   => $request->address,
            'ifsc_code' => $request->ifsc_code,
            'bank_code' => $request->bank_code,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bank created successfully.',
            'data' => $bank
        ], 201);
    }

    /**
     * Show single bank
     */
    public function show($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $bank
        ]);
    }

    /**
     * Update bank
     */
    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'bank'       => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'ifsc_code'  => 'nullable|string|max:255',
            'bank_code'  => 'required|string|max:50|unique:banks,bank_code,' . $id,
            'is_active'  => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Update Now
        $bank->update([
            'bank'      => $request->bank,
            'address'   => $request->address,
            'ifsc_code' => $request->ifsc_code,
            'bank_code' => $request->bank_code,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bank updated successfully.',
            'data' => $bank
        ]);
    }

    /**
     * Delete bank
     */
    public function destroy($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found'
            ], 404);
        }

        $bank->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bank deleted successfully.'
        ]);
    }
}
