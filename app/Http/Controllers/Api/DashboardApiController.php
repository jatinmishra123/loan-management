<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Agent;
use App\Models\GoldPrice;
use App\Models\AppraisalRecord;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|integer'
        ]);

        $adminId = $request->admin_id;

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
        $recentBranches = Branch::with('bank:id,bank')
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 👨‍💼 Recent Agents
        $recentAgents = Agent::with(['bank:id,bank', 'branch:id,branch_address'])
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 👥 Recent Customers
        $recentCustomers = Customer::where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 🟡 Latest Gold Price
        $latestPrice = GoldPrice::latest()->first() ?? (object)[
            'price' => 0,
            'created_at' => null
        ];

        // 📄 Recent Appraisal History
        $appraisalHistory = AppraisalRecord::with('customer:id,brauser_name,admin_id')
            ->whereHas('customer', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'status' => true,
            'stats' => $stats,
            'recent_branches' => $recentBranches,
            'recent_agents' => $recentAgents,
            'recent_customers' => $recentCustomers,
            'gold_price' => $latestPrice,
            'appraisal_history' => $appraisalHistory,
        ], 200);
    }
}
