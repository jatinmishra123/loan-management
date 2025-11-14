@extends('admin.layouts.app')

@section('title', 'Edit Gold Item')

@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">

        <div class="card shadow-sm border-0">

            <!-- Header -->
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-primary">Edit Gold Item</h4>
                <a href="{{ route('admin.gold_items.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Body -->
            <div class="card-body">
                <form action="{{ route('admin.gold_items.update', $gold_item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Customer -->
                        <div class="col-md-6">
                            <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $gold_item->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->brauser_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label class="form-label">Gold Item Description <span class="text-danger">*</span></label>
                            <input type="text" name="description"
                                   value="{{ old('description', $gold_item->description) }}"
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
                                   value="{{ old('quantity', $gold_item->quantity) }}"
                                   class="form-control @error('quantity') is-invalid @enderror" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gross Weight -->
                        <div class="col-md-4">
                            <label class="form-label">Gross Weight (g) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="gross_weight"
                                   value="{{ old('gross_weight', $gold_item->gross_weight) }}"
                                   class="form-control @error('gross_weight') is-invalid @enderror" required>
                            @error('gross_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stone Weight -->
                        <div class="col-md-4">
                            <label class="form-label">Stone Weight (g) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="stone_weight"
                                   value="{{ old('stone_weight', $gold_item->stone_weight) }}"
                                   class="form-control @error('stone_weight') is-invalid @enderror" required>
                            @error('stone_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purity -->
                        <div class="col-md-4">
                            <label class="form-label">Purity (Carat) <span class="text-danger">*</span></label>
                            <input type="number" name="purity" id="purity"
                                   value="{{ old('purity', $gold_item->purity) }}"
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
                                   value="{{ old('rate_per_gram', $gold_item->rate_per_gram) }}"
                                   class="form-control @error('rate_per_gram') is-invalid @enderror"
                                   readonly required>
                            @error('rate_per_gram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3"
                                      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $gold_item->remarks) }}</textarea>
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
                                <img id="preview" src="{{ $gold_item->image ? asset('storage/' . $gold_item->image) : '' }}"
                                     style="width:140px;height:140px;object-fit:cover;"
                                     class="border rounded {{ $gold_item->image ? '' : 'd-none' }}">
                            </div>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save me-1"></i> Update Gold Item
                        </button>
                        <a href="{{ route('admin.gold_items.index') }}" class="btn btn-light">
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
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    });


    // -----------------------------
    // AUTO RATE CALCULATION
    // -----------------------------
    document.addEventListener('DOMContentLoaded', function () {

        let basePrice = 0;

        fetch(`{{ route('admin.goldprice.latest') }}`)
            .then(res => res.json())
            .then(data => {
                basePrice = parseFloat(data.price ?? 0);
            });

        const purityInput = document.getElementById('purity');
        const rateInput = document.getElementById('rate_per_gram');

        purityInput.addEventListener('input', function () {
            let purity = parseFloat(this.value);

            if (!isNaN(purity) && purity > 0 && purity <= 24 && basePrice > 0) {
                let rate = (basePrice * purity) / 24;
                rateInput.value = rate.toFixed(2);
            } else {
                rateInput.value = "";
            }
        });
    });
</script>
@endpush
