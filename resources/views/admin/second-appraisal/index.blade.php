@extends('admin.layouts.app')

@section('title', 'Second Appraisal List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            
            <div class="card border-0 shadow-lg rounded-4">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="row align-items-center gy-2">
                        
                        {{-- Title --}}
                        <div class="col-md-5">
                            <h5 class="card-title mb-0 text-primary fw-bold">
                                <i class="ri-file-list-3-line align-middle me-1"></i> Appraisal List
                            </h5>
                        </div>
                        
                        {{-- Actions: Search, Generate, Add New --}}
                        <div class="col-md-7">
                            <div class="d-flex justify-content-md-end align-items-center gap-2">
                                
                                {{-- Search Box (Max width reduced to 200px) --}}
                                <div class="input-group d-none d-sm-flex" style="max-width: 200px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 form-control-sm" placeholder="Search account...">
                                </div>
                                
                                {{-- Button: Generate Second Appraisal (btn-sm) --}}
                                <a href="{{ route('admin.second-appraisal.generator') }}" class="btn btn-warning **btn-sm** shadow-sm">
                                    <i class="ri-refresh-line me-1"></i> Generate
                                </a>
                                
                                {{-- Button: Add New (btn-sm) --}}
                                <a href="{{ route('admin.second-appraisal.create') }}" class="btn btn-primary **btn-sm** shadow-sm">
                                    <i class="ri-add-circle-line align-middle me-1"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="ri-checkbox-circle-line align-middle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4 text-uppercase fs-11 fw-bold text-muted">ID</th>
                                    <th scope="col" class="text-uppercase fs-11 fw-bold text-muted">Gold Loan A/C</th>
                                    <th scope="col" class="text-uppercase fs-11 fw-bold text-muted">Ledger Folio</th>
                                    <th scope="col" class="text-uppercase fs-11 fw-bold text-muted">Appraisal Date</th>
                                    <th scope="col" class="text-uppercase fs-11 fw-bold text-muted">Bank / Branch</th>
                                    <th scope="col" class="text-end pe-4 text-uppercase fs-11 fw-bold text-muted">Actions</th>
                                                                </tr>
                            </thead>

                            <tbody>
                                @forelse($appraisals as $appr)
                                    <tr>
                                        <td class="ps-4 fw-semibold text-primary">#{{ $appr->id }}</td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-soft-warning text-warning fs-5">
                                                        <i class="ri-vip-diamond-line"></i>
                                                    </span>
                                                </div>
                                                <span class="fw-medium">{{ $appr->gold_loan_account_no }}</span>
                                            </div>
                                        </td>

                                        <td>{{ $appr->ledger_folio_no }}</td>
                                        
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="ri-calendar-line align-middle me-1 text-muted"></i>
                                                {{ \Carbon\Carbon::parse($appr->second_appraisal_date)->format('d M, Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $appr->bank->bank ?? '-' }}</span>
                                                <small class="text-muted">{{ $appr->branch->branch_address ?? '-' }}</small>
                                            </div>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                
                                                {{-- Action Buttons: Already btn-sm, which is the smallest standard size --}}
                                                <a href="{{ route('admin.second-appraisal.show', $appr->id) }}" 
                                                    class="btn **btn-sm** btn-soft-info" 
                                                    data-bs-toggle="tooltip" title="View Details">
                                                     <i class="ri-eye-line"></i>
                                                </a>

                                                <a href="{{ route('admin.second-appraisal.edit', $appr->id) }}" 
                                                    class="btn **btn-sm** btn-soft-primary"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                     <i class="ri-edit-line"></i>
                                                </a>

                                                <a href="{{ route('admin.second-appraisal.download', $appr->id) }}" 
                                                    class="btn **btn-sm** btn-soft-success"
                                                    data-bs-toggle="tooltip" title="Download PDF">
                                                     <i class="ri-file-download-line"></i>
                                                </a>

                                                <button type="button" 
                                                             class="btn **btn-sm** btn-soft-danger delete-record" 
                                                             data-id="{{ $appr->id }}"
                                                             data-bs-toggle="tooltip" title="Delete">
                                                     <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ri-folder-info-line fs-1 d-block mb-2"></i>
                                                <p class="mb-0">No appraisal records found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Showing {{ $appraisals->firstItem() }} to {{ $appraisals->lastItem() }} of {{ $appraisals->total() }} entries</span>
                            <div>
                                {{ $appraisals->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div> {{-- End Card Body --}}
            </div> {{-- End Card --}}

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Soft Button Styles (Kept as is, they look good) */
    .btn-soft-info { background-color: rgba(13,202,240,0.1); color: #0dcaf0; border: none; }
    .btn-soft-info:hover { background-color: #0dcaf0; color: #fff; }

    .btn-soft-primary { background-color: rgba(99,102,241,0.1); color: #6366f1; border: none; }
    .btn-soft-primary:hover { background-color: #6366f1; color: #fff; }

    .btn-soft-success { background-color: rgba(25,135,84,0.1); color: #198754; border: none; }
    .btn-soft-success:hover { background-color: #198754; color: #fff; }

    .btn-soft-danger { background-color: rgba(220,53,69,0.1); color: #dc3545; border: none; }
    .btn-soft-danger:hover { background-color: #dc3545; color: #fff; }

    /* Avatar style for visual interest */
    .avatar-xs { height: 2rem; width: 2rem; }
    .bg-soft-warning { background-color: rgba(255,193,7,0.1) !important; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Initialize BootStrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // SweetAlert2 Delete Logic (Assuming SweetAlert2 is included globally)
        const deleteButtons = document.querySelectorAll('.delete-record');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const recordId = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6366f1', 
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        // Perform Fetch Request
                        fetch(`{{ url('admin/second-appraisal') }}/${recordId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Deleted!',
                                    'The record has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Server error occurred.',
                                'error'
                            );
                        });
                    }
                })
            });
        });
    });
</script>
@endpush