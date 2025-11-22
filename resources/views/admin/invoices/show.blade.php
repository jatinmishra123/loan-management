@extends('admin.layouts.app')

@section('title', 'Invoice #' . $invoice->invoice_no)

@section('content')
<div class="container-fluid">

    {{-- Action Toolbar --}}
    <div class="row mb-4 no-print">
        <div class="col-14">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-light text-muted">
                            <i class="ri-arrow-left-line me-1 align-middle"></i> Back to List
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-outline-primary">
                            <i class="ri-edit-box-line me-1 align-middle"></i> Edit
                        </a>
                        <a href="{{ route('admin.invoices.download', $invoice->id) }}" class="btn btn-success text-white">
                            <i class="ri-file-pdf-line me-1 align-middle"></i> Download PDF
                        </a>
                        <button onclick="window.print()" class="btn btn-dark">
                            <i class="ri-printer-line me-1 align-middle"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Invoice Sheet --}}
    <div class="row justify-content-center">
        <div class="col-lg-14">
            <div class="card border-0 shadow-lg rounded-0" id="invoice-sheet">
                <div class="card-body p-5">

                    {{-- 1. Header (Logo & Status) --}}
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                        <div>
                            {{-- Placeholder Logo --}}
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary text-white rounded p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="ri-building-4-line fs-4"></i>
                                </div>
                                <h3 class="fw-bold text-primary mb-0" style="letter-spacing: -0.5px;">INVOICE</h3>
                            </div>
                            <p class="text-muted small mb-0">Original for Recipient</p>
                        </div>
                        <div class="text-end">
                            <h5 class="fw-bold mb-1 text-dark">#{{ $invoice->invoice_no }}</h5>
                            <p class="text-muted mb-2 small">
                                <i class="ri-calendar-event-line me-1"></i> 
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}
                            </p>
                            
                            {{-- Status Badge --}}
                            @php
                                $status = strtolower($invoice->status ?? 'active');
                                $badgeClass = match($status) {
                                    'paid' => 'bg-success-subtle text-success border-success',
                                    'overdue' => 'bg-danger-subtle text-danger border-danger',
                                    default => 'bg-primary-subtle text-primary border-primary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} border px-3 py-1 rounded-pill text-uppercase fs-11">
                                {{ ucfirst($invoice->status ?? 'Active') }}
                            </span>
                        </div>
                    </div>

                    {{-- 2. Bill To & From --}}
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3">Billed To:</h6>
                            <h5 class="fw-bold text-dark mb-1">{{ $invoice->customer->brauser_name }}</h5>
                            <p class="text-muted small mb-1" style="line-height: 1.6;">
                                {{ $invoice->customer->address ?? 'Address not provided' }}
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="ri-smartphone-line me-1"></i> {{ $invoice->customer->phone ?? '-' }}
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3">Company Details:</h6>
                            <h5 class="fw-bold text-dark mb-1">{{ config('app.name') }}</h5>
                            @if($invoice->company_pan)
                                <p class="text-muted small mb-0">
                                    <strong>UDAYAM / PAN:</strong> {{ strtoupper($invoice->company_pan) }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- 3. Items Table --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase fs-11 text-muted ps-4 py-3" style="width: 60%">Description</th>
                                    <th class="text-uppercase fs-11 text-muted text-end pe-4 py-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="ps-4 py-3">
                                        <span class="fw-semibold text-dark">Invoice Total Amount</span>
                                        @if($invoice->unit)
                                            <div class="small text-muted mt-1">Unit/Qty: {{ $invoice->unit }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4 py-3 fw-bold text-dark">
                                        ₹{{ number_format($invoice->total_amount, 2) }}
                                    </td>
                                </tr>
                                @if($invoice->round_off != 0)
                                <tr>
                                    <td class="ps-4 py-2 text-muted small">Round Off</td>
                                    <td class="text-end pe-4 py-2 text-muted small">
                                        {{ $invoice->round_off > 0 ? '+' : '' }}{{ number_format($invoice->round_off, 2) }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- 4. Totals & Amount in Words --}}
                    <div class="row mb-5">
                        <div class="col-7">
                            <div class="p-3 bg-light rounded border border-light-subtle">
                                <h6 class="text-muted fs-11 fw-bold text-uppercase mb-2">Amount in Words:</h6>
                                <p class="fst-italic text-dark fw-medium mb-0 text-capitalize">
                                    "{{ $invoice->amount_in_words ?? 'Zero' }}"
                                </p>
                            </div>
                        </div>
                        <div class="col-5">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted">Sub Total:</td>
                                    <td class="text-end fw-medium">₹{{ number_format($invoice->total_amount, 2) }}</td>
                                </tr>
                                <tr class="border-top border-dark">
                                    <td class="py-3"><h5 class="fw-bold text-primary mb-0">Total Due:</h5></td>
                                    <td class="text-end py-3"><h5 class="fw-bold text-primary mb-0">₹{{ number_format($invoice->total_amount + ($invoice->round_off ?? 0), 2) }}</h5></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- 5. Footer (Bank & Signature) --}}
                    <div class="row align-items-end pt-4 border-top">
                        <div class="col-7">
                            <h6 class="fw-bold text-dark mb-3 small text-uppercase">Bank Details for Payment:</h6>
                            <ul class="list-unstyled small text-muted mb-0" style="line-height: 1.8;">
                                <li><span class="fw-medium text-dark w-25 d-inline-block">Bank Name:</span> {{ $invoice->bank_name ?? 'N/A' }}</li>
                                <li><span class="fw-medium text-dark w-25 d-inline-block">Account No:</span> {{ $invoice->bank_account_no ?? 'N/A' }}</li>
                                <li><span class="fw-medium text-dark w-25 d-inline-block">IFSC Code:</span> {{ $invoice->ifsc_code ?? 'N/A' }}</li>
                            </ul>
                        </div>
                        <div class="col-5 text-end">
                            <div class="mb-4">
                                {{-- Placeholder for digital signature image if available --}}
                                <div style="height: 40px;"></div> 
                            </div>
                            <p class="fw-bold text-dark mb-0">__________________________</p>
                            <p class="small text-muted mt-1">Authorized Signatory</p>
                        </div>
                    </div>

                    {{-- 6. Thank You Note --}}
                    <div class="text-center mt-5 pt-4">
                        <p class="text-muted small fst-italic">Thank you for your business!</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #invoice-sheet {
        background: #fff;
    }
    
    /* Print specific styles */
    @media print {
        body {
            background: #fff !important;
            font-family: 'Inter', sans-serif;
        }
        
        /* Hide everything */
        .navbar, .sidebar, .footer, .no-print, .page-title-box {
            display: none !important;
        }

        /* Show Invoice */
        #invoice-sheet {
            box-shadow: none !important;
            border: none !important;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        /* Improve contrast for B&W printers */
        .text-primary { color: #000 !important; }
        .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
        .badge { border: 1px solid #000; color: #000 !important; background: transparent !important; }
    }
</style>
@endpush

@endsection