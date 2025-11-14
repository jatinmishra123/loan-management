@extends('admin.layouts.app')

@section('title', 'Add Agent')

@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">➕ Add Agent</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.agent.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Row 1: Bank + Branch --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Bank <span class="text-danger">*</span></label>
                    <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror" id="bankDropdown" required>
                        <option value="">Select Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->bank }}</option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Branch <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" id="branchDropdown" required>
                        <option value="">Select Branch</option>
                    </select>
                    @error('branch_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Row 2: Designation + Name --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Designation <span class="text-danger">*</span></label>
                    <input type="text" name="designation"
                           value="{{ old('designation') }}"
                           class="form-control @error('designation') is-invalid @enderror"
                           placeholder="Enter designation..." required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter name..." required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Row 3: Mobile + WhatsApp --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
                    <input type="tel" name="mobile_number"
                           value="{{ old('mobile_number') }}"
                           class="form-control @error('mobile_number') is-invalid @enderror"
                           pattern="[0-9]{10}" maxlength="10"
                           placeholder="Enter 10-digit number" required>
                    @error('mobile_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Number</label>
                    <input type="tel" name="whatsapp_number"
                           value="{{ old('whatsapp_number') }}"
                           class="form-control @error('whatsapp_number') is-invalid @enderror"
                           pattern="[0-9]{10}" maxlength="10"
                           placeholder="Enter WhatsApp number (optional)">
                    @error('whatsapp_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Row 4: Email & Password --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Enter email..." required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter password..." required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Row 5: Image + Status --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Profile Image</label>
                    <input type="file" name="image"
                           class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">Save Agent</button>
                <a href="{{ route('admin.agent.index') }}" class="btn btn-light">Cancel</a>
            </div>

        </form>
    </div>
</div>

{{-- Branch Dropdown Loader --}}
<script>
    document.getElementById('bankDropdown').addEventListener('change', function () {
        let bankId = this.value;
        let branchDropdown = document.getElementById('branchDropdown');

        if (!bankId) {
            branchDropdown.innerHTML = '<option value="">Select Branch</option>';
            return;
        }

        branchDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/admin/branches-by-bank/${bankId}`)
            .then(res => res.json())
            .then(data => {
                branchDropdown.innerHTML = '<option value="">Select Branch</option>';
                data.forEach(branch => {
                    branchDropdown.innerHTML += `<option value="${branch.id}">${branch.branch_address}</option>`;
                });
            });
    });
</script>

@endsection
