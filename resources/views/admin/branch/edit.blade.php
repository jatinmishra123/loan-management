@extends('admin.layouts.app')

@section('title', 'Edit Branch')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">

                {{-- Card Header --}}
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">✏️ Edit Branch</h4>
                    <a href="{{ route('admin.branch.index') }}" class="btn btn-light btn-sm">
                        <i class="ti ti-arrow-left"></i> Back
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <form action="{{ route('admin.branch.update', $branch->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Row 1: Select Bank + Branch Address --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">🏦 Select Bank</label>
                                <select name="bank_id" class="form-select" required>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}" 
                                            {{ $branch->bank_id == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->bank }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bank_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">📍 Branch Address</label>
                                <input type="text" name="branch_address"
                                    value="{{ old('branch_address', $branch->branch_address) }}"
                                    class="form-control @error('branch_address') is-invalid @enderror"
                                    placeholder="Enter Branch Address" required>
                                @error('branch_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 2: Cash Incharge + Status --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">👨‍💼 Cash Incharge</label>
                                <input type="text" name="cash_incharge"
                                    value="{{ old('cash_incharge', $branch->cash_incharge) }}"
                                    class="form-control @error('cash_incharge') is-invalid @enderror"
                                    placeholder="Enter Cash Incharge Name" required>
                                @error('cash_incharge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">⚡ Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ $branch->is_active ? 'selected' : '' }}>✅ Active</option>
                                    <option value="0" {{ !$branch->is_active ? 'selected' : '' }}>❌ Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-device-floppy"></i> Update Branch
                            </button>
                            <a href="{{ route('admin.branch.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-x"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
