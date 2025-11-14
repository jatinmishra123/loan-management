<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgentAuthController extends Controller
{
    // 📌 Agent Login API
    public function login(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
            'password' => 'required',
        ]);

        // Eager load bank & branch (only needed columns)
        $agent = Agent::with([
            'bank:id,bank',
            'branch:id,branch_address'
        ])->where('mobile_number', $request->mobile_number)->first();

        if (!$agent) {
            return response()->json([
                'status' => false,
                'message' => 'Agent not found',
            ], 404);
        }

        if (!Hash::check($request->password, $agent->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // ✅ Generate random token
        $token = Str::random(60);

        // ✅ Save token in DB (allow multi-device login)
        AgentToken::create([
            'agent_id' => $agent->id,
            'token' => $token,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'agent' => [
                'id' => $agent->id,
                'name' => $agent->name,
                'email' => $agent->email,
                'mobile_number' => $agent->mobile_number,

                // ✅ Bank: use `bank` column
                'bank' => $agent->bank?->bank,

                // ✅ Branch: send `branch_address`
                'branch' => $agent->branch ? [
                    'id' => $agent->branch->id,
                    'branch_address' => $agent->branch->branch_address,
                ] : null,

                'image' => $agent->image ? asset('storage/' . $agent->image) : null,
            ],
            'token' => $token,
        ], 200);
    }

    // 📌 Agent Logout API
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token not provided',
            ], 400);
        }

        $deleted = AgentToken::where('token', $token)->delete();

        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Logout successful',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid token',
        ], 401);
    }
}
