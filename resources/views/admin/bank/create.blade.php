@extends('admin.layouts.app')

@section('title', 'Add New Bank')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-14">

            <div class="card border-0 shadow-lg rounded-4">
                
                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1 text-primary fw-bold">
                                <i class="ri-bank-line align-middle me-1"></i> Add New Bank
                            </h4>
                            <p class="text-muted mb-0 small">Enter the details of the banking institution.</p>
                        </div>
                        <a href="{{ route('admin.bank.index') }}" class="btn btn-sm btn-light border">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.bank.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            
                            {{-- Bank Name --}}
                            <div class="col-md-12">
                                <label for="bank" class="form-label fw-semibold">Bank Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-building-2-line"></i></span>
                                    <input type="text" 
                                           class="form-control @error('bank') is-invalid @enderror" 
                                           id="bank"
                                           name="bank" 
                                           value="{{ old('bank') }}" 
                                           placeholder="e.g. State Bank of India" 
                                           required>
                                    @error('bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bank Code --}}
                            <div class="col-md-6">
                                <label for="bank_code" class="form-label fw-semibold">Bank Code <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-barcode-line"></i></span>
                                    <input type="text" 
                                           class="form-control @error('bank_code') is-invalid @enderror"
                                           id="bank_code" 
                                           name="bank_code" 
                                           value="{{ old('bank_code') }}"
                                           placeholder="e.g. SBI001" 
                                           required>
                                    @error('bank_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- IFSC Code (NEW) --}}
                            <div class="col-md-6">
                                <label for="ifsc_code" class="form-label fw-semibold">IFSC Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-qr-code-line"></i></span>
                                    <input type="text" 
                                           class="form-control @error('ifsc_code') is-invalid @enderror"
                                           id="ifsc_code" 
                                           name="ifsc_code" 
                                           value="{{ old('ifsc_code') }}"
                                           placeholder="e.g. SBIN0001234"
                                           style="text-transform: uppercase;">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-map-pin-line"></i></span>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                           id="address" 
                                           name="address" 
                                           rows="2"
                                           placeholder="Enter full registered address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="is_active" class="form-label fw-semibold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-toggle-line"></i></span>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.bank.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line align-middle me-1"></i> Create Bank
                            </button>
                        </div>

                    </form>
                </div> {{-- End Card Body --}}
            </div> {{-- End Card --}}

        </div>
    </div>
</div>
@endsection