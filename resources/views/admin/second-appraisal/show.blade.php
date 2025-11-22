@extends('admin.layouts.app')

@section('title', 'Second Appraisal Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-14">

            <div class="card border-0 shadow-lg rounded-4">
                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1 text-primary fw-bold">
                            <i class="ri-file-list-3-line align-middle me-1"></i> Appraisal Details
                        </h4>
                        <p class="text-muted mb-0 small">View details for Gold Loan Account: <strong>{{ $appraisal->gold_loan_account_no }}</strong></p>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.second-appraisal.index') }}" class="btn btn-light btn-sm border">
                            <i class="ri-arrow-left-line align-middle"></i> Back
                        </a>
                        <a href="{{ route('admin.second-appraisal.download', $appraisal->id) }}" class="btn btn-primary btn-sm shadow-sm">
                            <i class="ri-file-download-line align-middle me-1"></i> Download PDF
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- SECTION 1: Loan Information --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-light rounded-circle p-2 text-primary">
                            <i class="ri-file-info-line fs-5"></i>
                        </div>
                        <h6 class="fw-bold mb-0 ms-2 text-dark">Loan Information</h6>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Gold Loan A/C</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->gold_loan_account_no }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Ledger Folio No</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->ledger_folio_no }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Appraisal Date</p>
                            <h6 class="text-dark fw-bold">
                                <i class="ri-calendar-event-line align-middle text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($appraisal->second_appraisal_date)->format('d M, Y') }}
                            </h6>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    {{-- SECTION 2: Bank Details --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-light rounded-circle p-2 text-primary">
                            <i class="ri-bank-line fs-5"></i>
                        </div>
                        <h6 class="fw-bold mb-0 ms-2 text-dark">Bank & Branch Details</h6>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Bank Name</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->bank->bank ?? 'N/A' }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Branch Address</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->branch->branch_address ?? 'N/A' }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Branch Code</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->branch_code ?? '-' }}</h6>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    {{-- SECTION 3: Officers & Personnel --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-light rounded-circle p-2 text-primary">
                            <i class="ri-shield-user-line fs-5"></i>
                        </div>
                        <h6 class="fw-bold mb-0 ms-2 text-dark">Authorized Personnel</h6>
                    </div>

                    <div class="row g-4">
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">In Presence Of</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->in_present_of ?? 'N/A' }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Cash Incharge</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->cash_incharge ?? 'N/A' }}</h6>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <p class="text-uppercase text-muted fs-11 fw-bold mb-1">Joint Custody Officer</p>
                            <h6 class="text-dark fw-bold">{{ $appraisal->joint_custody_officer ?? 'N/A' }}</h6>
                        </div>
                    </div>

                </div> {{-- End Body --}}
                
                <div class="card-footer bg-light border-top p-3">
                    <small class="text-muted">
                        <i class="ri-information-line align-middle"></i> Record created on {{ $appraisal->created_at->format('d M, Y h:i A') }}
                    </small>
                </div>

            </div> {{-- End Card --}}
        </div>
    </div>
</div>
@endsection