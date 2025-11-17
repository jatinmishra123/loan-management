@extends('admin.layouts.app')

@section('title', 'Bank & Branch Management Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between p-3 rounded-3" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                <div class="d-flex align-items-center">
                    <div class="avatar-md bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="ri-bar-chart-box-line text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-white">📊 Bank Apprised Management System</h4>
                        <p class="mb-0 text-white-50">Monitor your banking network at a glance</p>
                    </div>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ri-bank-line text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-1 fw-bold">{{ number_format($stats['total_banks']) }}</h3>
                            <p class="mb-1 text-muted">Total Banks</p>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_banks'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 ms-2">
                                    {{ $stats['total_banks'] - $stats['active_banks'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.bank.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="ri-external-link-line me-1"></i>Manage Banks
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ri-building-4-line text-success fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-1 fw-bold">{{ number_format($stats['total_branches']) }}</h3>
                            <p class="mb-1 text-muted">Total Branches</p>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_branches'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 ms-2">
                                    {{ $stats['total_branches'] - $stats['active_branches'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.branch.index') }}" class="btn btn-sm btn-outline-success w-100">
                        <i class="ri-external-link-line me-1"></i>Manage Branches
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ri-user-3-line text-info fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-1 fw-bold">{{ number_format($stats['total_agents']) }}</h3>
                            <p class="mb-1 text-muted">Total Agents</p>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_agents'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 ms-2">
                                    {{ $stats['total_agents'] - $stats['active_agents'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.agent.index') }}" class="btn btn-sm btn-outline-info w-100">
                        <i class="ri-external-link-line me-1"></i>Manage Agents
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-gold-line text-warning me-2 fs-4"></i>
                        Enter Gold Price per gram (24 carat)
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.goldprice.store') }}" method="POST"
                        class="d-flex align-items-center flex-wrap gap-3">
                        @csrf
                        <input type="number" step="0.01" name="price" class="form-control shadow-sm border-warning"
                            placeholder="Enter price for per gram (24 Carat)-> (₹)" required style="max-width: 300px;">
                        <button type="submit" class="btn btn-warning text-white fw-semibold shadow-sm">
                            <i class="ri-check-line me-1"></i> Save Price
                        </button>
                    </form>

                    @if(isset($latestPrice))
                    <div class="text-center mt-4">
                        <h1 class="fw-bold text-gradient mb-2">
                            💰 ₹{{ number_format($latestPrice->price, 2) }}
                        </h1>
                        <p class="mb-0 text-muted fs-6">
                            <strong>Current Gold Price  per gram (Per 24 Carat)</strong>
                        </p>
                        <small class="text-secondary d-block mb-3">
                            Last updated: {{ $latestPrice->updated_at->format('d M Y, h:i A') }}
                        </small>

                        <div class="d-flex justify-content-left gap-2">

                            <form action="{{ route('admin.goldprice.delete', $latestPrice->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure to delete this price?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(90deg, #ffb800, #f97316, #facc15);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 3rem;
            text-shadow: 1px 1px 5px rgba(255, 187, 0, 0.3);
        }
    </style>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.bank.create') }}" class="btn btn-outline-primary d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none">
                                <i class="ri-add-circle-line fs-2 mb-2"></i>
                                <span class="fw-medium">Add New Bank</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.branch.create') }}" class="btn btn-outline-success d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none">
                                <i class="ri-building-line fs-2 mb-2"></i>
                                <span class="fw-medium">Add New Branch</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.agent.create') }}" class="btn btn-outline-info d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none">
                                <i class="ri-user-add-line fs-2 mb-2"></i>
                                <span class="fw-medium">Add New Agent</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="#" class="btn btn-outline-warning d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none">
                                <i class="ri-file-chart-line fs-2 mb-2"></i>
                                <span class="fw-medium">View Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-building-4-line text-primary me-2"></i>Recent Branches
                    </h5>
                    <div class="d-flex align-items-center">
                        <input type="text" id="branchSearch" class="form-control form-control-sm me-2" placeholder="Search..." style="width: 150px;">
                        <a href="{{ route('admin.branch.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="branchTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Sr.n</th>
                                    <th>Bank</th>
                                    <th>Branch Address</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBranches as $key=> $branch)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $key+1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="ri-bank-line text-primary fs-6"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                {{ $branch->bank->bank ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $branch->branch_address }}</td>
                                    <td class="text-center">
                                        @if($branch->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                            <i class="ri-checkbox-circle-line me-1"></i>Active
                                        </span>
                                        @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                            <i class="ri-close-circle-line me-1"></i>Inactive
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.branch.index') }}" class="btn btn-outline-primary btn-sm me-2">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.branch.edit', $branch->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="no-result">
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ri-inbox-line fs-1"></i>
                                            <p class="mt-2">No branches found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-user-3-line text-info me-2"></i>Recent Agents
                    </h5>
                    <div class="d-flex align-items-center">
                        <input type="text" id="agentSearch" class="form-control form-control-sm me-2" placeholder="Search..." style="width: 150px;">
                        <a href="{{ route('admin.agent.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="agentTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Sr.n</th>
                                    <th>Name</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAgents as $key=> $agent)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $key+1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="ri-user-line text-info fs-6"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                {{ $agent->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $agent->bank->bank ?? 'N/A' }}</td>
                                    <td class="text-truncate" style="max-width: 150px;">{{ $agent->branch->branch_address ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($agent->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                            <i class="ri-checkbox-circle-line me-1"></i>Active
                                        </span>
                                        @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                            <i class="ri-close-circle-line me-1"></i>Inactive
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.agent.index') }}" class="btn btn-outline-primary btn-sm me-2">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.agent.edit', $agent->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="no-result">
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ri-user-unfollow-line fs-1"></i>
                                            <p class="mt-2">No agents found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12 mb-4">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title mb-0 d-flex align-items-center">
                <i class="ri-file-chart-line text-warning me-2 fs-4"></i>
                Recent Appraisal Certificates
            </h5>

            <div class="d-flex align-items-center">
                <input type="text" id="appraisalSearch" class="form-control form-control-sm me-2" placeholder="Search..." style="width: 200px;">
                <a href="#" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap">
                    <i class="ri-external-link-line me-1"></i>View All
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="appraisalTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Sr.N</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Downloaded At</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appraisalHistory as $key=> $record)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $key+1}}</td>
                            <td>{{ $record->customer->brauser_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td>
                                {{ $record->downloaded_at ? \Carbon\Carbon::parse($record->downloaded_at)->format('d M Y, h:i A') : '—' }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.appraisal.downloadAgain', $record->id) }}"
                                   class="btn btn-sm btn-success">
                                    <i class="ri-download-2-line"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="no-result">
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ri-file-warning-line fs-1"></i>
                                    <p class="mt-2">No appraisal records found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .stat-icon {
        width: 60px;
        height: 60px;
    }
    .page-title-box {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    .btn-group .btn {
        border-radius: 0.375rem !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to filter tables
        function filterTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            if (!input || !table) return;

            input.addEventListener('keyup', function() {
                const filter = input.value.toLowerCase();
                
                // Start loop from 1 to skip table header
                for (let i = 1; i < rows.length; i++) {
                    // Ignore rows that are purely for layout/no-result messages if you have them labeled
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

        // Apply Search to tables
        filterTable('branchSearch', 'branchTable');
        filterTable('agentSearch', 'agentTable');
        filterTable('appraisalSearch', 'appraisalTable');
    });
</script>

@endsection