@extends('admin.layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                <h4 class="card-title mb-0">✏️ Edit Invoice</h4>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-light btn-sm">
                    <i class="ri-arrow-left-line me-1"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Customer --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id"
                                class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->brauser_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Invoice No --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Invoice No</label>
                            <input type="text" name="invoice_no"
                                class="form-control @error('invoice_no') is-invalid @enderror"
                                value="{{ old('invoice_no', $invoice->invoice_no) }}" readonly>
                            @error('invoice_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Invoice Date --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Invoice Date <span class="text-danger">*</span></label>
                            <input type="date" name="invoice_date"
                                class="form-control @error('invoice_date') is-invalid @enderror"
                                value="{{ old('invoice_date', $invoice->invoice_date) }}" required>
                            @error('invoice_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Total Amount --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_amount"
                                class="form-control @error('total_amount') is-invalid @enderror"
                                value="{{ old('total_amount', $invoice->total_amount) }}" required>
                            @error('total_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Unit (Optional) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit (Optional)</label>
                            <input type="number" step="0.01" name="unit"
                                class="form-control @error('unit') is-invalid @enderror"
                                value="{{ old('unit', $invoice->unit) }}">
                            @error('unit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount in Words --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Amount in Words</label>
                            <input type="text" name="amount_in_words"
                                class="form-control @error('amount_in_words') is-invalid @enderror"
                                value="{{ old('amount_in_words', $invoice->amount_in_words) }}"
                                placeholder="Enter amount in words">
                            @error('amount_in_words')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Round Off --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Round Off</label>
                            <input type="number" step="0.01" name="round_off"
                                class="form-control @error('round_off') is-invalid @enderror"
                                value="{{ old('round_off', $invoice->round_off) }}">
                            @error('round_off')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Udayam Number (Company PAN) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Udayam Number</label>
                            <input type="text" name="company_pan"
                                class="form-control @error('company_pan') is-invalid @enderror"
                                value="{{ old('company_pan', $invoice->company_pan) }}">
                            @error('company_pan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Bank Account No --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bank Account No</label>
                            <input type="text" name="bank_account_no"
                                class="form-control @error('bank_account_no') is-invalid @enderror"
                                value="{{ old('bank_account_no', $invoice->bank_account_no) }}">
                            @error('bank_account_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Bank Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bank Name</label>
                            <input type="text" name="bank_name"
                                class="form-control @error('bank_name') is-invalid @enderror"
                                value="{{ old('bank_name', $invoice->bank_name) }}">
                            @error('bank_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- IFSC Code --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">IFSC Code</label>
                            <input type="text" name="ifsc_code"
                                class="form-control @error('ifsc_code') is-invalid @enderror"
                                value="{{ old('ifsc_code', $invoice->ifsc_code) }}">
                            @error('ifsc_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-3-line me-1"></i> Update Invoice
                        </button>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-light">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
