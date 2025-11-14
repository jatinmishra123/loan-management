@extends('admin.layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Edit Customer</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Browser Name -->
                            <div class="col-md-6">
                                <label for="brauser_name" class="form-label">Browser Name</label>
                                <input type="text" name="brauser_name" id="brauser_name"
                                    class="form-control @error('brauser_name') is-invalid @enderror"
                                    value="{{ old('brauser_name', $customer->brauser_name) }}"
                                    placeholder="Enter browser name">
                                @error('brauser_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Relative Name -->
                            <div class="col-md-6">
                                <label for="ralative_name" class="form-label">Relative Name</label>
                                <input type="text" name="ralative_name" id="ralative_name"
                                    class="form-control @error('ralative_name') is-invalid @enderror"
                                    value="{{ old('ralative_name', $customer->ralative_name) }}"
                                    placeholder="Enter relative name">
                                @error('ralative_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $customer->address) }}" placeholder="Enter address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Appraiser Date -->
                            <div class="col-md-6">
                                <label for="date" class="form-label">Appraiser Date</label>
                                <input type="date" name="date" id="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date', $customer->date) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bank -->
                            <div class="col-md-3">
                                <label class="form-label">Bank</label>
                                <select name="bank_id" id="bankDropdown"
                                    class="form-select @error('bank_id') is-invalid @enderror" required>
                                    <option value="">Select Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ old('bank_id', $customer->bank_id) == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->bank }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bank_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Branch -->
                            <div class="col-md-3">
                                <label class="form-label">Branch</label>
                                <select name="branch_id" id="branchDropdown"
                                    class="form-select @error('branch_id') is-invalid @enderror" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', $customer->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->branch_address }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cash Officer -->
                            <div class="col-md-6">
                                <label for="cash_incharge" class="form-label">Cash Officer Name</label>
                                <input type="text" name="cash_incharge" id="cash_incharge"
                                    class="form-control @error('cash_incharge') is-invalid @enderror"
                                    value="{{ old('cash_incharge', $customer->cash_incharge) }}"
                                    placeholder="Enter cash officer name">
                                @error('cash_incharge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Account Number -->
                            <div class="col-md-6">
                                <label class="form-label">Appraiser Account Number</label>
                                <input type="text" name="account_number"
                                    class="form-control @error('account_number') is-invalid @enderror"
                                    value="{{ old('account_number', $customer->account_number) }}"
                                    placeholder="Enter appraiser account number">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Loan Account Number -->
                            <div class="col-md-6">
                                <label class="form-label">Loan Account Number</label>
                                <input type="text" name="loan_number"
                                    class="form-control @error('loan_number') is-invalid @enderror"
                                    value="{{ old('loan_number', $customer->loan_number) }}"
                                    placeholder="Enter loan account number">
                                @error('loan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Saving Account Number -->
                            <div class="col-md-6">
                                <label class="form-label">Saving Account Number</label>
                                <input type="text" name="saving_number"
                                    class="form-control @error('saving_number') is-invalid @enderror"
                                    value="{{ old('saving_number', $customer->saving_number) }}"
                                    placeholder="Enter saving account number">
                                @error('saving_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Packet (Ledger) Number -->
                            <div class="col-md-6">
                                <label class="form-label">Packet (Ledger) Number</label>
                                <input type="text" name="ladger_number"
                                    class="form-control @error('ladger_number') is-invalid @enderror"
                                    value="{{ old('ladger_number', $customer->ladger_number) }}"
                                    placeholder="Enter packet number">
                                @error('ladger_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Customer</button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Branch Loading -->
    <script>
        document.getElementById('bankDropdown').addEventListener('change', function () {
            const bankId = this.value;
            const branchDropdown = document.getElementById('branchDropdown');
            branchDropdown.innerHTML = '<option value="">Loading...</option>';

            if (bankId) {
                fetch(`/admin/branches/${bankId}`)
                    .then(res => res.json())
                    .then(data => {
                        branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                        data.forEach(branch => {
                            branchDropdown.innerHTML += `<option value="${branch.id}">${branch.branch}</option>`;
                        });
                    })
                    .catch(() => {
                        branchDropdown.innerHTML = '<option value="">Error loading branches</option>';
                    });
            } else {
                branchDropdown.innerHTML = '<option value="">Select Branch</option>';
            }
        });
    </script>
@endsection