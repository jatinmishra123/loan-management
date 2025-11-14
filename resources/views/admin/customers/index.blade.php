@extends('admin.layouts.app')

@section('title', 'Customers - Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h4 class="card-title mb-0">Customers</h4>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line align-middle me-1"></i> Add Customer
                    </a>
                </div>

                <div class="card-body">
                    {{-- ✅ Flash Messages --}}
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

                    <!-- 🔍 Search & Filter -->
                    <div class="row mb-3 g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Search by browser, relative, officer..." autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <select id="statusFilter" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="active">Active Borrowers</option>
                                <option value="inactive">Inactive Borrowers</option>
                            </select>
                        </div>
                    </div>

                    <!-- 🧾 Customer Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center mb-0"
                            style="white-space: nowrap;">
                            <thead class="table-light align-middle">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Browser Name</th>
                                    <th>Relative Name</th>
                                    <th>Cash Officer Name</th>
                                    <th>Loan A/C No</th>
                                    <th>Saving A/C No</th>
                                    <th>Bank</th>
                                    <th>Branch Address</th>
                                    <th>Status</th>
                                    <th>Joined On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customersTableBody">
                                @forelse ($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->brauser_name ?? '-' }}</td>
                                        <td>{{ $customer->ralative_name ?? '-' }}</td>
                                        <td>{{ $customer->cash_incharge ?? '-' }}</td>
                                        <td>{{ $customer->loan_number ?? '-' }}</td>
                                        <td>{{ $customer->saving_number ?? '-' }}</td>
                                        <td>{{ $customer->bank->bank ?? '-' }}</td>
                                        <td>{{ $customer->branch->branch_address ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $customer->created_at?->format('d M, Y') ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- 👁️ View -->
                                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- ✏️ Edit -->
                                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>

                                                <!-- ❌ Delete -->
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-customer-btn"
                                                    data-id="{{ $customer->id }}" data-name="{{ $customer->brauser_name }}"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3 pagination-container text-center">
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

            // 🔄 Load customers dynamically (AJAX)
            function loadCustomers(page = 1) {
                const query = $('#searchInput').val();
                const status = $('#statusFilter').val();

                $.ajax({
                    url: '{{ route('admin.customers.index') }}',
                    method: 'GET',
                    data: { search: query, status: status, page: page },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (response) {
                        if (response.table && response.pagination) {
                            $('#customersTableBody').html(response.table);
                            $('.pagination-container').html(response.pagination);
                        }
                    },
                    error: function () {
                        console.error('⚠️ Error fetching customer data');
                    }
                });
            }

            // 🔍 Debounced Search
            $('#searchInput').on('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => loadCustomers(1), 400);
            });

            // 🧩 Filter by Status
            $('#statusFilter').on('change', function () {
                loadCustomers(1);
            });

            // 📄 AJAX Pagination
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const page = new URL($(this).attr('href')).searchParams.get('page');
                loadCustomers(page);
            });

            // 🗑️ Delete Customer (SweetAlert2)
            $(document).on('click', '.delete-customer-btn', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: `Delete ${name}?`,
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/customers/${id}`,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function () {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Customer deleted successfully.",
                                    icon: "success",
                                    timer: 1800,
                                    showConfirmButton: false
                                });
                                setTimeout(() => loadCustomers(), 1000);
                            },
                            error: function () {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Something went wrong while deleting.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush