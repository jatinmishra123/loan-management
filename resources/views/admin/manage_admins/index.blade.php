@extends('admin.layouts.app')

@section('title', 'Manage Admins')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Admins</h4>
                    <a href="{{ route('admin.manage_admins.create') }}" class="btn btn-light btn-sm">
                        <i class="ri-add-line me-1"></i> Create New Admin
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop through $admins passed from the controller --}}
                                @forelse($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($admin->role == 'super_admin')
                                            <span class="badge bg-danger">{{ $admin->role }}</span>
                                        @else
                                            <span class="badge bg-info text-dark">{{ $admin->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($admin->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.manage_admins.edit', $admin->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        
                                        {{-- Prevent deleting the main super admin (ID 1) or self --}}
                                        @if($admin->id != 1 && $admin->id != auth('admin')->id())
                                            <form action="{{ route('admin.manage_admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No admins found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection