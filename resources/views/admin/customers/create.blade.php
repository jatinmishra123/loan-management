@extends('admin.layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Add New Customer</h4>
                <div>
                    <label class="me-2 fw-semibold">Appraisal Type:</label>
                    <select id="appraisalType" class="form-select form-select-sm d-inline-block w-auto">
                        <option value="first" selected>First Appraisal</option>
                        <option value="second">Second Appraisal</option>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    
                    <h5 class="mb-3 text-primary">Personal Details</h5>
                    <div class="row">
                        {{-- Borrower Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Borrower Name</label>
                            <input type="text" class="form-control" name="brauser_name" placeholder="Enter customer name" required>
                        </div>

                        {{-- Relative Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Relative / Father Name</label>
                            <input type="text" class="form-control" name="ralative_name" placeholder="Enter relative name" required>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter full address" required>
                        </div>

                        {{-- Alternate Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Alternative Address <span class="text-muted">(Optional)</span></label>
                            <textarea class="form-control" name="alter_address" rows="2" placeholder="Enter alternate address"></textarea>
                        </div>
                    </div>

                    <hr class="my-3">

                    <h5 class="mb-3 text-primary">Bank & Account Details</h5>
                    <div class="row">
                        {{-- Bank --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bank</label>
                            <select name="bank_id" class="form-select" id="bankDropdown" required>
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Branch --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" class="form-select" id="branchDropdown" required>
                                <option value="">Select Branch</option>
                            </select>
                        </div>

                        {{-- Cash Officer --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cash Officer Name</label>
                            <input type="text" class="form-control" id="cash_incharge" name="cash_incharge" placeholder="Auto-filled on branch selection" required readonly>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Appraiser Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Appraiser A/C Number</label>
                            <input type="number" class="form-control" name="account_number" placeholder="Enter appraiser A/C" required>
                        </div>

                        {{-- Loan Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Loan A/C Number</label>
                            <input type="number" class="form-control" name="loan_number" placeholder="Enter loan A/C" required>
                        </div>

                        {{-- Saving Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Saving A/C Number</label>
                            <input type="number" class="form-control" name="saving_number" placeholder="Enter saving A/C" required>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Date --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Appraisal Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>

                        {{-- Packet Number --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Packet / Ledger Number</label>
                            <input type="text" class="form-control" name="ladger_number" placeholder="Enter packet no." required>
                        </div>

                        {{-- Tenure --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tenure (Days)</label>
                            <input type="number" class="form-control" name="tenure_days" placeholder="e.g. 30">
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        {{-- Paid Status --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="paid">
                                <option value="0">Paid</option>
                                <option value="1">Unpaid</option>
                                <option value="2">Failed</option>
                            </select>
                        </div>

                        {{-- Account Status --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Account Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- Additional Cash Officer --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Addt. Cash Incharge</label>
                            <input type="text" class="form-control" name="cash_incharge_additional" placeholder="Optional">
                        </div>

                        {{-- Remarks --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Customer Remarks</label>
                            <textarea class="form-control" name="customer_remarks" rows="3" placeholder="Enter any notes..."></textarea>
                        </div>
                    </div>

                    <div id="secondAppraisalFields" class="d-none p-3 mb-3 bg-light border rounded">
                        <h6 class="text-secondary">Second Appraisal Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ledger Folio No</label>
                                <input type="text" class="form-control" name="ledger_folio_no" placeholder="Enter ledger folio">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gold Loan Alc No</label>
                                <input type="text" class="form-control" name="gold_loan_alc_no" placeholder="Enter gold loan ALC">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary">Create Customer</button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div> </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    // 1. Load Branches based on Bank Selection
    document.getElementById('bankDropdown').addEventListener('change', function () {
        let bankId = this.value;
        let branchDropdown = document.getElementById('branchDropdown');

        // Reset Dropdown
        branchDropdown.innerHTML = '<option>Loading...</option>';
        document.getElementById('cash_incharge').value = ''; // Reset officer

        if(bankId) {
            fetch(`/admin/branches-by-bank/${bankId}`)
                .then(res => res.json())
                .then(data => {
                    branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                    data.forEach(branch => {
                        // Store cash officer name in a data attribute
                        let option = document.createElement('option');
                        option.value = branch.id;
                        option.text = branch.branch_address;
                        option.setAttribute('data-cash', branch.cash_incharge);
                        branchDropdown.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    branchDropdown.innerHTML = '<option value="">Error loading branches</option>';
                });
        } else {
            branchDropdown.innerHTML = '<option value="">Select Branch</option>';
        }
    });

    // 2. Auto-fill Cash Officer from Branch Data
    document.getElementById('branchDropdown').addEventListener('change', function () {
        let selectedOption = this.options[this.selectedIndex];
        let cashOfficer = selectedOption.getAttribute('data-cash');
        
        if (cashOfficer) {
            document.getElementById('cash_incharge').value = cashOfficer;
        } else {
            document.getElementById('cash_incharge').value = '';
        }
    });

    // 3. Toggle Second Appraisal Fields
    document.getElementById('appraisalType').addEventListener('change', function () {
        const secondFields = document.getElementById('secondAppraisalFields');
        if (this.value === 'second') {
            secondFields.classList.remove('d-none');
        } else {
            secondFields.classList.add('d-none');
        }
    });
</script>
@endsection