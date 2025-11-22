@extends('admin.layouts.app')

@section('title', 'Edit Gold Item')

@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">

        <div class="card shadow-sm border-0">

            <!-- Header -->
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-primary">Edit Gold Item</h4>
                <a href="{{ route('admin.second_gold_items.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Body -->
            <div class="card-body">
                <form action="{{ route('admin.second_gold_items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Ledger Folio No -->
                        <div class="col-md-6">
                            <label class="form-label">Ledger Folio No <span class="text-danger">*</span></label>
                            <select name="ledger_folio_no" class="form-select @error('ledger_folio_no') is-invalid @enderror" required>
                                <option value="">-- Select Ledger Folio No --</option>
                                @foreach ($folios as $folio)
                                    <option value="{{ $folio->ledger_folio_no }}"
                                        {{ old('ledger_folio_no', $item->ledger_folio_no) == $folio->ledger_folio_no ? 'selected' : '' }}>
                                        {{ $folio->ledger_folio_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ledger_folio_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label class="form-label">Gold Item Description <span class="text-danger">*</span></label>
                            <input type="text" name="description"
                                   value="{{ old('description', $item->description) }}"
                                   class="form-control @error('description') is-invalid @enderror"
                                   required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-4">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" min="1"
                                   value="{{ old('quantity', $item->quantity) }}"
                                   class="form-control @error('quantity') is-invalid @enderror" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gross Weight -->
                        <div class="col-md-4">
                            <label class="form-label">Gross Weight (g) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="gross_weight"
                                   value="{{ old('gross_weight', $item->gross_weight) }}"
                                   class="form-control @error('gross_weight') is-invalid @enderror" required>
                            @error('gross_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stone Weight -->
                        <div class="col-md-4">
                            <label class="form-label">Stone Weight (g)</label>
                            <input type="number" step="0.01" name="stone_weight"
                                   value="{{ old('stone_weight', $item->stone_weight) }}"
                                   class="form-control @error('stone_weight') is-invalid @enderror">
                            @error('stone_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purity -->
                        <div class="col-md-4">
                            <label class="form-label">Purity (Carat) <span class="text-danger">*</span></label>
                            <input type="number" name="purity" id="purity"
                                   value="{{ old('purity', $item->purity) }}"
                                   class="form-control @error('purity') is-invalid @enderror"
                                   placeholder="e.g. 22, 24" min="1" max="24" required>
                            @error('purity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rate per Gram -->
                        <div class="col-md-4">
                            <label class="form-label">Rate per Gram (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="rate_per_gram" id="rate_per_gram"
                                   value="{{ old('rate_per_gram', $item->rate_per_gram) }}"
                                   class="form-control @error('rate_per_gram') is-invalid @enderror"
                                   readonly required>
                            @error('rate_per_gram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Net Weight (optional readonly) -->
                        <div class="col-md-4">
                            <label class="form-label">Net Weight (g)</label>
                            <input type="number" step="0.01" name="net_weight" id="net_weight"
                                   value="{{ old('net_weight', $item->net_weight) }}"
                                   class="form-control @error('net_weight') is-invalid @enderror" readonly>
                            @error('net_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3"
                                      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $item->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-4">
                            <label class="form-label">Gold Item Image</label>
                            <input type="file" name="image" accept="image/*"
                                   class="form-control @error('image') is-invalid @enderror" id="imageInput">

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-2">
                                <img id="preview" src="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
                                     style="width:140px;height:140px;object-fit:cover;"
                                     class="border rounded {{ $item->image ? '' : 'd-none' }}">
                            </div>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save me-1"></i> Update Gold Item
                        </button>
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
    // -----------------------------
    // IMAGE PREVIEW
    // -----------------------------
    const imageInput = document.getElementById('imageInput');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });
    }

    // -----------------------------
    // AUTO RATE CALCULATION & NET WEIGHT
    // -----------------------------
    document.addEventListener('DOMContentLoaded', function () {

        let basePrice = 0;

        fetch(`{{ route('admin.goldprice.latest') }}`)
            .then(res => res.json())
            .then(data => {
                basePrice = parseFloat(data.price ?? 0);
            })
            .catch(()=>{ basePrice = 0; });

        const purityInput = document.getElementById('purity');
        const rateInput = document.getElementById('rate_per_gram');
        const grossInput = document.querySelector('input[name="gross_weight"]');
        const stoneInput = document.querySelector('input[name="stone_weight"]');
        const netInput = document.getElementById('net_weight');

        function updateNet() {
            const g = parseFloat(grossInput?.value) || 0;
            const s = parseFloat(stoneInput?.value) || 0;
            if (g > 0) netInput.value = (g - s).toFixed(2);
            else netInput.value = '';
        }

        function updateRate() {
            const purity = parseFloat(purityInput?.value) || 0;
            if (!isNaN(purity) && purity > 0 && purity <= 24 && basePrice > 0) {
                let rate = (basePrice * purity) / 24;
                rateInput.value = rate.toFixed(2);
            } else {
                rateInput.value = "";
            }
        }

        purityInput?.addEventListener('input', updateRate);
        grossInput?.addEventListener('input', updateNet);
        stoneInput?.addEventListener('input', updateNet);

    });
</script>
@endpush
