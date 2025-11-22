@extends('admin.layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Edit Customer: {{ $customer->brauser_name }}</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3 text-primary">Personal Details</h5>

                    <div class="row">

                        {{-- Borrower Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Borrower Name</label>
                            <input type="text" class="form-control" name="brauser_name"
                                   value="{{ old('brauser_name', $customer->brauser_name) }}" required>
                        </div>

                        {{-- Relative Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Relative / Father Name</label>
                            <input type="text" class="form-control" name="ralative_name"
                                   value="{{ old('ralative_name', $customer->ralative_name) }}" required>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address"
                                   value="{{ old('address', $customer->address) }}" required>
                        </div>

                        {{-- Alternate Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Alternative Address</label>
                            <textarea class="form-control" name="alter_address" rows="2">{{ old('alter_address', $customer->alter_address) }}</textarea>
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
                                    <option value="{{ $bank->id }}" {{ old('bank_id', $customer->bank_id) == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Branch --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" class="form-select" id="branchDropdown"
                                    required data-selected="{{ old('branch_id', $customer->branch_id) }}">
                                <option value="">Select Branch</option>
                            </select>
                        </div>

                        {{-- Cash Officer --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cash Officer Name</label>
                            <input type="text" class="form-control" id="cash_incharge" name="cash_incharge"
                                   value="{{ old('cash_incharge', $customer->cash_incharge) }}" required readonly>
                        </div>

                    </div>

                    <div class="row">

                        {{-- Appraiser Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Appraiser A/C Number</label>
                            <input type="number" class="form-control" name="account_number"
                                   value="{{ old('account_number', $customer->account_number) }}" required>
                        </div>

                        {{-- Loan Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Loan A/C Number</label>
                            <input type="number" class="form-control" name="loan_number"
                                   value="{{ old('loan_number', $customer->loan_number) }}" required>
                        </div>

                        {{-- Saving Account --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Saving A/C Number</label>
                            <input type="number" class="form-control" name="saving_number"
                                   value="{{ old('saving_number', $customer->saving_number) }}" required>
                        </div>

                    </div>

                    <div class="row">

                        {{-- Date --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Appraisal Date</label>
                            <input type="date" class="form-control" name="date"
                                   value="{{ old('date', $customer->date) }}" required>
                        </div>

                        {{-- Packet No --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Packet / Ledger Number</label>
                            <input type="text" class="form-control" name="ladger_number"
                                   value="{{ old('ladger_number', $customer->ladger_number) }}" required>
                        </div>

                        {{-- Tenure --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tenure (Days)</label>
                            <input type="number" class="form-control" name="tenure_days"
                                   value="{{ old('tenure_days', $customer->tenure_days) }}">
                        </div>

                    </div>

                    <hr class="my-3">

                    <div class="row">

                        {{-- Paid Status --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="paid">
                                <option value="0" {{ old('paid', $customer->paid) == '0' ? 'selected' : '' }}>Paid</option>
                                <option value="1" {{ old('paid', $customer->paid) == '1' ? 'selected' : '' }}>Unpaid</option>
                                <option value="2" {{ old('paid', $customer->paid) == '2' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        {{-- Active/Inactive --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Account Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" {{ old('is_active', $customer->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $customer->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        {{-- Additional Cash Officer --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Addt. Cash Incharge</label>
                            <input type="text" class="form-control" name="cash_incharge_additional"
                                   value="{{ old('cash_incharge_additional', $customer->cash_incharge_additional) }}">
                        </div>

                        {{-- Remarks --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Customer Remarks</label>
                            <textarea class="form-control" name="customer_remarks" rows="3">{{ old('customer_remarks', $customer->customer_remarks) }}</textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        function loadBranches(bankId, selectedBranchId = null) {
            let branchDropdown = document.getElementById('branchDropdown');

            if (!bankId) {
                branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                return;
            }

            branchDropdown.innerHTML = '<option>Loading...</option>';

            fetch(`/admin/branches-by-bank/${bankId}`)
                .then(res => res.json())
                .then(data => {
                    branchDropdown.innerHTML = '<option value="">Select Branch</option>';

                    data.forEach(branch => {
                        let isSelected = (selectedBranchId == branch.id) ? 'selected' : '';

                        let option = `<option value="${branch.id}" data-cash="${branch.cash_incharge}" ${isSelected}>
                                        ${branch.branch_address}
                                      </option>`;

                        branchDropdown.insertAdjacentHTML('beforeend', option);
                    });
                })
                .catch(() => {
                    branchDropdown.innerHTML = '<option value="">Error loading branches</option>';
                });
        }

        // Load branches on page load
        let initialBankId = document.getElementById('bankDropdown').value;
        let initialBranchId = document.getElementById('branchDropdown').dataset.selected;

        if (initialBankId) {
            loadBranches(initialBankId, initialBranchId);
        }

        // When bank changes
        document.getElementById('bankDropdown').addEventListener('change', function() {
            loadBranches(this.value);
            document.getElementById('cash_incharge').value = "";
        });

        // Auto-fill cash officer
        document.getElementById('branchDropdown').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            document.getElementById('cash_incharge').value = selected.getAttribute('data-cash') || '';
        });

    });
</script>

@endsection
