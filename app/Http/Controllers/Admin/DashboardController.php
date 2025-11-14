<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Agent;
use App\Models\GoldPrice;

class DashboardController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->id();

        // --------------------------------------
        // 📊 Dashboard Stats (Admin-wise)
        // --------------------------------------
        $stats = [
            'total_banks'      => Bank::where('admin_id', $adminId)->count(),
            'total_branches'   => Branch::where('admin_id', $adminId)->count(),
            'total_agents'     => Agent::where('admin_id', $adminId)->count(),

            'active_banks'     => Bank::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_branches'  => Branch::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_agents'    => Agent::where('admin_id', $adminId)->where('is_active', 1)->count(),
        ];

        // --------------------------------------
        // 🏦 Recent Branches (Admin-wise)
        // --------------------------------------
        $recentBranches = Branch::with('bank')
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // --------------------------------------
        // 👨‍💼 Recent Agents (Admin-wise)
        // --------------------------------------
        $recentAgents = Agent::with(['bank', 'branch'])
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // --------------------------------------
        // 🟡 Gold Price (GLOBAL – same for all admins)
        // --------------------------------------
        $latestPrice = GoldPrice::latest()->first();  // ❗ No admin filter

        if (!$latestPrice) {
            $latestPrice = (object) [
                'price' => 0,
                'created_at' => null
            ];
        }

        // --------------------------------------
        // 📤 Return View
        // --------------------------------------
        return view('admin.dashboard', compact(
            'stats',
            'recentBranches',
            'recentAgents',
            'latestPrice'
        ));
    }
}
