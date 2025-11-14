@extends('admin.layouts.app')

@section('title', 'Appraisal Generator')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-center fw-bold">Generate Appraiser Certificate</h3>

    <!-- Selection Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <!-- Customer Dropdown -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Customer</label>
                    <select id="customer_id" class="form-select">
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->brauser_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Appraisal Type -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Select Appraisal Type</label>
                    <select id="appraisal_type" class="form-select">
                        <option value="">-- Select Type --</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- GOLD ITEM RANGE -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Gold Item Range</label>
                    <select id="item_range" class="form-select">
                        <option value="">-- Select Range --</option>
                        <option value="1-5">1 - 5</option>
                        <option value="6-10">6 - 10</option>
                        <option value="11-15">11 - 15</option>
                        <option value="16-20">16 - 20</option>
                    </select>
                </div>

                <!-- View Button -->
                <div class="col-md-2 d-grid">
                    <button id="btn_view" class="btn btn-primary">
                        <i class="ri-eye-line me-1"></i> View
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Appraisal Certificate HTML -->
    <div id="appraisal-result" class="mt-4"></div>

    <!-- Download Button -->
    <div class="text-end mt-3">
        <a id="btn_download" href="#" class="btn btn-success" target="_blank" style="display:none;">
            <i class="ri-download-2-line me-1"></i> Download PDF
        </a>
    </div>

</div>
@endsection


@push('scripts')
<script>
document.getElementById('btn_view').addEventListener('click', function () {

    const customer = document.getElementById('customer_id').value;
    const type     = document.getElementById('appraisal_type').value;
    const range    = document.getElementById('item_range').value;

    if (!customer) {
        alert('⚠️ Please select a customer.');
        return;
    }
    if (!type) {
        alert('⚠️ Please select appraisal type.');
        return;
    }
    if (!range) {
        alert('⚠️ Please select gold item range.');
        return;
    }

    // Loading animation
    document.getElementById('appraisal-result').innerHTML = `
        <div class="text-center my-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Loading appraisal...</p>
        </div>
    `;

    // AJAX Call with range
    fetch(`/admin/appraisal/data/${customer}/${type}?range=${range}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('appraisal-result').innerHTML = html;

            // Show PDF button
            let btn = document.getElementById('btn_download');
            btn.href = `/admin/appraisal/pdf/${customer}/${type}?range=${range}`;
            btn.style.display = 'inline-block';
        })
        .catch(err => {
            console.error(err);
            alert('Error loading appraisal certificate.');
        });

});
</script>
@endpush
