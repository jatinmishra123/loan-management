@extends('admin.layouts.app')

@section('title', 'Edit Bank')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 offset-lg-1">
        <div class="card shadow-sm border-0">

            {{-- Header --}}
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">✏️ Edit Bank</h4>
                <a href="{{ route('admin.bank.index') }}" class="btn btn-light btn-sm">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body">
                <form action="{{ route('admin.bank.update', $bank->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Row 1: Bank Name + Address --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🏦 Bank Name</label>
                            <input type="text" 
                                   name="bank" 
                                   value="{{ old('bank', $bank->bank) }}"
                                   class="form-control @error('bank') is-invalid @enderror" 
                                   placeholder="Enter bank name" required>
                            @error('bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">📍 Address</label>
                            <input type="text" 
                                   name="address"
                                   value="{{ old('address', $bank->address) }}"
                                   class="form-control @error('address') is-invalid @enderror" 
                                   placeholder="Enter address" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Row 2: Bank Code + Status --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🔢 Bank Code</label>
                            <input type="text" 
                                   name="bank_code"
                                   value="{{ old('bank_code', $bank->bank_code) }}"
                                   class="form-control @error('bank_code') is-invalid @enderror"
                                   placeholder="Enter bank code" required>
                            @error('bank_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">⚡ Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $bank->is_active ? 'selected' : '' }}>✅ Active</option>
                                <option value="0" {{ !$bank->is_active ? 'selected' : '' }}>❌ Inactive</option>
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Update Bank
                        </button>
                        <a href="{{ route('admin.bank.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection
