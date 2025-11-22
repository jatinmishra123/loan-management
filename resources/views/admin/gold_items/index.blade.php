@extends('admin.layouts.app')

@section('title', 'Gold Items')

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

            {{-- Error Message --}}
            @if(session('error'))
                <div id="flash-message" class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="ri-error-warning-line align-middle me-2 fs-5"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4">
                
                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="row align-items-center gy-2">
                        <div class="col-md-4">
                            <h5 class="card-title mb-0 text-primary fw-bold">
                                <i class="ri-vip-diamond-line align-middle me-1"></i> Gold Items
                            </h5>
                            <p class="text-muted mb-0 small mt-1">Manage valuation details for gold items.</p>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-md-end gap-2 align-items-center">
                                {{-- Search Filter --}}
                                <div class="input-group d-none d-sm-flex" style="max-width: 250px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                                    <input type="text" id="tableSearch" class="form-control bg-light border-start-0" placeholder="Search items...">
                                </div>

                                <a href="{{ route('admin.gold_items.create') }}" class="btn btn-primary shadow-sm">
                                    <i class="ri-add-circle-line align-middle me-1"></i> Add Gold Item
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-nowrap mb-0" id="goldTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-uppercase fs-11 fw-bold text-muted" style="width: 50px;">#</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Customer</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Item Description</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Weight Details (gm)</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Valuation</th>
                                    <th class="text-uppercase fs-11 fw-bold text-muted">Created At</th>
                                    <th class="text-end pe-4 text-uppercase fs-11 fw-bold text-muted">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($golditems as $item)
                                    <tr>
                                        <td class="ps-4 fw-medium text-muted">
                                            {{ $loop->iteration + ($golditems->currentPage() - 1) * $golditems->perPage() }}
                                        </td>
                                        
                                        {{-- Customer --}}
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-soft-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                                    <i class="ri-user-3-line fs-5"></i>
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $item->customer->brauser_name ?? 'N/A' }}</span>
                                            </div>
                                        </td>

                                        {{-- Description --}}
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium text-dark">{{ $item->description }}</span>
                                                <small class="text-muted">
                                                    Qty: <span class="badge bg-light text-dark border">{{ $item->quantity }}</span>
                                                    <span class="mx-1">|</span>
                                                    Purity: <span class="text-warning fw-bold">{{ $item->purity }}K</span>
                                                </small>
                                            </div>
                                        </td>

                                        {{-- Weights --}}
                                        <td>
                                            <div class="d-flex gap-3">
                                                <div class="text-center">
                                                    <small class="text-muted d-block fs-10">Gross</small>
                                                    <span class="fw-medium">{{ $item->gross_weight }}</span>
                                                </div>
                                                <div class="vr opacity-10"></div>
                                                <div class="text-center">
                                                    <small class="text-muted d-block fs-10">Stone</small>
                                                    <span class="fw-medium">{{ $item->stone_weight }}</span>
                                                </div>
                                                <div class="vr opacity-10"></div>
                                                <div class="text-center">
                                                    <small class="text-muted d-block fs-10">Net</small>
                                                    <span class="fw-bold text-success">{{ $item->net_weight }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Valuation --}}
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">₹{{ number_format($item->market_value, 2) }}</span>
                                                <small class="text-muted">Rate: ₹{{ number_format($item->rate_per_gram, 2) }}/gm</small>
                                            </div>
                                        </td>

                                        {{-- Created At --}}
                                        <td>
                                            <span class="badge bg-light text-secondary fw-normal border">
                                                <i class="ri-calendar-line align-middle me-1"></i>
                                                {{ $item->created_at->format('d M, Y') }}
                                            </span>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.gold_items.edit', $item->id) }}" class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip" title="Edit Item">
                                                    <i class="ri-pencil-line align-middle"></i>
                                                </a>

                                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.gold_items.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmDelete('delete-form-{{ $item->id }}')" data-bs-toggle="tooltip" title="Delete Item">
                                                        <i class="ri-delete-bin-line align-middle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-result">
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ri-copper-coin-line fs-1 d-block mb-2 text-secondary"></i>
                                                <p class="mb-0">No gold items found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($golditems->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-end">
                            {{ $golditems->links('pagination::bootstrap-5') }}
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
    .btn-soft-warning { background-color: rgba(255,193,7,0.1); color: #ffc107; border: none; transition: 0.3s; }
    .btn-soft-warning:hover { background-color: #ffc107; color: #fff; }

    .btn-soft-danger { background-color: rgba(220,53,69,0.1); color: #dc3545; border: none; transition: 0.3s; }
    .btn-soft-danger:hover { background-color: #dc3545; color: #fff; }

    .fs-10 { font-size: 10px; }
</style>
@endpush

@push('scripts')
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // 1. Auto Hide Flash Message
            let flashMsg = document.querySelector('#flash-message');
            if (flashMsg) {
                setTimeout(() => {
                    flashMsg.classList.remove('show');
                    flashMsg.classList.add('fade');
                    setTimeout(() => flashMsg.remove(), 500);
                }, 3000);
            }

            // 2. Table Search Filter
            const searchInput = document.getElementById('tableSearch');
            const table = document.getElementById('goldTable');
            
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
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107", // Warning color for Gold Items
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