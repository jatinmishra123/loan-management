@extends('admin.layouts.app')

@section('title', 'Edit Branch')

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
                                <i class="ri-edit-box-line align-middle me-1"></i> Edit Branch
                            </h4>
                            <p class="text-muted mb-0 small">Update details for branch ID: <strong>#{{ $branch->id }}</strong></p>
                        </div>
                        <a href="{{ route('admin.branch.index') }}" class="btn btn-sm btn-light border">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.branch.update', $branch->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Bank Selection --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-bank-line"></i></span>
                                    <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror" required>
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank_id', $branch->bank_id) == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Branch Email (New Field) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Branch Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-mail-line"></i></span>
                                    <input type="email" 
                                           name="branch_email" 
                                           class="form-control @error('branch_email') is-invalid @enderror"
                                           value="{{ old('branch_email', $branch->branch_email ?? '') }}" 
                                           placeholder="e.g. branch@bank.com">
                                    @error('branch_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cash Incharge --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Cash Incharge <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-user-star-line"></i></span>
                                    <input type="text" 
                                           name="cash_incharge" 
                                           class="form-control @error('cash_incharge') is-invalid @enderror"
                                           value="{{ old('cash_incharge', $branch->cash_incharge) }}" 
                                           placeholder="Name of person in charge" 
                                           required>
                                    @error('cash_incharge')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-toggle-line"></i></span>
                                    <select name="is_active" class="form-select">
                                        <option value="1" {{ old('is_active', $branch->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $branch->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Branch Address --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Branch Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-map-pin-line"></i></span>
                                    <textarea name="branch_address" 
                                              class="form-control @error('branch_address') is-invalid @enderror" 
                                              rows="2" 
                                              placeholder="Enter full branch address" 
                                              required>{{ old('branch_address', $branch->branch_address) }}</textarea>
                                    @error('branch_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.branch.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line align-middle me-1"></i> Update Branch
                            </button>
                        </div>

                    </form>
                </div> {{-- End Card Body --}}
            </div> {{-- End Card --}}

        </div>
    </div>
</div>
@endsection