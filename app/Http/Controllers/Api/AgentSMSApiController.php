<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SMSLog;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentSMSApiController extends Controller
{
    /**
     * 🔹 Admin: Send SMS to Single or All Agents
     */
    public function send(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|integer',
            'type'     => 'required|in:single,all',
            'message'  => 'required|string|max:160',
            'agent_id' => 'required_if:type,single|integer'
        ]);

        $adminId = $request->admin_id;

        if ($request->type === 'single') {

            // Find the single agent
            $agent = Agent::where('admin_id', $adminId)
                ->where('id', $request->agent_id)
                ->first();

            if (!$agent) {
                return response()->json([
                    'status' => false,
                    'message' => 'Agent not found or does not belong to this admin'
                ], 404);
            }

            // Save SMS log for single agent
            SMSLog::create([
                'admin_id'      => $adminId,
                'agent_id'      => $agent->id,
                'mobile_number' => $agent->mobile_number,
                'message'       => $request->message,
                'status'        => 'success'
            ]);

        } else {

            // Send to ALL active agents of this admin
            $agents = Agent::where('admin_id', $adminId)
                ->where('is_active', 1)
                ->get();

            foreach ($agents as $agent) {
                SMSLog::create([
                    'admin_id'      => $adminId,
                    'agent_id'      => $agent->id,
                    'mobile_number' => $agent->mobile_number,
                    'message'       => $request->message,
                    'status'        => 'success'
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'SMS logs saved successfully'
        ], 200);
    }

    /**
     * 🟢 Agent fetch his SMS (own + broadcast)
     */
    public function agentMessages(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|integer',
            'agent_id' => 'required|integer'
        ]);

        $adminId = $request->admin_id;

        // Fetch SMS logs for:
        // 1. This agent only
        // 2. OR broadcast messages (agent_id = NULL)
        $logs = SMSLog::where('admin_id', $adminId)
            ->where(function ($query) use ($request) {
                $query->where('agent_id', $request->agent_id)
                      ->orWhereNull('agent_id');  // Broadcast
            })
            ->latest()
            ->get([
                'id',
                'admin_id',
                'agent_id',
                'mobile_number',
                'message',
                'status',
                'created_at'
            ]);

        return response()->json([
            'status' => true,
            'message_count' => $logs->count(),
            'data' => $logs
        ], 200);
    }
}
