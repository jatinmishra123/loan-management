<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Bank;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Branch List (Admin wise)
     */
    public function index()
    {
        $branches = Branch::with('bank')
            ->where('admin_id', auth()->guard('admin')->id())
            ->latest()
            ->paginate(10);

        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $banks = Bank::where('admin_id', auth()->guard('admin')->id())
                     ->where('is_active', 1)
                     ->get();

        return view('admin.branch.create', compact('banks'));
    }

    /**
     * Store Branch
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_id'        => 'required|exists:banks,id',
            'cash_incharge'  => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_email' => 'required|string|max:255',

            'is_active'      => 'required|boolean',
        ]);

        Branch::create([
            'admin_id'       => auth()->guard('admin')->id(),
            'bank_id'        => $request->bank_id,
            'cash_incharge'  => $request->cash_incharge,
            'branch_address' => $request->branch_address,
            'branch_email' => $request->branch_email,

            'is_active'      => $request->is_active,
        ]);

        return redirect()->route('admin.branch.index')
            ->with('success', 'Branch created successfully!');
    }

    /**
     * Show Edit Form
     */
    public function edit(Branch $branch)
    {
        // Prevent unauthorized access
        if ($branch->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        $banks = Bank::where('admin_id', auth()->guard('admin')->id())
                     ->where('is_active', 1)
                     ->get();

        return view('admin.branch.edit', compact('branch', 'banks'));
    }

    /**
     * Update Branch
     */
    public function update(Request $request, Branch $branch)
    {
        if ($branch->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        $request->validate([
            'bank_id'        => 'required|exists:banks,id',
            'cash_incharge'  => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_email' => 'required|string|max:255',

            'is_active'      => 'required|boolean',
        ]);
        $branch->update([
            'admin_id'       => auth()->guard('admin')->id(),
            'bank_id'        => $request->bank_id,
            'cash_incharge'  => $request->cash_incharge,
            'branch_address' => $request->branch_address,
            'branch_email' => $request->branch_email,

            'is_active'      => $request->is_active,
        ]);

        return redirect()->route('admin.branch.index')
            ->with('success', 'Branch updated successfully!');
    }

    /**
     * Delete Branch
     */
    public function destroy(Branch $branch)
    {
        if ($branch->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        $branch->delete();

        return redirect()->route('admin.branch.index')
            ->with('success', 'Branch deleted successfully!');
    }
}
