<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Added for validation

class ManageAdminController extends Controller
{
    /**
     * Display a listing of the admins.
     */
    public function index()
    {
        // Get all admins, but you might want to exclude the current user
        // or handle pagination if you have many admins.
        $admins = Admin::all();
        return view('admin.manage_admins.index', compact('admins'));
    }

    /**
     * Show the create admin form
     */
    public function create()
    {
        return view('admin.manage_admins.create');
    }

    /**
     * Store the new admin in database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:admins,email',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'password'       => 'required|string|min:6|confirmed',
            'role_id'        => 'required|in:1,2',
        ]);

        $role = $request->role_id == 1 ? 'super_admin' : 'admin';

        Admin::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'account_number' => $request->account_number,
            'password'       => Hash::make($request->password),
            'role_id'        => $request->role_id,
            'role'           => $role,
            'is_active'      => true,
        ]);

        // Redirect to the index page is better after creation
        return redirect()->route('admin.manage_admins.index')->with('success', 'New admin created successfully!');
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        return view('admin.manage_admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id), // Ignore self on email check
            ],
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'password'       => 'nullable|string|min:6|confirmed', // Nullable on update
            'role_id'        => 'nullable|in:1,2', // Nullable in case it's disabled
            'is_active'      => 'nullable|in:0,1', // Nullable in case it's disabled
        ]);

        $data = $request->only('name', 'email', 'phone', 'address', 'account_number');

        // Only update password if a new one was entered
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle role update (but not for admin ID 1)
        if ($admin->id != 1 && $request->has('role_id')) {
            $data['role_id'] = $request->role_id;
            $data['role'] = $request->role_id == 1 ? 'super_admin' : 'admin';
        }

        // Handle status update (but not for admin ID 1 or self)
        if ($admin->id != 1 && $admin->id != auth('admin')->id() && $request->has('is_active')) {
            $data['is_active'] = $request->is_active;
        }

        $admin->update($data);

        return redirect()->route('admin.manage_admins.index')->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin)
    {
        // Safety check: cannot delete main super admin
        if ($admin->id == 1) {
            return redirect()->route('admin.manage_admins.index')->with('error', 'Cannot delete the main super admin.');
        }

        // Safety check: cannot delete self
        if ($admin->id == auth('admin')->id()) {
            return redirect()->route('admin.manage_admins.index')->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return redirect()->route('admin.manage_admins.index')->with('success', 'Admin deleted successfully.');
    }
}