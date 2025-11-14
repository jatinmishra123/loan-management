@extends('admin.layouts.app')

@section('title', 'Add Branch')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0">Add Branch</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.branch.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-6">

                                <!-- Bank -->
                                <div class="mb-3">
                                    <label class="form-label">Bank</label>
                                    <select name="bank_id" class="form-select" required>
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}"
                                                {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->bank }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('bank_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Cash Incharge -->
                                <div class="mb-3">
                                    <label class="form-label">Cash Incharge</label>
                                    <input type="text" name="cash_incharge" class="form-control"
                                           value="{{ old('cash_incharge') }}" required>

                                    @error('cash_incharge')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">

                                <!-- Branch Address -->
                                <div class="mb-3">
                                    <label class="form-label">Branch Address</label>
                                    <input type="text" name="branch_address" class="form-control"
                                           value="{{ old('branch_address') }}" required>

                                    @error('branch_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="is_active" class="form-select">
                                        <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('is_active')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success">Save Branch</button>
                            <a href="{{ route('admin.branch.index') }}" class="btn btn-light">Cancel</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
