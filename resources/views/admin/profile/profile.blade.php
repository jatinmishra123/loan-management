@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">My Profile</h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
                <i class="ri-arrow-left-line"></i> Back
            </a>
        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

<form action="{{ route('admin.profile.update') }}" method="POST">
               @csrf
@method('PUT')

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Account Number (Optional)</label>
                        <input type="text" name="account_number" 
                               value="{{ old('account_number', $admin->account_number) }}" 
                               class="form-control">
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">Change Password (Optional)</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="ri-save-line"></i> Save Changes
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
