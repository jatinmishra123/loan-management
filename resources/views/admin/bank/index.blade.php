@extends('admin.layouts.app')

@section('title', 'Banks List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Success Message --}}
            @if(session('success'))
                <div id="flash-message" class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="ri-checkbox-circle-line align-middle me-2 fs-5"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4">
                
                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="row align-items-center gy-2">
                        <div class="col-md-4">
                            <h5 class="card-title mb-0 text-primary fw-bold">
                                <i class="ri-bank-line align-middle me-1"></i> Banks List
                            </h5>
                            <p class="text-muted mb-0 small mt-1">Manage all registered banking institutions.</p>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-md-end gap-2 align-items-center">
                                {{-- Search (Visual only) --}}
                                <div class="input-group d-none d-sm-flex" style="max-width: 250px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                                    <input type="text" id="tableSearch" class="form-control bg-light border-start-0" placeholder="Search banks...">
                                </div>

                                <a href="{{ route('admin.bank.create') }}" class="btn btn-primary shadow-sm">
                                    <i class="ri-add-circle-line align-middle me-1"></i> Add New Bank
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-nowrap mb-0" id="banksTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-uppercase fs-11 fw-bold text-muted" style="width: 50px;">Sr.No</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Bank Name</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Address</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">IFSC Code</th>

                                    <th class="text-uppercase fs-11 fw-bold text-muted">Bank Code</th>
                                    <th class="text-center text-uppercase fs-11 fw-bold text-muted">Status</th>
                                    <th class="text-end pe-4 text-uppercase fs-11 fw-bold text-muted">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banks as $key => $bank)
                                    <tr>
                                        <td class="ps-4 fw-medium text-muted">{{ $key + 1 }}</td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; background-color: rgba(99, 102, 241, 0.1); color: #6366f1;">
                                                    <i class="ri-building-2-line fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-dark fw-semibold">{{ $bank->bank }}</h6>
                                                    {{-- Show IFSC if available in model --}}
                                                    @if(!empty($bank->ifsc_code))
                                                        <small class="text-muted">IFSC: {{ $bank->ifsc_code }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-muted" style="max-width: 250px;">
                                            <span class="d-inline-block text-truncate w-100" title="{{ $bank->address }}">
                                                {{ $bank->address }}
                                            </span>
                                        </td>
<td class="text-muted" style="max-width: 250px;">
                                            <span class="d-inline-block text-truncate w-100" title="{{ $bank->ifsc_code }}">
                                                {{ $bank->ifsc_code }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $bank->bank_code }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if($bank->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                                    <i class="ri-checkbox-circle-line align-middle me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">
                                                    <i class="ri-close-circle-line align-middle me-1"></i> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.bank.edit', $bank->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Bank">
                                                <i class="ri-edit-box-line align-middle me-1"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-result">
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ri-bank-line fs-1 d-block mb-2 text-secondary"></i>
                                                <p class="mb-0">No banks found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($banks->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-end">
                            {{ $banks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- Styles for Soft Buttons --}}
@push('styles')
<style>
    .btn-soft-primary { background-color: rgba(99,102,241,0.1); color: #6366f1; border: none; transition: 0.3s; }
    .btn-soft-primary:hover { background-color: #6366f1; color: #fff; }
</style>
@endpush

{{-- Scripts for Search & Auto-Hide Flash --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Auto Hide Flash Message
        setTimeout(() => {
            let msg = document.getElementById('flash-message');
            if (msg) {
                let alert = new bootstrap.Alert(msg);
                alert.close();
            }
        }, 3000);

        // 2. Table Search Logic
        const searchInput = document.getElementById('tableSearch');
        const table = document.getElementById('banksTable');
        
        if(searchInput && table) {
            const rows = table.getElementsByTagName('tr');
            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                for (let i = 1; i < rows.length; i++) {
                    if (rows[i].classList.contains('no-result')) continue;
                    
                    const rowText = rows[i].textContent.toLowerCase();
                    if (rowText.includes(filter)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection