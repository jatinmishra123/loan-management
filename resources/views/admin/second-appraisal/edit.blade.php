@extends('admin.layouts.app')

@section('title', 'Edit Second Appraisal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-14">

            <div class="card border-0 shadow-lg rounded-4">
                {{-- Card Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1 text-primary fw-bold">
                                <i class="ri-edit-box-line align-middle me-1"></i> Edit Second Appraisal
                            </h4>
                            <p class="text-muted mb-0 small">Update the details for gold loan account: <strong>{{ $appraisal->gold_loan_account_no }}</strong></p>
                        </div>
                        <a href="{{ route('admin.second-appraisal.index') }}" class="btn btn-sm btn-light border">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('admin.second-appraisal.update', $appraisal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- SECTION 1: LOAN DETAILS --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Loan & Date Details</h6>
                        <div class="row g-3 mb-4">
                            {{-- Gold Loan A/C --}}
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label fw-semibold">Gold Loan Account No</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-file-list-3-line"></i></span>
                                    <input type="text" class="form-control" name="gold_loan_account_no" 
                                           value="{{ $appraisal->gold_loan_account_no }}" required>
                                </div>
                            </div>

                            {{-- Ledger --}}
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label fw-semibold">Ledger Folio Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-book-read-line"></i></span>
                                    <input type="text" class="form-control" name="ledger_folio_no" 
                                           value="{{ $appraisal->ledger_folio_no }}" required>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-md-12 col-lg-4">
                                <label class="form-label fw-semibold">Date of Appraisal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-calendar-event-line"></i></span>
                                    <input type="date" class="form-control" name="second_appraisal_date" 
                                           value="{{ $appraisal->second_appraisal_date }}" required>
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        {{-- SECTION 2: BANK DETAILS --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Bank Information</h6>
                        <div class="row g-3 mb-4">
                            {{-- Bank --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Bank</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-bank-line"></i></span>
                                    <select name="bank_id" class="form-select" required>
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $b)
                                            <option value="{{ $b->id }}" {{ $b->id == $appraisal->bank_id ? 'selected' : '' }}>
                                                {{ $b->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Branch --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Branch</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-git-branch-line"></i></span>
                                    {{-- Note: Ideally pass $branches from controller instead of Branch::all() in view --}}
                                    <select name="branch_id" class="form-select" required>
                                        <option value="">Select Branch</option>
                                        @foreach(App\Models\Branch::all() as $br)
                                            <option value="{{ $br->id }}" {{ $br->id == $appraisal->branch_id ? 'selected' : '' }}>
                                                {{ $br->branch_address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Branch Code --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Branch Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-barcode-line"></i></span>
                                    <input type="text" class="form-control" name="branch_code" 
                                           value="{{ $appraisal->branch_code }}">
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        {{-- SECTION 3: APPRAISER INFO --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Appraiser & Personnel</h6>
                        <div class="row g-3">
                            
                            {{-- First Appraisal Name Address --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Name & Address of First Appraiser</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-map-pin-user-line"></i></span>
                                    <textarea class="form-control" name="name_address_first_appraisal" rows="2" required>{{ $appraisal->name_address_first_appraisal }}</textarea>
                                </div>
                            </div>

                            {{-- Present Of --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">In Presence Of</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-group-line"></i></span>
                                    <input type="text" class="form-control" name="in_present_of" 
                                           value="{{ $appraisal->in_present_of }}">
                                </div>
                            </div>

                            {{-- Cash Incharge --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Cash Incharge</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-user-star-line"></i></span>
                                    <input type="text" class="form-control" name="cash_incharge" 
                                           value="{{ $appraisal->cash_incharge }}">
                                </div>
                            </div>

                            {{-- Joint Officer --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Joint Custody Officer</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-shield-user-line"></i></span>
                                    <input type="text" class="form-control" name="joint_custody_officer" 
                                           value="{{ $appraisal->joint_custody_officer }}">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('admin.second-appraisal.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line align-middle me-1"></i> Update Record
                            </button>
                        </div>

                    </form>

                </div> {{-- End Card Body --}}
            </div> {{-- End Card --}}

        </div>
    </div>
</div>
@endsection