@extends('admin.layouts.app')

@section('title', 'Add Invoice')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        {{-- Changed col-lg-14 to col-lg-10 or 12 for better Bootstrap standard --}}
        <div class="col-lg-12">

            <div class="card border-0 shadow-lg rounded-4">
                
                {{-- Header --}}
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1 text-primary fw-bold">
                                <i class="ri-file-list-3-line align-middle me-1"></i> Add New Invoice
                            </h4>
                            <p class="text-muted mb-0 small">Create a new invoice record for a customer.</p>
                        </div>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-light border">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.invoices.store') }}" method="POST">
                        @csrf

                        {{-- SECTION 1: Customer & Invoice Info --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Basic Information</h6>
                        <div class="row g-3 mb-4">
                            
                            {{-- Customer Selection (Keep select without changes) --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Select Customer <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-user-search-line"></i></span>
                                    <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">-- Search & Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->brauser_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Invoice No --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Invoice No <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-hashtag"></i></span>
                                    <input type="text" name="invoice_no" 
                                            value="{{ old('invoice_no', $generatedInvoiceNo ?? '') }}"
                                            class="form-control @error('invoice_no') is-invalid @enderror" 
                                            readonly>
                                    @error('invoice_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Invoice Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Invoice Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-calendar-event-line"></i></span>
                                    <input type="date" name="invoice_date" 
                                            value="{{ old('invoice_date', date('Y-m-d')) }}"
                                            class="form-control @error('invoice_date') is-invalid @enderror" 
                                            required>
                                    @error('invoice_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        {{-- SECTION 2: Payment Details --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Payment Details</h6>
                        <div class="row g-3 mb-4">
                            
                            {{-- Total Amount (Added ID for JS) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">₹</span>
                                    <input type="number" step="0.01" id="total_amount_input" name="total_amount" 
                                            value="{{ old('total_amount') }}"
                                            class="form-control @error('total_amount') is-invalid @enderror"
                                            placeholder="0.00" required>
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Round Off --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Round Off</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-exchange-dollar-line"></i></span>
                                    <input type="number" step="0.01" name="round_off" 
                                            value="{{ old('round_off') }}"
                                            class="form-control @error('round_off') is-invalid @enderror"
                                            placeholder="0.00">
                                </div>
                            </div>

                            {{-- Unit (Optional) --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Unit (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-scales-3-line"></i></span>
                                    <input type="number" step="0.01" name="unit" 
                                            value="{{ old('unit') }}"
                                            class="form-control" placeholder="Qty">
                                </div>
                            </div>

                            {{-- Amount in Words (Added ID for JS) --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Amount in Words</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-text"></i></span>
                                    <input type="text" id="amount_in_words_input" name="amount_in_words" 
                                            value="{{ old('amount_in_words') }}"
                                            class="form-control @error('amount_in_words') is-invalid @enderror"
                                            placeholder="e.g. Five Thousand Rupees Only">
                                    @error('amount_in_words')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        {{-- SECTION 3: Bank Information --}}
                        <h6 class="text-uppercase text-muted fw-bold fs-12 mb-3">Banking Information</h6>
                        <div class="row g-3">
                            
                            {{-- Bank Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-bank-line"></i></span>
                                    <input type="text" name="bank_name" 
                                            value="{{ old('bank_name') }}"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            placeholder="Enter bank name">
                                </div>
                            </div>

                            {{-- Account Number --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Account No</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-bank-card-line"></i></span>
                                    <input type="text" name="bank_account_no" 
                                            value="{{ old('bank_account_no') }}"
                                            class="form-control @error('bank_account_no') is-invalid @enderror"
                                            placeholder="Enter account number">
                                </div>
                            </div>

                            {{-- IFSC Code --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">IFSC Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-qr-code-line"></i></span>
                                    <input type="text" name="ifsc_code" 
                                            value="{{ old('ifsc_code') }}"
                                            class="form-control @error('ifsc_code') is-invalid @enderror"
                                            placeholder="Enter IFSC code" style="text-transform: uppercase;">
                                </div>
                            </div>

                            {{-- Udayam Number --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Udayam Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-article-line"></i></span>
                                    <input type="text" name="company_pan" 
                                            value="{{ old('company_pan') }}"
                                            class="form-control @error('company_pan') is-invalid @enderror"
                                            placeholder="Enter Udayam Number">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                            <a href="{{ route('admin.invoices.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line align-middle me-1"></i> Save Invoice
                            </button>
                        </div>

                    </form>
                </div> {{-- End Card Body --}}
            </div> {{-- End Card --}}

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalAmountInput = document.getElementById('total_amount_input');
    const amountInWordsInput = document.getElementById('amount_in_words_input');

    if (totalAmountInput && amountInWordsInput) {
        
        // Listen for input changes in the Total Amount field
        totalAmountInput.addEventListener('input', updateAmountInWords);

        // Initial call in case old('total_amount') has a value
        updateAmountInWords();

        function updateAmountInWords() {
            const amount = parseFloat(totalAmountInput.value);

            if (isNaN(amount) || amount <= 0) {
                amountInWordsInput.value = '';
                return;
            }

            // Convert amount to Indian Rupees in words
            const words = convertNumberToWords(amount);
            
            // Set the final value
            amountInWordsInput.value = words + '';
        }

        // --- Core Logic to Convert Number to Words (Indian Numeral System) ---
        function convertNumberToWords(num) {
            const a = [
                '', 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX', 'SEVEN', 'EIGHT', 'NINE', 'TEN',
                'ELEVEN', 'TWELVE', 'THIRTEEN', 'FOURTEEN', 'FIFTEEN', 'SIXTEEN', 'SEVENTEEN', 'EIGHTEEN', 'NINETEEN'
            ];
            const b = [
                '', '', 'TWENTY', 'THIRTY', 'FORTY', 'FIFTY', 'SIXTY', 'SEVENTY', 'EIGHTY', 'NINETY'
            ];
            
            let numStr = num.toFixed(2);
            let [integerPart, decimalPart] = numStr.split('.');

            let finalWords = '';

            // Function to convert 3 digits to words (e.g., 500 => FIVE HUNDRED)
            function inWords(n) {
                let s = '';
                if (n < 20) {
                    s = a[n];
                } else if (n < 100) {
                    s = b[Math.floor(n / 10)] + (n % 10 !== 0 ? ' ' + a[n % 10] : '');
                } else {
                    s = a[Math.floor(n / 100)] + ' HUNDRED' + (n % 100 !== 0 ? ' AND ' + inWords(n % 100) : '');
                }
                return s;
            }

            // Convert integer part (Indian system: Lakhs, Crores)
            // Units: 1 (ones), 2 (tens), 3 (hundreds), 4 (thousands), 5 (ten thousands), 
            // 6 (Lakhs), 7 (ten Lakhs), 8 (Crores)
            
            let n = parseInt(integerPart, 10);
            if (n === 0) {
                finalWords = 'ZERO';
            } else {
                let str = n.toString().padStart(9, '0'); // Pad up to 9 digits (Crore level)
                
                // Breaking down numbers into groups for Indian system
                let crores = parseInt(str.substring(0, 2), 10);
                let lakhs  = parseInt(str.substring(2, 4), 10);
                let thousands = parseInt(str.substring(4, 6), 10);
                let hundreds = parseInt(str.substring(6, 9), 10);

                if (crores > 0) {
                    finalWords += inWords(crores) + ' CRORES ';
                }
                if (lakhs > 0) {
                    finalWords += inWords(lakhs) + ' LAKHS ';
                }
                if (thousands > 0) {
                    finalWords += inWords(thousands) + ' THOUSAND ';
                }
                if (hundreds > 0) {
                    finalWords += inWords(hundreds);
                }
            }
            
            finalWords = finalWords.trim();

            // Handle Decimal/Paise part
            let paise = parseInt(decimalPart, 10);
            if (paise > 0) {
                finalWords += ' AND ' + inWords(paise) + ' PAISE';
            }
            
            // Add RUPEES
            if (finalWords !== 'ZERO') {
                 finalWords = '' + finalWords;
            } else {
                 finalWords = 'ZERO RUPEES';
            }


            return finalWords.trim().toUpperCase();
        }
    }
});
</script>
@endpush