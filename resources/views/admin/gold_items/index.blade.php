@extends('admin.layouts.app')

@section('title', 'Gold Items')

@section('content')
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm border-0">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h4 class="mb-0 fw-semibold text-primary">Gold Items</h4>
                    <a href="{{ route('admin.gold_items.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i> Add Gold Item
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body">
                    {{-- ✅ Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success py-2 px-3 small mb-3">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger py-2 px-3 small mb-3">{{ session('error') }}</div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle text-nowrap">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Gross Wt</th>
                                    <th>Stone Wt</th>
                                    <th>Net Wt</th>
                                    <th>Purity</th>
                                    <th>Rate/gm</th>
                                    <th>Market Value</th>
                                    <th>Remarks</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($golditems as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($golditems->currentPage() - 1) * $golditems->perPage() }}
                                        </td>
                                        <td>{{ $item->customer->brauser_name ?? 'N/A' }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td>{{ $item->gross_weight }}</td>
                                        <td>{{ $item->stone_weight }}</td>
                                        <td>{{ $item->net_weight }}</td>
                                        <td>{{ $item->purity }}k</td>
                                        <td class="text-end">{{ number_format($item->rate_per_gram, 2) }}</td>
                                        <td class="text-end">{{ number_format($item->market_value, 2) }}</td>
                                        <td>{{ $item->remarks }}</td>
                                        <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.gold_items.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.gold_items.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                                        title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted">No gold items found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $golditems->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Table Styling -->
    @push('styles')
        <style>
            /* Compact & Clean Table Look */
            table th,
            table td {
                white-space: nowrap !important;
                /* ✅ Prevent text wrapping */
                vertical-align: middle !important;
                font-size: 13px !important;
                padding: 8px 10px !important;
            }

            table th {
                text-transform: uppercase;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            table td {
                color: #333;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Improve Action Buttons */
            .btn-group .btn {
                margin-right: 3px;
                border-radius: 4px !important;
            }

            /* Reduce pagination spacing */
            .pagination {
                margin-bottom: 0;
            }
        </style>
    @endpush
@endsection