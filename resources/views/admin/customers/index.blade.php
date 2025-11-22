@extends('admin.layouts.app')

@section('title', 'Customers List')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">

            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h4 class="card-title mb-0">Customers List</h4>

                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line align-middle me-1"></i> Add New Customer
                </a>
            </div>

            <div class="card-body">

                {{-- Success & Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                {{-- Search + Filter --}}
                <div class="row mb-4 g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0"
                                   placeholder="Search by name, loan no, packet..." autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>


                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center text-nowrap mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Sr. No</th>
                                <th>Borrower Name</th>
                                <th>Relative Name</th>
                                <th>Cash Officer</th>
                                <th>Loan A/C</th>
                                <th>Saving A/C</th>
                                <th>Bank</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Appraisal Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="customersTableBody">
                            @include('admin.customers.partials.table_rows', ['customers' => $customers])
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end pagination-container">
                    {{ $customers->links('pagination::bootstrap-5') }}
                </div>

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

    // -------------------------
    // Load Customers via AJAX
    // -------------------------
    function loadCustomers(page = 1) {
        const query = $('#searchInput').val();
        const status = $('#statusFilter').val();

        $('#customersTableBody').css('opacity', '0.4');

        $.ajax({
            url: '{{ route('admin.customers.index') }}',
            type: 'GET',
            data: { search: query, status: status, page: page },

            success: function (response) {
                $('#customersTableBody').html(response.html).css('opacity', '1');
                $('.pagination-container').html(response.pagination);
            },

            error: function () {
                $('#customersTableBody').css('opacity', '1');
                $('#customersTableBody').html(
                    '<tr><td colspan="11" class="text-danger text-center">Failed to load data.</td></tr>'
                );
            }
        });
    }


    // Search (debounced)
    $('#searchInput').on('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadCustomers(1), 400);
    });

    // Status Filter
    $('#statusFilter').change(() => loadCustomers(1));

    // Pagination (AJAX)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadCustomers(page);
    });

    // -------------------------
    // DELETE CUSTOMER
    // -------------------------
    $(document).on('click', '.delete-customer-btn', function () {

        const id = $(this).data('id');
        const name = $(this).data('name');

        Swal.fire({
            title: `Delete ${name}?`,
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: `/admin/customers/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },

                    success: function (res) {
                        Swal.fire("Deleted!", res.message, "success");
                        loadCustomers();
                    },

                    error: function (xhr) {
                        let msg = "Something went wrong.";

                        if (xhr.responseJSON?.message) {
                            msg = xhr.responseJSON.message;
                        }

                        Swal.fire("Error!", msg, "error");
                    }

                });

            }

        });

    });

});
</script>

@endpush
