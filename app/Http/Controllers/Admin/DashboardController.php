<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Agent;
use App\Models\GoldPrice;
use App\Models\AppraisalRecord;   // ⭐ ADD THIS

class DashboardController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->id();

        // 📊 Dashboard Stats
        $stats = [
            'total_banks'      => Bank::where('admin_id', $adminId)->count(),
            'total_branches'   => Branch::where('admin_id', $adminId)->count(),
            'total_agents'     => Agent::where('admin_id', $adminId)->count(),

            'active_banks'     => Bank::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_branches'  => Branch::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_agents'    => Agent::where('admin_id', $adminId)->where('is_active', 1)->count(),
        ];

        // 🏦 Recent Branches
        $recentBranches = Branch::with('bank')
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 👨‍💼 Recent Agents
        $recentAgents = Agent::with(['bank', 'branch'])
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 🟡 Gold Price (global)
        $latestPrice = GoldPrice::latest()->first();

        if (!$latestPrice) {
            $latestPrice = (object) [
                'price' => 0,
                'created_at' => null
            ];
        }

        // 📄 ⭐ Recent Appraisal Records (Admin-wise)
        $appraisalHistory = AppraisalRecord::with('customer')
            ->whereHas('customer', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->latest()
            ->limit(10)
            ->get();

        // Return view
        return view('admin.dashboard', compact(
            'stats',
            'recentBranches',
            'recentAgents',
            'latestPrice',
            'appraisalHistory'   // ⭐ ADD THIS TO VIEW
        ));
    }
}
