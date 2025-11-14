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
                    <div class="row">

                        {{-- Browser Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Browser Name</label>
                            <input type="text" class="form-control" name="brauser_name"
                            placeholder="Enter customer browser name" required>
                        </div>

                        {{-- Relative Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Relative Name</label>
                            <input type="text" class="form-control" name="ralative_name"
                            placeholder="Enter relative/father name" required>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address"
                            placeholder="Enter full address" required>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Appraiser Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>

                        {{-- Alternate Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Alternative Address</label>
                            <textarea class="form-control" name="alter_address" rows="3"
                            placeholder="Enter alternate address (optional)"></textarea>
                        </div>

                        {{-- Bank --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bank</label>
                            <select name="bank_id" class="form-select" id="bankDropdown" required>
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Branch --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" class="form-select" id="branchDropdown" required>
                                <option value="">Select Branch</option>
                            </select>
                        </div>

                        {{-- Cash Officer --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cash Officer Name</label>
                            <input type="text" class="form-control" id="cash_incharge" name="cash_incharge"
                            placeholder="Cash officer auto-filled when branch selected" required>
                        </div>

                        {{-- Account Numbers --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Appraiser Account Number</label>
                            <input type="number" class="form-control" name="account_number"
                            placeholder="Enter appraiser account number" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loan Account Number</label>
                            <input type="number" class="form-control" name="loan_number"
                            placeholder="Enter loan account number" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Saving Account Number</label>
                            <input type="number" class="form-control" name="saving_number"
                            placeholder="Enter saving account number" required>
                        </div>

                        {{-- Packet Number --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Packet Number</label>
                            <input type="text" class="form-control" name="ladger_number"
                            placeholder="Enter packet/ledger number" required>
                        </div>

                        {{-- Paid Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Paid Status</label>
                            <select class="form-select" name="paid">
                                <option value="0">Unpaid</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>

                        {{-- Tenure Days --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tenure (Days)</label>
                            <input type="number" class="form-control" name="tenure_days"
                            placeholder="Enter tenure days (optional)">
                        </div>

                        {{-- Second Appraisal Fields --}}
                        <div id="secondAppraisalFields" class="row d-none">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ledger Folio No</label>
                                <input type="text" class="form-control" name="ledger_folio_no"
                                placeholder="Enter ledger folio number">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gold Loan Alc No</label>
                                <input type="text" class="form-control" name="gold_loan_alc_no"
                                placeholder="Enter gold loan ALC number">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive (New)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Create Customer</button>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-light mt-3">Cancel</a>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- AJAX + APPRAISAL TOGGLE --}}
<script>

// 🔥 Load Branches (Admin-Wise)
document.getElementById('bankDropdown').addEventListener('change', function () {

    let bankId = this.value;
    let branchDropdown = document.getElementById('branchDropdown');

    branchDropdown.innerHTML = '<option>Loading...</option>';

    fetch(`/admin/branches-by-bank/${bankId}`)
        .then(res => res.json())
        .then(data => {
            branchDropdown.innerHTML = '<option value="">Select Branch</option>';

            data.forEach(branch => {
                branchDropdown.innerHTML += 
                    `<option value="${branch.id}" 
                        data-cash="${branch.cash_incharge}">
                        ${branch.branch_address}
                    </option>`;
            });
        });
});

// 🔥 Auto-fill CASH OFFICER
document.getElementById('branchDropdown').addEventListener('change', function () {
    let cash = this.options[this.selectedIndex].getAttribute('data-cash');
    if (cash) document.getElementById('cash_incharge').value = cash;
});

// 🔥 Appraisal Type Toggle
document.getElementById('appraisalType').addEventListener('change', function () {
    const secondFields = document.getElementById('secondAppraisalFields');
    secondFields.classList.toggle('d-none', this.value !== 'second');
});

</script>
@endsection
