@extends('admin.layouts.app')

@section('title', 'Edit Agent')

@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">✏️ Edit Agent</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.agent.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Row 1: Bank & Branch --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Bank <span class="text-danger">*</span></label>
                    <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror" id="bankDropdown" required>
                        <option value="">Select Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ $agent->bank_id == $bank->id ? 'selected' : '' }}>
                                {{ $bank->bank }}
                            </option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Branch <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" id="branchDropdown" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $agent->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_address }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Row 2: Mobile & WhatsApp --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
                    <input type="tel" 
                        name="mobile_number" 
                        class="form-control @error('mobile_number') is-invalid @enderror"
                        value="{{ old('mobile_number', $agent->mobile_number) }}"
                        pattern="[0-9]{10}" maxlength="10"
                        placeholder="Enter mobile number" required>
                    @error('mobile_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Number</label>
                    <input type="tel" 
                        name="whatsapp_number"
                        class="form-control @error('whatsapp_number') is-invalid @enderror"
                        value="{{ old('whatsapp_number', $agent->whatsapp_number) }}"
                        pattern="[0-9]{10}" maxlength="10"
                        placeholder="Enter WhatsApp number (optional)">
                    @error('whatsapp_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Row 3: Designation & Name --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Designation <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="designation" 
                           value="{{ old('designation', $agent->designation) }}"
                           class="form-control @error('designation') is-invalid @enderror"
                           placeholder="Enter designation" required>
                    @error('designation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $agent->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter name" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Row 4: Email & Password --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $agent->email) }}"
                           placeholder="Enter email" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Leave blank to keep current password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Row 5: Image & Status --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Profile Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if($agent->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $agent->image) }}" width="90" height="90" class="rounded border">
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ $agent->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$agent->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">Update Agent</button>
                <a href="{{ route('admin.agent.index') }}" class="btn btn-light">Cancel</a>
            </div>

        </form>
    </div>
</div>

{{-- AJAX: Load Branches for Selected Bank --}}
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
