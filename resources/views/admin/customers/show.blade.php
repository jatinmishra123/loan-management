@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">

            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h4 class="card-title mb-0">
                    Customer Details: <span class="text-primary">{{ $customer->brauser_name }}</span>
                </h4>
                <div>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary btn-sm me-1">
                        <i class="ri-edit-line align-middle"></i> Edit
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ri-arrow-left-line align-middle"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                
                {{-- ========================= --}}
                {{-- Personal Details --}}
                {{-- ========================= --}}
                <h6 class="text-muted text-uppercase fw-semibold mb-3">Personal Information</h6>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Borrower Name</small>
                        <span class="fw-bold fs-6">{{ $customer->brauser_name ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Relative / Father Name</small>
                        <span class="fw-bold fs-6">{{ $customer->ralative_name ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Primary Address</small>
                        <span class="fw-medium">{{ $customer->address ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Alternative Address</small>
                        <span class="fw-medium">{{ $customer->alter_address ?? 'N/A' }}</span>
                    </div>
                </div>

                <hr class="text-muted opacity-25">


                {{-- ========================= --}}
                {{-- Bank Details --}}
                {{-- ========================= --}}
                <h6 class="text-muted text-uppercase fw-semibold mb-3">Bank & Account Details</h6>

                <div class="row g-4 mb-4">

                    <div class="col-md-3">
                        <small class="text-muted d-block">Bank Name</small>
                        <span class="fw-bold">{{ $customer->bank->bank ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Branch Address</small>
                        <span class="fw-bold">{{ $customer->branch->branch_address ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Cash Officer</small>
                        <span class="fw-bold text-dark">{{ $customer->cash_incharge ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Additional Cash Officer</small>
                        <span class="fw-medium">{{ $customer->cash_incharge_additional ?? 'N/A' }}</span>
                    </div>

                    {{-- Account Numbers --}}
                    <div class="col-md-4">
                        <div class="p-2 bg-light rounded border">
                            <small class="text-muted d-block">Appraiser A/C No.</small>
                            <span class="fw-bold text-primary">{{ $customer->account_number ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-2 bg-light rounded border">
                            <small class="text-muted d-block">Loan A/C No.</small>
                            <span class="fw-bold text-primary">{{ $customer->loan_number ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-2 bg-light rounded border">
                            <small class="text-muted d-block">Saving A/C No.</small>
                            <span class="fw-bold text-primary">{{ $customer->saving_number ?? '-' }}</span>
                        </div>
                    </div>

                </div>

                <hr class="text-muted opacity-25">


                {{-- ========================= --}}
                {{-- Appraisal + Status --}}
                {{-- ========================= --}}
                <h6 class="text-muted text-uppercase fw-semibold mb-3">Appraisal & Status</h6>

                <div class="row g-4 mb-4">

                    <div class="col-md-3">
                        <small class="text-muted d-block">Packet-Number</small>
                        <span class="fw-bold fs-5">{{ $customer->ladger_number ?? '-' }}</span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Appraisal Date</small>
                        <span class="fw-bold">
                            {{ $customer->date ? \Carbon\Carbon::parse($customer->date)->format('d M, Y') : '-' }}
                        </span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">Tenure</small>
                        <span class="fw-bold">{{ $customer->tenure_days ? $customer->tenure_days . ' Days' : 'N/A' }}</span>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <small class="text-muted d-block mb-1">Current Status</small>

                        <div class="d-flex gap-2">

                            {{-- Active / Inactive --}}
                            @if($customer->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif


                            {{-- Payment Status --}}
                            @php
                                $payClass = match((string)$customer->paid) {
                                    '0' => 'success',
                                    '1' => 'warning text-dark',
                                    '2' => 'danger',
                                    default => 'secondary'
                                };
                                $payLabel = match((string)$customer->paid) {
                                    '0' => 'Paid',
                                    '1' => 'Unpaid',
                                    '2' => 'Failed',
                                    default => 'Unknown'
                                };
                            @endphp

                            <span class="badge bg-{{ $payClass }}">{{ $payLabel }}</span>

                        </div>
                    </div>

                </div>


                {{-- Remarks --}}
                @if($customer->customer_remarks)
                    <div class="alert alert-light border mb-4">
                        <small class="text-muted fw-bold">Customer Remarks:</small>
                        <p class="mb-0 mt-1 text-dark">{{ $customer->customer_remarks }}</p>
                    </div>
                @endif

                {{-- 🟥 SECOND APPRAISAL SECTION REMOVED COMPLETELY --}}
                {{-- No ledger_folio_no --}}
                {{-- No gold_loan_alc_no --}}

            </div>

            <div class="card-footer bg-light small text-muted d-flex justify-content-between">
                <span>Created: {{ $customer->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</span>
                <span>Last Updated: {{ $customer->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}</span>
            </div>

        </div>
    </div>
</div>
@endsection
