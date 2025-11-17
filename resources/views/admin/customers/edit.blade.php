@extends('admin.layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Edit Customer: {{ $customer->brauser_name }}</h4>
                
                {{-- Check if this is a second appraisal to auto-select --}}
                @php
                    $isSecond = !empty($customer->ledger_folio_no) || !empty($customer->gold_loan_alc_no) || old('appraisalType') == 'second';
                @endphp

                <div>
                    <label class="me-2 fw-semibold">Appraisal Type:</label>
                    <select id="appraisalType" class="form-select form-select-sm d-inline-block w-auto">
                        <option value="first" {{ !$isSecond ? 'selected' : '' }}>First Appraisal</option>
                        <option value="second" {{ $isSecond ? 'selected' : '' }}>Second Appraisal</option>
                    </select>
                </div>
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
                            <label class="form-label">Alternative Address <span class="text-muted">(Optional)</span></label>
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

                        {{-- Branch (Populated via JS) --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" class="form-select" id="branchDropdown" required data-selected="{{ old('branch_id', $customer->branch_id) }}">
                                <option value="">Select Branch</option>
                                {{-- Initial load handled by JS or Controller passing $branches --}}
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

                        {{-- Packet Number --}}
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

                        {{-- Account Status --}}
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

                    {{-- Toggle visibility based on PHP logic --}}
                    <div id="secondAppraisalFields" class="{{ $isSecond ? '' : 'd-none' }} p-3 mb-3 bg-light border rounded">
                        <h6 class="text-secondary">Second Appraisal Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ledger Folio No</label>
                                <input type="text" class="form-control" name="ledger_folio_no" 
                                       value="{{ old('ledger_folio_no', $customer->ledger_folio_no) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gold Loan Alc No</label>
                                <input type="text" class="form-control" name="gold_loan_alc_no" 
                                       value="{{ old('gold_loan_alc_no', $customer->gold_loan_alc_no) }}">
                            </div>
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
        
        // --- 1. Define Function to Load Branches ---
        function loadBranches(bankId, selectedBranchId = null) {
            let branchDropdown = document.getElementById('branchDropdown');
            
            if(!bankId) {
                branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                return;
            }

            // Show loading state
            branchDropdown.innerHTML = '<option>Loading...</option>';

            fetch(`/admin/branches-by-bank/${bankId}`)
                .then(res => res.json())
                .then(data => {
                    branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                    
                    data.forEach(branch => {
                        let isSelected = (selectedBranchId == branch.id) ? 'selected' : '';
                        
                        let option = `<option value="${branch.id}" 
                                        data-cash="${branch.cash_incharge}" 
                                        ${isSelected}>
                                        ${branch.branch_address}
                                      </option>`;
                        branchDropdown.insertAdjacentHTML('beforeend', option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    branchDropdown.innerHTML = '<option value="">Error loading branches</option>';
                });
        }

        // --- 2. Trigger Load on Page Load (for Edit Mode) ---
        let initialBankId = document.getElementById('bankDropdown').value;
        let initialBranchId = document.getElementById('branchDropdown').getAttribute('data-selected');

        if(initialBankId) {
            loadBranches(initialBankId, initialBranchId);
        }

        // --- 3. Event Listener for Bank Change ---
        document.getElementById('bankDropdown').addEventListener('change', function () {
            loadBranches(this.value);
            document.getElementById('cash_incharge').value = ''; // Reset officer on bank change
        });

        // --- 4. Event Listener for Branch Change (Auto-fill Officer) ---
        document.getElementById('branchDropdown').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            let cashOfficer = selectedOption ? selectedOption.getAttribute('data-cash') : '';
            
            if (cashOfficer) {
                document.getElementById('cash_incharge').value = cashOfficer;
            }
        });

        // --- 5. Toggle Second Appraisal Fields ---
        document.getElementById('appraisalType').addEventListener('change', function () {
            const secondFields = document.getElementById('secondAppraisalFields');
            if (this.value === 'second') {
                secondFields.classList.remove('d-none');
            } else {
                secondFields.classList.add('d-none');
            }
        });
    });
</script>
@endsection