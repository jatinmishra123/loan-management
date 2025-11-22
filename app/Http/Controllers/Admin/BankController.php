<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::where('admin_id', auth()->guard('admin')->id())
                     ->latest()
                     ->paginate(10);

        return view('admin.bank.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank'       => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'ifsc_code'    => 'nullable|string|max:255',
            'bank_code'  => 'required|string|max:50|unique:banks,bank_code',
            'is_active'  => 'required|boolean',
        ]);

        Bank::create([
            'admin_id'   => auth()->guard('admin')->id(),  // FIXED
            'bank'       => $request->bank,
            'address'    => $request->address,
            'ifsc_code'    => $request->ifsc_code,
            'bank_code'  => $request->bank_code,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.bank.index')
            ->with('success', 'Bank created successfully.');
    }

    public function edit(Bank $bank)
    {
        // Security: Prevent another admin from editing
        if ($bank->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        return view('admin.bank.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        if ($bank->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        $request->validate([
            'bank'       => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
               'ifsc_code'    => 'nullable|string|max:255',
            'bank_code'  => 'required|string|max:50|unique:banks,bank_code,' . $bank->id,
            'is_active'  => 'required|boolean',
        ]);

        $bank->update([
            'admin_id'   => auth()->guard('admin')->id(),
            'bank'       => $request->bank,
            'address'    => $request->address,
            'ifsc_code'    => $request->ifsc_code,
            'bank_code'  => $request->bank_code,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.bank.index')
            ->with('success', 'Bank updated successfully.');
    }

    public function destroy(Bank $bank)
    {
        if ($bank->admin_id != auth()->guard('admin')->id()) {
            abort(403, "Unauthorized Access");
        }

        $bank->delete();

        return redirect()->route('admin.bank.index')
            ->with('success', 'Bank deleted successfully.');
    }
}
