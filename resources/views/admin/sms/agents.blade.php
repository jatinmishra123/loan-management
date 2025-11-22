@extends('admin.layouts.app')

@section('content')

<style>
    /* Highlight selected rows */
    tr.selected-row {
        background-color: #eaf3ff !important;
    }

    /* Make header sticky */
    .sms-header {
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background: #f1f4f8 !important;
        font-weight: 600;
    }
</style>

<div class="card shadow-sm">

    <!-- Header -->
    <div class="sms-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="ri-chat-smile-2-line me-1"></i> Send SMS to Master
        </h4>
        <span class="badge bg-primary">Total Agents: {{ count($agents) }}</span>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- SMS Form -->
        <form method="POST" action="{{ route('admin.sms.agents.send') }}">
            @csrf

            <!-- Message Box -->
            <div class="mb-4">
                <label class="form-label fw-bold">Message (Max 160 characters)</label>
                <textarea name="message" class="form-control shadow-sm" rows="3" placeholder="Type your SMS here..." required></textarea>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="text-center">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="select_all">
                            </th>
                            <th>Sr.N</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email</th>
                            <th>Designation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($agents as $key=> $agent)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="single" name="ids[]" value="{{ $agent->id }}">
                            </td>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->mobile_number }}</td>
                            <td>{{ $agent->email }}</td>
                            <td>{{ $agent->designation }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 py-2">
                    <i class="ri-send-plane-2-line me-1"></i> Send SMS
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    // Select All Checkbox
    document.getElementById('select_all').addEventListener('click', function() {
        const all = document.querySelectorAll('.single');
        all.forEach(ch => {
            ch.checked = this.checked;
            ch.closest('tr').classList.toggle('selected-row', ch.checked);
        });
    });

    // Individual checkbox highlight row
    document.querySelectorAll('.single').forEach(ch => {
        ch.addEventListener('change', function() {
            this.closest('tr').classList.toggle('selected-row', this.checked);
        });
    });
</script>

@endsection
