@extends('admin.layouts.app')

@section('title', 'Add Second Gold Item')

@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">

        <div class="card shadow-sm border-0">

            {{-- Header --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold text-primary mb-0">Add Second Gold Item</h4>
                {{-- FIX: Updated route to second_gold_items.index --}}
                <a href="{{ route('admin.second_gold_items.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body">
                {{-- FIX: Updated route to second_gold_items.store --}}
                <form action="{{ route('admin.second_gold_items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                      <label class="form-label">Select Ledger Folio No <span class="text-danger">*</span></label>
<select name="ledger_folio_no" class="form-select @error('ledger_folio_no') is-invalid @enderror" required>
    <option value="">-- Select Ledger Folio No --</option>
    @foreach ($folios as $folio)
        <option value="{{ $folio->ledger_folio_no }}"
            {{ old('ledger_folio_no') == $folio->ledger_folio_no ? 'selected' : '' }}>
            {{ $folio->ledger_folio_no }}
        </option>
    @endforeach
</select>
@error('ledger_folio_no')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror


                        {{-- Description --}}
                        <div class="col-md-6">
                            <label class="form-label">Gold Item Description <span class="text-danger">*</span></label>
                            <input type="text" name="description" placeholder="Enter gold item name or details"
                                   class="form-control @error('description') is-invalid @enderror"
                                   value="{{ old('description') }}" required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-4">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" placeholder="e.g. 1"
                                   min="1" class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity', 1) }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gross Weight --}}
                        <div class="col-md-4">
                            <label class="form-label">Gross Weight (g) <span class="text-danger">*</span></label>
                            <input type="number" name="gross_weight" id="gross_weight" step="0.01" placeholder="e.g. 12.50"
                                   class="form-control @error('gross_weight') is-invalid @enderror"
                                   value="{{ old('gross_weight') }}" required>
                            @error('gross_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stone Weight --}}
                        <div class="col-md-4">
                            <label class="form-label">Stone Weight (g)</label>
                            <input type="number" name="stone_weight" id="stone_weight" step="0.01" placeholder="e.g. 0.25"
                                   class="form-control @error('stone_weight') is-invalid @enderror"
                                   value="{{ old('stone_weight') }}">
                            @error('stone_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Net Weight (Auto) --}}
                        <div class="col-md-4">
                            <label class="form-label">Net Weight (g)</label>
                            <input type="number" name="net_weight" id="net_weight" step="0.01"
                                   placeholder="Auto calculated"
                                   class="form-control" readonly>
                        </div>

                        {{-- Purity --}}
                        <div class="col-md-4">
                            <label class="form-label">Purity (Carat) <span class="text-danger">*</span></label>
                            <input type="number" name="purity" id="purity" min="1" max="24"
                                   placeholder="e.g. 22"
                                   class="form-control @error('purity') is-invalid @enderror"
                                   value="{{ old('purity') }}" required>
                            @error('purity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Rate Per Gram (Auto) --}}
                        <div class="col-md-4">
                            <label class="form-label">Rate per Gram (₹)</label>
                            <input type="number" step="0.01" name="rate_per_gram" id="rate_per_gram"
                                   placeholder="Auto calculated" readonly
                                   class="form-control @error('rate_per_gram') is-invalid @enderror">
                            @error('rate_per_gram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="col-md-4">
                            <label class="form-label">Gold Item Image</label>
                            <input type="file" name="image" accept="image/*" id="imageInput"
                                   class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2 text-center">
                                <img id="imagePreview" src="#" style="display:none; width:140px; height:140px; object-fit:cover;"
                                     class="border rounded">
                            </div>
                        </div>

                        {{-- Remarks --}}
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" placeholder="Enter any notes or additional remarks"
                                      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Save Gold Item
                        </button>
                        {{-- FIX: Updated route to second_gold_items.index --}}
                        <a href="{{ route('admin.second_gold_items.index') }}" class="btn btn-light">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    let basePrice = 0;

    // Fetch latest gold base price (assuming this route is common for both modules)
    fetch(`{{ route('admin.goldprice.latest') }}`)
        .then(res => res.json())
        .then(data => basePrice = parseFloat(data.price ?? 0));

    const gross = document.getElementById('gross_weight');
    const stone = document.getElementById('stone_weight');
    const net = document.getElementById('net_weight');
    const purity = document.getElementById('purity');
    const rate = document.getElementById('rate_per_gram');

    // Calculate Net Weight
    function updateNetWeight() {
        const g = parseFloat(gross.value) || 0;
        const s = parseFloat(stone.value) || 0;

        if (g > 0) {
            net.value = (g - s).toFixed(2);
        } else {
            net.value = "";
        }
    }

    // Calculate Rate per Gram
    function updateRate() {
        const p = parseFloat(purity.value) || 0;

        if (p > 0 && p <= 24 && basePrice > 0) {
            rate.value = ((basePrice * p) / 24).toFixed(2);
        } else {
            rate.value = "";
        }
    }

    // Listeners
    gross.addEventListener('input', () => { updateNetWeight(); updateRate(); });
    stone.addEventListener('input', () => { updateNetWeight(); updateRate(); });
    purity.addEventListener('input', updateRate);
    
    // Image Preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    
    if(imageInput) {
        imageInput.addEventListener('change', function(e) {
            if(e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'inline-block';
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});
</script>
@endpush