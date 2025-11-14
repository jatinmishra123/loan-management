@extends('admin.layouts.app')

@section('title', 'Invoices - Admin Dashboard')

{{-- ✅ Custom CSS for design, scroll & table --}}
@push('styles')
    <style>
        /* General Page Design */
        body {
            background-color: #f9fafb !important;
        }

        h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card {
            border: none !important;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header,
        .card-body {
            background: #fff;
        }

        /* Scrollbar hidden but still scrollable */
        ::-webkit-scrollbar {
            width: 0px;
            height: 0px;
        }

        .table-responsive {
            position: relative;
            max-height: 70vh;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
        }

        /* Table Styles */
        .table {
            font-size: 0.82rem;
            border-radius: 10px;
        }

        .table th {
            background-color: #f3f4f6;
            text-transform: uppercase;
            font-weight: 600;
            color: #555;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: 0.2s ease;
        }

        .table td,
        .table th {
            padding: 0.7rem 1rem;
            vertical-align: middle;
        }

        /* Loader Overlay */
        .table-loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            border-radius: 10px;
            backdrop-filter: blur(2px);
        }

        /* Buttons and Filters */
        .btn-primary {
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 0.85rem;
        }

        .input-group-text {
            background-color: #f1f3f5;
            border-right: none;
        }

        .form-control,
        .form-select {
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
            border-color: #86b7fe;
        }

        .pagination {
            margin-top: 1rem !important;
        }

        .alert {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
    </style>
@endpush


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Manage Invoices</h2>
            <p class="text-muted small mb-0">View, search, and manage all customer invoices in one place.</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
            <i class="ri-add-line align-middle me-1"></i> Add Invoice
        </a>
    </div>

    {{-- Filters Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search by Invoice No, brauser_name, or Bank..." autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-user-3-line"></i></span>
                        <select id="customerFilter" class="form-select">
                            <option value="">All Customers</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->brauser_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Invoice Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive" id="invoices-table-container">
                {{-- Loader --}}
                <div class="table-loader" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <table class="table table-hover align-middle">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase text-muted small">
                            <th class="fw-semibold text-center" style="width: 60px;">Sr.No</th>
                            <th class="fw-semibold">Invoice No</th>
                            <th class="fw-semibold">Brauser_name</th>
                            <th class="fw-semibold">Invoice_Date</th>
                            <th class="fw-semibold text-center">Status</th>
                            <th class="fw-semibold text-end">Total (₹)</th>
                            <th class="fw-semibold text-end">Round_Off</th>
                            <th class="fw-semibold">Bank_Name</th>
                            <th class="fw-semibold">Created_On</th>
                            <th class="fw-semibold text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="invoicesTableBody">
                        @include('admin.invoices.partials.table', ['invoices' => $invoices])
                    </tbody>
                </table>
            </div>

            <div class="pagination-container d-flex justify-content-center mt-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            let searchTimeout;
            const tableLoader = $('.table-loader');

            function loadInvoices(page = 1) {
                const query = $('#searchInput').val();
                const customerId = $('#customerFilter').val();

                $.ajax({
                    url: '{{ route('admin.invoices.index') }}',
                    method: 'GET',
                    data: { search: query, customer: customerId, page: page },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    beforeSend: function () {
                        tableLoader.show();
                    },
                    success: function (response) {
                        if (response.table_html) {
                            $('#invoicesTableBody').html(response.table_html);
                            $('.pagination-container').html(response.pagination_html);
                        }
                    },
                    error: function () {
                        $('#invoicesTableBody').html(
                            '<tr><td colspan="10" class="text-center text-danger small">⚠️ Failed to load data. Try again.</td></tr>'
                        );
                    },
                    complete: function () {
                        tableLoader.hide();
                    }
                });
            }

            // Search (with debounce)
            $('#searchInput').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => loadInvoices(1), 400);
            });

            // Filter by Customer
            $('#customerFilter').on('change', function () {
                loadInvoices(1);
            });

            // Pagination
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const page = new URL($(this).attr('href')).searchParams.get('page');
                loadInvoices(page);
            });

            // Delete Invoice
            $(document).on('click', '.delete-invoice-btn', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: `Delete Invoice ${name}?`,
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/invoices/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message || "Invoice deleted successfully.",
                                    icon: "success",
                                    timer: 1800,
                                    showConfirmButton: false
                                });
                                const currentPage = $('.pagination .active .page-link').text() || 1;
                                loadInvoices(currentPage);
                            },
                            error: function () {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush