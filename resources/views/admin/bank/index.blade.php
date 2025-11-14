@extends('admin.layouts.app')

@section('title', 'Banks List')

{{-- ✅ Bootstrap Icons CDN --}}
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">

            {{-- ✅ Success Message (only once show + auto hide) --}}
            @if(session('success'))
                <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card --}}
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                    <h4 class="card-title mb-0">🏦 All Banks</h4>
                    <!-- ✅ Add Bank Button -->
                    <a href="{{ route('admin.bank.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle"></i> Add Bank
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr.N</th>
                                    <th>Bank Name</th>
                                    <th>Address</th>
                                    <th>Bank Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banks as $key=> $bank)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $bank->bank }}</td>
                                        <td>{{ $bank->address }}</td>
                                        <td>{{ $bank->bank_code }}</td>
                                        <td>
                                            @if($bank->is_active)
                                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>
                                            @else
                                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bank.edit', $bank->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">🚫 No banks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $banks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Auto Hide Flash Message --}}
    <script>
        setTimeout(() => {
            let msg = document.getElementById('flash-message');
            if (msg) {
                msg.classList.remove('show');
                msg.classList.add('fade');
                setTimeout(() => msg.remove(), 500);
            }
        }, 2000);
    </script>
@endsection