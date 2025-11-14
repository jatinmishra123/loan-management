@extends('admin.layouts.app')

@section('title', 'Agents List')

@push('styles')
    {{-- ✅ Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- ✅ Table Styling --}}
    <style>
        table th,
        table td {
            white-space: nowrap !important;
            /* ✅ Prevent text from wrapping */
            vertical-align: middle !important;
            font-size: 13px !important;
            padding: 8px 10px !important;
        }

        table th {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge {
            font-size: 12px;
            padding: 4px 8px;
        }

        .btn-sm i {
            font-size: 14px;
        }

        .btn-sm {
            padding: 3px 7px;
        }

        /* ✅ Hide alert smoothly after a few seconds */
        #success-alert {
            transition: all 0.4s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <div class="card shadow-sm border-0">
        <!-- Header -->
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-primary">Agents List</h4>
            <a href="{{ route('admin.agent.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Add Agent
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success py-2 px-3 small" id="success-alert">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle text-nowrap">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>SR.N</th>
                            <th>Bank</th>
                            <th>Branch</th>
                            <th>Designation</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>WhatsApp No</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agents as $key=> $agent)
                            <tr>
                                <td class="text-center">{{ $key+1}}</td>
                                <td>{{ $agent->bank->bank ?? 'N/A' }}</td>
                                <td>{{ $agent->branch->branch_address ?? 'N/A' }}</td>
                                <td>{{ $agent->designation }}</td>
                                <td>{{ $agent->name }}</td>
                                <td>{{ $agent->email }}</td>
                                <td>{{ $agent->mobile_number }}</td>
                                <td>{{ $agent->whatsapp_number }}</td>
                                <td class="text-center">
                                    @if($agent->image)
                                        <img src="{{ asset('storage/' . $agent->image) }}" width="45" height="45" class="rounded"
                                            style="object-fit: cover;">
                                    @else
                                        <span class="text-muted small">No Image</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($agent->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.agent.edit', $agent->id) }}" class="btn btn-sm btn-primary"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.agent.destroy', $agent->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this agent?')"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No agents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $agents->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- ✅ Auto-hide success alert --}}
    @push('scripts')
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) alert.style.opacity = '0';
                setTimeout(() => alert?.remove(), 400);
            }, 2000);
        </script>
    @endpush
@endsection