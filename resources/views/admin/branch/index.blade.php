@extends('admin.layouts.app')

@section('title', 'Branches List')

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
                                <i class="ri-git-branch-line align-middle me-1"></i> Branches List
                            </h5>
                            <p class="text-muted mb-0 small mt-1">Manage bank branches and their details.</p>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-md-end gap-2 align-items-center">
                                {{-- Search Filter --}}
                                <div class="input-group d-none d-sm-flex" style="max-width: 250px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                                    <input type="text" id="tableSearch" class="form-control bg-light border-start-0" placeholder="Search branches...">
                                </div>

                                <a href="{{ route('admin.branch.create') }}" class="btn btn-primary shadow-sm">
                                    <i class="ri-add-circle-line align-middle me-1"></i> Add Branch
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-nowrap mb-0" id="branchTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-uppercase fs-11 fw-bold text-muted" style="width: 50px;">Sr.No</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Bank</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Branch Address</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Branch Email</th>

                                    <th class="text-uppercase fs-11 fw-bold text-muted">Contact / Incharge</th>
                                    <th class="text-center text-uppercase fs-11 fw-bold text-muted">Status</th>
                                    <th class="text-end pe-4 text-uppercase fs-11 fw-bold text-muted">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($branches as $key => $branch)
                                    <tr>
                                        <td class="ps-4 fw-medium text-muted">{{ $branches->firstItem() + $key }}</td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; background-color: rgba(99, 102, 241, 0.1); color: #6366f1;">
                                                    <i class="ri-bank-line fs-5"></i>
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $branch->bank->bank ?? 'N/A' }}</span>
                                            </div>
                                        </td>

                                        <td class="text-muted" style="max-width: 250px;">
                                            <span class="d-inline-block text-truncate w-100" title="{{ $branch->branch_address }}">
                                                <i class="ri-map-pin-line align-middle me-1 text-secondary"></i> 
                                                {{ $branch->branch_address }}
                                            </span>
                                        </td>
<td class="text-muted" style="max-width: 250px;">
    <span class="d-inline-block text-truncate w-100" title="{{ $branch->branch_email }}">
        <i class="ri-mail-line align-middle me-1 text-secondary"></i>
        <a href="mailto:{{ $branch->branch_email }}" class="text-decoration-none text-muted">
            {{ $branch->branch_email }}
        </a>
    </span>
</td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium text-dark">{{ $branch->cash_incharge }}</span>
                                                @if(!empty($branch->branch_email))
                                                    <small class="text-muted">{{ $branch->branch_email }}</small>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            @if($branch->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                {{-- Edit --}}
                                                <a href="{{ route('admin.branch.edit', $branch->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Branch">
                                                    <i class="ri-edit-line align-middle"></i>
                                                </a>

                                                {{-- Delete --}}
                                                <form id="delete-form-{{ $branch->id }}" action="{{ route('admin.branch.destroy', $branch->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmDelete('delete-form-{{ $branch->id }}')" data-bs-toggle="tooltip" title="Delete Branch">
                                                        <i class="ri-delete-bin-line align-middle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-result">
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ri-git-branch-line fs-1 d-block mb-2 text-secondary"></i>
                                                <p class="mb-0">No branches found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($branches->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-end">
                            {{ $branches->links('pagination::bootstrap-5') }}
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

    .btn-soft-danger { background-color: rgba(220,53,69,0.1); color: #dc3545; border: none; transition: 0.3s; }
    .btn-soft-danger:hover { background-color: #dc3545; color: #fff; }
</style>
@endpush

@push('scripts')
    {{-- SweetAlert2 CDN (If not already included in layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // 1. Auto Hide Success Message
            let successAlert = document.querySelector('#flash-message');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.classList.remove('show');
                    successAlert.classList.add('fade');
                    setTimeout(() => successAlert.remove(), 500);
                }, 3000);
            }

            // 2. Table Search Filter
            const searchInput = document.getElementById('tableSearch');
            const table = document.getElementById('branchTable');
            
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

        // 3. SweetAlert Delete Confirmation
        function confirmDelete(formId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#6366f1", // Theme color
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush

@endsection