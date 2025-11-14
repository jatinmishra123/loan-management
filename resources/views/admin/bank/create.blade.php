@extends('admin.layouts.app')

@section('title', 'Add New Bank')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0">Add New Bank</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.bank.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Bank Name --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bank" class="form-label fw-bold">Bank Name</label>
                                    <input type="text" 
                                           class="form-control @error('bank') is-invalid @enderror" 
                                           id="bank"
                                           name="bank" 
                                           value="{{ old('bank') }}" 
                                           placeholder="Enter bank name" 
                                           required>
                                    @error('bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                    <input type="text" 
                                           class="form-control @error('address') is-invalid @enderror"
                                           id="address" 
                                           name="address" 
                                           value="{{ old('address') }}"
                                           placeholder="Enter bank address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Bank Code --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bank_code" class="form-label fw-bold">Bank Code</label>
                                    <input type="text" 
                                           class="form-control @error('bank_code') is-invalid @enderror"
                                           id="bank_code" 
                                           name="bank_code" 
                                           value="{{ old('bank_code') }}"
                                           placeholder="Enter bank code" 
                                           required>
                                    @error('bank_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label fw-bold">Status</label>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Bank</button>
                            <a href="{{ route('admin.bank.index') }}" class="btn btn-light">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
