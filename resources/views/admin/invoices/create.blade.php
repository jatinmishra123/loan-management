@extends('admin.layouts.app')

@section('title', 'Add Invoice')

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="card-title mb-0">➕ Add Invoice</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.invoices.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        {{-- Customer --}}
                        <div class="col-md-12">
                            <label for="customer_id" class="form-label fw-bold">Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id"
                                    class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->brauser_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Invoice No --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Invoice No <span class="text-danger">*</span></label>
                            <input type="text" id="invoice_no" name="invoice_no"
                                   value="{{ old('invoice_no', $generatedInvoiceNo ?? '') }}"
                                   class="form-control @error('invoice_no') is-invalid @enderror" readonly>
                            @error('invoice_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Invoice Date --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Invoice Date <span class="text-danger">*</span></label>
                            <input type="date" id="invoice_date" name="invoice_date"
                                   value="{{ old('invoice_date', date('Y-m-d')) }}"
                                   class="form-control @error('invoice_date') is-invalid @enderror" required>
                            @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Amount --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_amount"
                                   value="{{ old('total_amount') }}"
                                   class="form-control @error('total_amount') is-invalid @enderror"
                                   placeholder="0.00" required>
                            @error('total_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Unit (Optional Field — if needed, kept correctly) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit (Optional)</label>
                            <input type="number" step="0.01" name="unit"
                                   value="{{ old('unit') }}"
                                   class="form-control @error('unit') is-invalid @enderror"
                                   placeholder="Enter unit">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Amount in Words --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Amount in Words</label>
                            <input type="text" name="amount_in_words"
                                   value="{{ old('amount_in_words') }}"
                                   class="form-control @error('amount_in_words') is-invalid @enderror"
                                   placeholder="Enter amount in words">
                            @error('amount_in_words')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Round Off --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Round Off</label>
                            <input type="number" step="0.01" name="round_off"
                                   value="{{ old('round_off') }}"
                                   class="form-control @error('round_off') is-invalid @enderror">
                            @error('round_off')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Udayam Number (company_pan) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Udayam Number</label>
                            <input type="text" name="company_pan"
                                   value="{{ old('company_pan') }}"
                                   class="form-control @error('company_pan') is-invalid @enderror"
                                   placeholder="Enter Udayam Number">
                            @error('company_pan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bank Account No --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bank Account No</label>
                            <input type="text" name="bank_account_no"
                                   value="{{ old('bank_account_no') }}"
                                   class="form-control @error('bank_account_no') is-invalid @enderror"
                                   placeholder="Enter account number">
                            @error('bank_account_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bank Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bank Name</label>
                            <input type="text" name="bank_name"
                                   value="{{ old('bank_name') }}"
                                   class="form-control @error('bank_name') is-invalid @enderror"
                                   placeholder="Enter bank name">
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- IFSC Code --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">IFSC Code</label>
                            <input type="text" name="ifsc_code"
                                   value="{{ old('ifsc_code') }}"
                                   class="form-control @error('ifsc_code') is-invalid @enderror"
                                   placeholder="Enter IFSC code">
                            @error('ifsc_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Save Invoice</button>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
