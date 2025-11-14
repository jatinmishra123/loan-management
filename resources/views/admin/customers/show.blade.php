@extends('admin.layouts.app')

@section('title', 'Customer Details - Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Customer Details</h4>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    <!-- 🧍‍♂️ Basic Info -->
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="row g-2 small">
                                <div class="col-4 fw-bold">Browser Name:</div>
                                <div class="col-8">{{ $customer->brauser_name ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Relative Name:</div>
                                <div class="col-8">{{ $customer->ralative_name ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Address:</div>
                                <div class="col-8">{{ $customer->address ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Appraiser Date:</div>
                                <div class="col-8">
                                    {{ $customer->date ? \Carbon\Carbon::parse($customer->date)->format('d M Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="row g-2 small">
                                <div class="col-4 fw-bold">Bank:</div>
                                <div class="col-8">{{ $customer->bank->bank ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Branch:</div>
                                <div class="col-8">{{ $customer->branch->branch_address ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Cash Officer:</div>
                                <div class="col-8">{{ $customer->cash_incharge ?? 'N/A' }}</div>

                                <div class="col-4 fw-bold">Status:</div>
                                <div class="col-8">
                                    <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                                        {{ $customer->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <div class="col-4 fw-bold">Created At:</div>
                                <div class="col-8">
                                    {{ $customer->created_at ? $customer->created_at->format('d M, Y h:i A') : 'N/A' }}
                                </div>

                                <div class="col-4 fw-bold">Updated At:</div>
                                <div class="col-8">
                                    {{ $customer->updated_at ? $customer->updated_at->format('d M, Y h:i A') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 💰 Account Information -->
                    <hr class="my-4">
                    <h6 class="fw-bold text-muted mb-3">Account Information</h6>
                    <div class="row g-3 small">
                        <div class="col-md-3">
                            <strong>Appraiser Account No:</strong>
                            <div>{{ $customer->account_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <strong>Loan Account No:</strong>
                            <div>{{ $customer->loan_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <strong>Saving Account No:</strong>
                            <div>{{ $customer->saving_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <strong>Packet (Ledger) Number:</strong>
                            <div>{{ $customer->ladger_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- ⚙️ Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                            <i class="ri-edit-line"></i> Edit Profile
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection