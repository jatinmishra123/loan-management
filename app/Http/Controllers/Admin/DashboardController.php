<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Agent;
use App\Models\GoldPrice;
use App\Models\AppraisalRecord;
use App\Models\Customer;
use App\Models\FinalAppraisalCertificate; // 👈 ADDED: Second Appraisal Certificate Model

class DashboardController extends Controller
{
    public function index()
    {
        $adminId = auth('admin')->id();

        // 1. 📊 Dashboard Stats
        $stats = [
            'total_banks'      => Bank::where('admin_id', $adminId)->count(),
            'total_branches'   => Branch::where('admin_id', $adminId)->count(),
            'total_agents'     => Agent::where('admin_id', $adminId)->count(),

            'active_banks'     => Bank::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_branches'  => Branch::where('admin_id', $adminId)->where('is_active', 1)->count(),
            'active_agents'    => Agent::where('admin_id', $adminId)->where('is_active', 1)->count(),
        ];

        // 2. 🏦 Recent Branches
        $recentBranches = Branch::with('bank')
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 3. 👨‍💼 Recent Agents
        $recentAgents = Agent::with(['bank', 'branch'])
            ->where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 4. 👥 Recent Customers
        $recentCustomers = Customer::where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // 5. 🟡 Gold Price (global)
        $latestPrice = GoldPrice::latest()->first();

        if (!$latestPrice) {
            $latestPrice = (object) [
                'price' => 0,
                'created_at' => null
            ];
        }

        // 6. 📄 FIRST Appraisal History (Existing Logic - AppraisalRecord)
        $appraisalHistory = AppraisalRecord::with('customer')
            ->whereHas('customer', function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->latest()
            ->limit(10)
            ->get();
            
        // 7. 📄 SECOND Appraisal History (New Logic - FinalAppraisalCertificate)
        $secondAppraisalHistory = FinalAppraisalCertificate::where('admin_id', $adminId)
            ->latest()
            ->limit(10)
            ->get();

        // Return view
        return view('admin.dashboard', compact(
            'stats',
            'recentBranches',
            'recentAgents',
            'latestPrice',
            'appraisalHistory',
            'recentCustomers',
            'secondAppraisalHistory' // 👈 ADDED to pass to the view
        ));
    }
}