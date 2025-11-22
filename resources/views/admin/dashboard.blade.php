@extends('admin.layouts.app')

@section('title', 'Bank & Branch Management Dashboard')

@section('content')
<div class="container-fluid">

    {{-- 1. PAGE TITLE & BREADCRUMB --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column flex-md-row align-items-center justify-content-between p-3 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="avatar-md bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                        <i class="ri-bar-chart-box-line text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-white">📊 Bank Apprised Management System</h4>
                        <p class="mb-0 text-white-50 small d-none d-sm-block">Monitor your banking network at a glance</p>
                    </div>
                </div>
                <div class="page-title-right text-md-end">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. STATISTICS CARDS --}}
    {{-- Responsive change: Increased column size for better look on small desktops/tablets --}}
    <div class="row mb-4">
        {{-- Banks Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-start">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                            <i class="ri-bank-line text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            {{-- Adjusted font size for better mobile scaling --}}
                            <h3 class="mb-1 fw-bold fs-2">{{ number_format($stats['total_banks']) }}</h3>
                            <p class="mb-2 text-muted text-uppercase small fw-semibold">Total Banks</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill py-1 px-2">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_banks'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill py-1 px-2">
                                    {{ $stats['total_banks'] - $stats['active_banks'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.bank.index') }}" class="btn btn-sm btn-outline-primary w-100 fw-medium">
                        <i class="ri-external-link-line me-1"></i>Manage Banks
                    </a>
                </div>
            </div>
        </div>

        {{-- Branches Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-start">
                        <div class="stat-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                            <i class="ri-building-4-line text-success fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-1 fw-bold fs-2">{{ number_format($stats['total_branches']) }}</h3>
                            <p class="mb-2 text-muted text-uppercase small fw-semibold">Total Branches</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill py-1 px-2">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_branches'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill py-1 px-2">
                                    {{ $stats['total_branches'] - $stats['active_branches'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.branch.index') }}" class="btn btn-sm btn-outline-success w-100 fw-medium">
                        <i class="ri-external-link-line me-1"></i>Manage Branches
                    </a>
                </div>
            </div>
        </div>

        {{-- Agents Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-start">
                        <div class="stat-icon bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                            <i class="ri-user-3-line text-info fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-1 fw-bold fs-2">{{ number_format($stats['total_agents']) }}</h3>
                            <p class="mb-2 text-muted text-uppercase small fw-semibold">Total Agents</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill py-1 px-2">
                                    <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['active_agents'] }} Active
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill py-1 px-2">
                                    {{ $stats['total_agents'] - $stats['active_agents'] }} Inactive
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('admin.agent.index') }}" class="btn btn-sm btn-outline-info w-100 fw-medium">
                        <i class="ri-external-link-line me-1"></i>Manage Agents
                    </a>
                </div>
            </div>
        </div>
    </div>

    ---

    {{-- 3. GOLD PRICE SECTION (Corrected for null date format error) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="ri-gold-line text-warning me-2 fs-4"></i>
                        Enter Gold Price per gram (24 carat)
                    </h5>
                    {{-- Added margin for separation on small screens --}}
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.goldprice.store') }}" method="POST" class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                        @csrf
                        <input type="number" step="0.01" name="price" class="form-control shadow-sm border-warning flex-grow-1"
                            placeholder="Enter price for per gram (24 Carat)-> (₹)" required style="max-width: 350px;">
                        <button type="submit" class="btn btn-warning text-white fw-semibold shadow-sm flex-shrink-0">
                            <i class="ri-check-line me-1"></i> Save Price
                        </button>
                    </form>

                    @if(isset($latestPrice))
                    <div class="text-center mt-4 p-3 border rounded bg-light">
                        <h1 class="fw-bold text-gradient mb-2">
                            💰 ₹{{ number_format($latestPrice->price, 2) }}
                        </h1>
                        <p class="mb-0 text-muted fs-6 fw-semibold">
                            Current Gold Price per gram (Per 24 Carat)
                        </p>
                        <small class="text-secondary d-block mb-3">
                            Last updated:
                            {{ $latestPrice->updated_at?->format('d M Y, h:i A') ?? $latestPrice->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </small>

                        <form action="{{ route('admin.goldprice.delete', $latestPrice->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this price?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="ri-delete-bin-line me-1"></i> Delete Latest Price
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    ---

    {{-- 4. QUICK ACTIONS --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">🚀 Quick Actions</h5>
                </div>
                <div class="card-body">
                    {{-- Used g-3 for responsive grid gap and col-6 for mobile stacking --}}
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.bank.create') }}" class="btn btn-outline-primary d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none rounded-3 action-btn">
                                <i class="ri-add-circle-line fs-2 mb-2"></i>
                                <span class="fw-medium text-center small">Add New Bank</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.branch.create') }}" class="btn btn-outline-success d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none rounded-3 action-btn">
                                <i class="ri-building-line fs-2 mb-2"></i>
                                <span class="fw-medium text-center small">Add New Branch</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.agent.create') }}" class="btn btn-outline-info d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none rounded-3 action-btn">
                                <i class="ri-user-add-line fs-2 mb-2"></i>
                                <span class="fw-medium text-center small">Add New Agent</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="#" class="btn btn-outline-warning d-flex flex-column align-items-center justify-content-center p-3 w-100 h-100 text-decoration-none rounded-3 action-btn">
                                <i class="ri-file-chart-line fs-2 mb-2"></i>
                                <span class="fw-medium text-center small">View Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    ---

    {{-- 5. RECENT CUSTOMERS SECTION --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                    <h5 class="card-title mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="ri-group-line text-primary me-2 fs-4"></i>
                        Recent Customers
                    </h5>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end w-100 w-sm-auto">
                        <input type="text" id="customerSearch" class="form-control form-control-sm me-2 flex-grow-1" placeholder="Search customer..." style="max-width: 250px;">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap flex-shrink-0">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    {{-- Added table-responsive for better mobile scrolling --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Customer (Borrower)</th>
                                    <th>Loan Details</th>
                                    <th>Location</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCustomers as $key => $customer)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($customer->brauser_name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fs-6 text-truncate" style="max-width: 150px;">{{ $customer->brauser_name }}</h6>
                                                <small class="text-muted text-truncate d-block" style="max-width: 150px;">
                                                    Relative: {{ $customer->ralative_name ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark small" title="Loan Number">
                                                <i class="ri-file-list-line me-1 text-muted"></i>
                                                LN: {{ $customer->loan_number ?? 'N/A' }}
                                            </span>
                                            <small class="text-muted" title="Account Number">
                                                <i class="ri-bank-card-line me-1"></i>
                                                AC: {{ $customer->account_number ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-truncate" style="max-width: 100px;">
                                        <span class="small">{{ $customer->address }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($customer->is_active)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 small">Active</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 small">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        {{-- Adjusted button group to wrap on mobile if needed with small gap --}}
                                        <div class="btn-group btn-group-sm flex-wrap gap-1">
                                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-outline-info" data-bs-toggle="tooltip" title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Customer">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="no-result">
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-user-search-line fs-1 d-block mb-2"></i>
                                            <p class="mb-0">No recent customers found.</p>
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

    ---

    {{-- 6. RECENT BRANCHES & AGENTS --}}
    {{-- Replaced col-xl-6 with col-lg-6 for better tablet/small desktop layout --}}
    <div class="row">
        {{-- Branches List --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                    <h5 class="card-title mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="ri-building-4-line text-primary me-2"></i>Recent Branches
                    </h5>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end w-100 w-sm-auto">
                        <input type="text" id="branchSearch" class="form-control form-control-sm me-2 flex-grow-1" placeholder="Search..." style="max-width: 150px;">
                        <a href="{{ route('admin.branch.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap flex-shrink-0">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="branchTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
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
                                            <div class="flex-grow-1 ms-2 text-truncate" style="max-width: 100px;">
                                                <span class="small">{{ $branch->bank->bank ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate small" style="max-width: 150px;">{{ $branch->branch_address }}</td>
                                    <td class="text-center">
                                        @if($branch->is_active)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-1 px-2 small">
                                                <i class="ri-checkbox-circle-line me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 py-1 px-2 small">
                                                <i class="ri-close-circle-line me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm flex-wrap gap-1">
                                            <a href="{{ route('admin.branch.index') }}" class="btn btn-outline-primary"><i class="ri-eye-line"></i></a>
                                            <a href="{{ route('admin.branch.edit', $branch->id) }}" class="btn btn-outline-secondary"><i class="ri-edit-line"></i></a>
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

        {{-- Agents List --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                    <h5 class="card-title mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="ri-user-3-line text-info me-2"></i>Recent Agents
                    </h5>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end w-100 w-sm-auto">
                        <input type="text" id="agentSearch" class="form-control form-control-sm me-2 flex-grow-1" placeholder="Search..." style="max-width: 150px;">
                        <a href="{{ route('admin.agent.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap flex-shrink-0">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="agentTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
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
                                            <div class="flex-grow-1 ms-2 text-truncate" style="max-width: 100px;">
                                                <span class="small">{{ $agent->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small">{{ $agent->bank->bank ?? 'N/A' }}</td>
                                    <td class="text-truncate small" style="max-width: 100px;">{{ $agent->branch->branch_address ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($agent->is_active)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-1 px-2 small">
                                                <i class="ri-checkbox-circle-line me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 py-1 px-2 small">
                                                <i class="ri-close-circle-line me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm flex-wrap gap-1">
                                            <a href="{{ route('admin.agent.index') }}" class="btn btn-outline-primary"><i class="ri-eye-line"></i></a>
                                            <a href="{{ route('admin.agent.edit', $agent->id) }}" class="btn btn-outline-secondary"><i class="ri-edit-line"></i></a>
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

    ---

    {{-- 7. APPRAISAL HISTORY SECTIONS --}}
    <div class="row">
        {{-- First Appraisal History --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                    <h5 class="card-title mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="ri-file-chart-line text-primary me-2 fs-4"></i>
                        Recent First Appraisal Certificates
                    </h5>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end w-100 w-sm-auto">
                        <input type="text" id="firstAppraisalSearch" class="form-control form-control-sm me-2 flex-grow-1" placeholder="Search customer..." style="max-width: 150px;">
                        <a href="{{ route('admin.appraisal.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap flex-shrink-0">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="firstAppraisalTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appraisalHistory as $key=> $record)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $key+1}}</td>
                                    <td class="text-truncate small" style="max-width: 100px;">{{ $record->customer->brauser_name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 py-1 px-2 small">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                    <td class="small">
                                        {{ $record->downloaded_at ? \Carbon\Carbon::parse($record->downloaded_at)->format('d M Y') : '—' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.appraisal.downloadAgain', $record->id) }}" class="btn btn-sm btn-success">
                                            <i class="ri-download-2-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr class="no-result">
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ri-file-warning-line fs-1"></i>
                                            <p class="mt-2">No first appraisal records found</p>
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

        {{-- Second Appraisal History --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-3">
                    <h5 class="card-title mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="ri-file-text-line text-warning me-2 fs-4"></i>
                        Recent Second Appraisal Certificates
                    </h5>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end w-100 w-sm-auto">
                        <input type="text" id="secondAppraisalSearch" class="form-control form-control-sm me-2 flex-grow-1" placeholder="Search Ledger Folio..." style="max-width: 150px;">
                        <a href="{{ route('admin.second-appraisal.index') }}" class="btn btn-sm btn-primary d-flex align-items-center text-nowrap flex-shrink-0">
                            <i class="ri-external-link-line me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="secondAppraisalTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Folio No</th>
                                    <th>Loan A/c No</th>
                                    <th>Generated At</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($secondAppraisalHistory as $key=> $record)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $key+1}}</td>
                                    <td class="fw-bold text-primary small">{{ $record->ledger_folio_no }}</td>
                                    <td class="small">{{ $record->gold_loan_account_no }}</td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 py-1 px-2 small">
                                            {{ $record->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.appraisal.downloadSaved', $record->id) }}" class="btn btn-sm btn-success" title="Download Saved Certificate">
                                            <i class="ri-download-2-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr class="no-result">
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ri-file-warning-line fs-1"></i>
                                            <p class="mt-2">No second appraisal certificates found.</p>
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

{{-- STYLES: Minimal changes for better responsiveness --}}
<style>
    /* Gradient remains the same, but reduced font-size on mobile */
    .text-gradient {
        background: linear-gradient(90deg, #ffb800, #f97316, #facc15);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 3rem; /* Default for desktop */
        text-shadow: 1px 1px 5px rgba(255, 187, 0, 0.3);
    }
    /* Media query for smaller screens */
    @media (max-width: 576px) {
        .text-gradient {
            font-size: 2.5rem; /* Smaller on mobile */
        }
    }

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
        flex-shrink: 0; /* Important for alignment on small screens */
    }
    .page-title-box {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    .btn-group-sm .btn {
        border-radius: 0.375rem !important;
        /* Added max-width to ensure buttons don't stretch too much */
        max-width: 50px;
    }
    /* Ensure action buttons in the grid are full height/width and look clean */
    .action-btn {
        min-height: 80px;
        border-width: 2px !important; /* Make the outline more visible */
    }
</style>

{{-- SCRIPTS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to filter tables
        function filterTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const table = document.getElementById(tableId);

            if (!input || !table) return;

            const tbody = table.getElementsByTagName('tbody')[0];
            if (!tbody) return;

            const rows = tbody.getElementsByTagName('tr');

            input.addEventListener('keyup', function() {
                const filter = input.value.toLowerCase();
                let resultsFound = false;

                // Loop through all body rows
                for (let i = 0; i < rows.length; i++) {
                    // Ignore the explicit 'no-result' row during display logic
                    if (rows[i].classList.contains('no-result')) continue;

                    // Get text content of the row
                    const rowText = rows[i].textContent.toLowerCase();

                    if (rowText.includes(filter)) {
                        rows[i].style.display = '';
                        resultsFound = true;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }

                // Show/hide the "No result" message dynamically
                const noResultRow = tbody.querySelector('.no-result');
                if (noResultRow) {
                    noResultRow.style.display = resultsFound ? 'none' : '';
                }
            });
        }

        // Apply Search to tables
        filterTable('branchSearch', 'branchTable');
        filterTable('agentSearch', 'agentTable');
        filterTable('customerSearch', 'customerTable');
        filterTable('firstAppraisalSearch', 'firstAppraisalTable');
        filterTable('secondAppraisalSearch', 'secondAppraisalTable');

        // Initialize tooltips (assuming Bootstrap JS is loaded)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

@endsection