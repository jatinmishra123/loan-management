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
                {{-- ✅ Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row mb-4 g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ri-search-line"></i></span>
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
                                <th>Ledger Folio</th>
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

        // 1. Function to Fetch Data via AJAX
        function loadCustomers(page = 1) {
            const query = $('#searchInput').val();
            const status = $('#statusFilter').val();

            // Show a loading opacity effect
            $('#customersTableBody').css('opacity', '0.5');

            $.ajax({
                url: '{{ route('admin.customers.index') }}',
                method: 'GET',
                data: { 
                    search: query, 
                    status: status, 
                    page: page 
                },
                success: function (response) {
                    $('#customersTableBody').html(response.html).css('opacity', '1');
                    $('.pagination-container').html(response.pagination);
                },
                error: function () {
                    console.error('Error fetching data');
                    $('#customersTableBody').css('opacity', '1');
                    // Aap yahan ek error message dikha sakte hain
                    $('#customersTableBody').html('<tr><td colspan="12" class="text-center text-danger">Failed to load data. Please try again.</td></tr>');
                }
            });
        }

        // 2. Event: Search Input (Debounced)
        $('#searchInput').on('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => loadCustomers(1), 400); // 400ms delay
        });

        // 3. Event: Status Filter Change
        $('#statusFilter').on('change', function () {
            loadCustomers(1);
        });

        // 4. Event: Pagination Clicks
        // Event delegation use karna zaruri hai kyunki pagination AJAX se badalta hai
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadCustomers(page);
        });

        // 5. Event: Delete Customer
        // Event delegation yahan bhi best practice hai
        $(document).on('click', '.delete-customer-btn', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const url = `/admin/customers/${id}`; // URL variable mein store karein

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
                        url: url, // Variable use karein
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            Swal.fire("Deleted!", res.message || "Customer deleted.", "success");
                            loadCustomers(); // Table ko refresh karein
                        },
                        error: function (xhr) { // 'err' ko 'xhr' karein (standard practice)
                            console.error(xhr.responseText); // Poora error console mein dekhein
                            let errorMsg = "Something went wrong.";
                            if(xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire("Error!", errorMsg, "error");
                        } // <-- YAHAN BRACKET '}' MISSING THA
                    });
                }
            });
        });
    });
</script>
@endpush