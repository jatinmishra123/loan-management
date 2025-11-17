@extends('admin.layouts.app')

@section('title', 'Invoices - Admin Dashboard')

@push('styles')
<style>
    body { background-color: #f9fafb !important; }

    h2 { font-size: 1.25rem; font-weight: 600; }
    .card { border: none !important; border-radius: 12px; overflow: hidden; }

    .table-responsive { position: relative; min-height: 300px; border-radius: 10px; }

    .table th {
        background-color: #f3f4f6;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #6b7280;
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table td {
        padding: 12px;
        vertical-align: middle;
        font-size: 0.875rem;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
    }

    .table tbody tr:hover { background-color: #f9fafb; transition: 0.2s; }

    .table-loader {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.7);
        display: flex; justify-content: center; align-items: center;
        z-index: 10; backdrop-filter: blur(1px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div>
            <h2 class="mb-0">Manage Invoices</h2>
            <p class="text-muted small mb-0">Search, filter & manage all invoices.</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Invoice
        </a>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Search Invoice / Customer / Bank...">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="ri-filter-3-line"></i></span>
                        <select id="customerFilter" class="form-select border-start-0 ps-0">
                            <option value="">All Customers</option>
                            @foreach ($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->brauser_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">

                <div class="table-loader d-none">
                    <div class="spinner-border text-primary"></div>
                </div>

                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Round Off</th>
                            <th>Bank</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="invoicesTableBody">
                        @include('admin.invoices.partials.table', ['invoices' => $invoices])
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white text-center">
            <div id="paginationWrapper">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    let searchTimeout;

    function loadInvoices(page = 1) {
        $.ajax({
            url: "{{ route('admin.invoices.index') }}",
            method: "GET",
            data: {
                search: $('#searchInput').val(),
                customer: $('#customerFilter').val(),
                page: page
            },
            beforeSend: () => $('.table-loader').removeClass('d-none'),
            
            success: (res) => {
                $('#invoicesTableBody').html(res.table_html);
                $('#paginationWrapper').html(res.pagination_html);
            },

            complete: () => $('.table-loader').addClass('d-none'),
        });
    }

    // Search
    $('#searchInput').on('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadInvoices(1), 400);
    });

    // Filter
    $('#customerFilter').on('change', () => loadInvoices(1));

    // Pagination
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = new URL($(this).attr('href')).searchParams.get('page');
        loadInvoices(page);
    });

    // Delete
    $(document).on('click', '.delete-invoice-btn', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');

        Swal.fire({
            title: "Delete?",
            text: `Invoice #${name} will be deleted permanently!`,
            icon: "warning",
            showCancelButton: true
        }).then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: `/admin/invoices/${id}`,
                    method: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },

                    success: () => {
                        Swal.fire("Deleted!", "", "success");
                        loadInvoices(1);
                    }
                });
            }
        });
    });

});
</script>
@endpush
