<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AgentController extends Controller
{
    /**
     * Display list of Agents (Admin-wise)
     */
    public function index()
    {
        $adminId = auth()->guard('admin')->id();

        $agents = Agent::with(['bank', 'branch'])
            ->where('admin_id', $adminId)
            ->latest()
            ->paginate(10);

        return view('admin.agent.index', compact('agents'));
    }

    /**
     * Create Page - Admin's own banks
     */
    public function create()
    {
        $adminId = auth()->guard('admin')->id();

        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        return view('admin.agent.create', compact('banks'));
    }

    /**
     * Store Agent
     */
    public function store(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        $request->validate([
            'bank_id'         => 'required|exists:banks,id',
            'branch_id'       => 'required|exists:branches,id',
            'designation'     => 'required|string|max:100',
            'name'            => 'required|string|max:150',
            'email'           => 'required|email|unique:agents,email',
            'mobile_number'   => 'required|digits:10|unique:agents,mobile_number',
            'whatsapp_number' => 'nullable|digits:10',
            'password'        => 'required|min:6',
            'image'           => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->except(['password', 'image']);
        $data['password'] = Hash::make($request->password);
        $data['admin_id'] = $adminId;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('agents', 'public');
        }

        Agent::create($data);

        return redirect()
            ->route('admin.agent.index')
            ->with('success', 'Agent created successfully!');
    }

    /**
     * Edit Agent
     */
    public function edit(Agent $agent)
    {
        $adminId = auth()->guard('admin')->id();

        if ($agent->admin_id != $adminId) {
            abort(403, 'Unauthorized Access');
        }

        $banks = Bank::where('admin_id', $adminId)
            ->where('is_active', 1)
            ->get();

        $branches = Branch::where('admin_id', $adminId)
            ->where('bank_id', $agent->bank_id)
            ->get();

        return view('admin.agent.edit', compact('agent', 'banks', 'branches'));
    }

    /**
     * Update Agent
     */
    public function update(Request $request, Agent $agent)
    {
        $adminId = auth()->guard('admin')->id();

        if ($agent->admin_id != $adminId) {
            abort(403, 'Unauthorized Access');
        }

        $request->validate([
            'bank_id'         => 'required|exists:banks,id',
            'branch_id'       => 'required|exists:branches,id',
            'designation'     => 'required|string|max:100',
            'name'            => 'required|string|max:150',
            'email'           => 'required|email|unique:agents,email,' . $agent->id,
            'mobile_number'   => 'required|digits:10|unique:agents,mobile_number,' . $agent->id,
            'whatsapp_number' => 'nullable|digits:10',
            'password'        => 'nullable|min:6',
            'image'           => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->except(['password', 'image']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('agents', 'public');
        }

        $data['admin_id'] = $adminId;

        $agent->update($data);

        return redirect()
            ->route('admin.agent.index')
            ->with('success', 'Agent updated successfully!');
    }

    /**
     * Delete Agent
     */
    public function destroy(Agent $agent)
    {
        $adminId = auth()->guard('admin')->id();

        if ($agent->admin_id != $adminId) {
            abort(403, 'Unauthorized Access');
        }

        $agent->delete();

        return redirect()
            ->route('admin.agent.index')
            ->with('success', 'Agent deleted successfully!');
    }

    /**
     * Certificate PDF
     */
    public function certificate($id)
    {
        $adminId = auth()->guard('admin')->id();

        $agent = Agent::where('admin_id', $adminId)
            ->with(['bank', 'branch'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('admin.agent.certificate', [
            'agent' => $agent,
            'date'  => now()->format('d/m/Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('certificate_' . $agent->name . '.pdf');
    }

    /**
     * Invoice List (Admin-Wise)
     */
    public function invoiceIndex()
    {
        $adminId = auth()->guard('admin')->id();

        $agents = Agent::where('admin_id', $adminId)->paginate(10);

        return view('admin.invoices.index', compact('agents'));
    }
}
