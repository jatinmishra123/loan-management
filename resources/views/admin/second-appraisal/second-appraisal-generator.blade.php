@extends('admin.layouts.app')

@section('title', 'Second Appraisal Generator')

@section('content')
<div class="container py-4">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold mb-0">Generate Second Appraiser Certificate</h3>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.second-appraisal.index') }}" class="btn btn-outline-primary **btn-sm** shadow-sm">
                <i class="ri-list-check-2 me-1"></i> Appraisal List
            </a>
        </div>
    </div>

    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body py-3"> <h5 class="card-title fw-semibold mb-3 text-primary">Select Appraisal Criteria</h5> <div class="row g-3 align-items-end">

                <div class="col-md-5 col-lg-5">
                    <label for="ledger_id" class="form-label fw-semibold **small**">Select Ledger Folio No</label>
                    <select id="ledger_id" class="form-select **form-select-sm**">
                        <option value="">-- Select Ledger Folio --</option>
                        @foreach($ledgers as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->ledger_folio_no }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="item_range" class="form-label fw-semibold **small**">Gold Item Range</label>
                    <select id="item_range" class="form-select **form-select-sm**">
                        <option value="">-- Select Range --</option>
                        <option value="1-5">1 - 5</option>
                        <option value="6-10">6 - 10</option>
                        <option value="11-15">11 - 15</option>
                        <option value="16-20">16 - 20</option>
                    </select>
                </div>

                <div class="col-md-3 col-lg-3 d-grid">
                    <button id="btn_view" class="btn btn-primary **btn-sm**">
                        <i class="ri-eye-line me-1"></i> <span id="btn_text">View Appraisal</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <hr class="my-4"> <div id="appraisal-result" class="mt-4">
        <p class="text-center text-muted small">Select the Ledger Folio and Item Range above to generate the appraisal preview.</p>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a id="btn_download" href="#" class="btn btn-success **btn-sm** shadow-sm" target="_blank" style="display:none;">
            <i class="ri-download-2-line me-1"></i> Download Second Appraisal PDF
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('btn_view').addEventListener('click', function () {

    const ledger = document.getElementById('ledger_id').value;
    const range  = document.getElementById('item_range').value;
    const btnView = document.getElementById('btn_view');
    const btnText = document.getElementById('btn_text');
    const resultDiv = document.getElementById('appraisal-result');
    const btnDownload = document.getElementById('btn_download');

    if (!ledger) {
        alert('⚠️ Please select a Ledger Folio No.');
        return;
    }
    if (!range) {
        alert('⚠️ Please select a gold item range.');
        return;
    }

    // --- 1. Set Loading State (The "Searching" view) ---
    btnView.disabled = true; // Disable button
    btnText.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
    btnDownload.style.display = 'none'; // Hide download button

    resultDiv.innerHTML = `
        <div class="text-center my-4"> <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;"> <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted small">Generating appraisal preview...</p>
        </div>
    `;
    // -----------------------------------------------------------------


    // AJAX to load preview HTML
    fetch(`/admin/second-appraisal/data/${ledger}?range=${range}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }
            return res.text();
        })
        .then(html => {
            resultDiv.innerHTML = html;
            btnDownload.href = `/admin/second-appraisal/pdf/${ledger}?range=${range}`;
            btnDownload.style.display = 'inline-block';
        })
        .catch(err => {
            console.error(err);
            resultDiv.innerHTML = `
                <div class="alert alert-danger text-center shadow **p-2**" role="alert"> <i class="ri-error-warning-line me-2"></i> **Error:** Failed to load appraisal data. Please check your selection and try again.
                </div>
            `;
        })
        .finally(() => {
            // --- 2. Revert Button State ---
            btnView.disabled = false; // Re-enable button
            btnText.innerHTML = 'View Appraisal'; // Revert text
            // ------------------------------------
        });

});
</script>
@endpush