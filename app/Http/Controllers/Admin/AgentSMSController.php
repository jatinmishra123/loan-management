<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\SMSLog;

class AgentSMSController extends Controller
{
    /**
     * Show all Agents for SMS Sending
     */
    public function index()
    {
        $agents = Agent::where('admin_id', auth()->guard('admin')->id())
                       ->where('is_active', 1)
                       ->get();

        return view('admin.sms.agents', compact('agents'));
    }

    /**
     * Save SMS Logs Only (NO SMS API CALL)
     */
    public function send(Request $request)
    {
        $request->validate([
            'ids'     => 'required|array',
            'message' => 'required|string|max:160',
        ]);

        $adminId = auth()->guard('admin')->id();

        $agents = Agent::whereIn('id', $request->ids)->get();

        foreach ($agents as $agent) {

            // SAVE LOG ONLY (NO API)
            SMSLog::create([
                'admin_id'      => $adminId,
                'agent_id'      => $agent->id,
                'mobile_number' => $agent->mobile_number,
                'message'       => $request->message,
                'status'        => 'success', 
            ]);
        }

        return back()->with('success', 'SMS saved successfully in database (No API Used).');
    }
}
