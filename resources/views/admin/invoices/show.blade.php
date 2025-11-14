@extends('admin.layouts.app')

@section('title', 'Invoice Details')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <!-- Header -->
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                    <h4 class="card-title mb-0 fw-semibold text-primary">Invoice Details</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ri-arrow-left-line me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.invoices.download', $invoice->id) }}" class="btn btn-success btn-sm">
                            <i class="ri-download-2-line me-1"></i> PDF
                        </a>
                        <button onclick="window.print()" class="btn btn-primary btn-sm">
                            <i class="ri-printer-line me-1"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4" id="printable-area">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase mb-1">Invoice</h3>
                        <p class="text-muted small">
                            Generated on: {{ $invoice->created_at->format('d M, Y h:i A') }}
                        </p>
                        <hr class="my-3">
                    </div>

                    <!-- Invoice Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-decoration-underline mb-3">Customer Information</h6>
                            <div class="ps-1 small">
                                <p class="mb-1"><strong>Name:</strong> {{ $invoice->customer->brauser_name ?? '—' }}</p>
                                <p class="mb-1"><strong>Address:</strong> {{ $invoice->customer->address ?? '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-bold text-decoration-underline mb-3">Invoice Information</h6>
                            <div class="small">
                                <p class="mb-1"><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</p>
                                <p class="mb-1"><strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</p>
                                <p class="mb-1"><strong>Company PAN:</strong> {{ $invoice->company_pan ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start ps-3">Description</th>
                                    <th class="text-end pe-3">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start ps-3">Total Amount</td>
                                    <td class="text-end pe-3">{{ number_format($invoice->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start ps-3">Round Off</td>
                                    <td class="text-end pe-3">{{ number_format($invoice->round_off ?? 0, 2) }}</td>
                                </tr>
                                <tr class="fw-bold table-active">
                                    <td class="text-start ps-3">Grand Total</td>
                                    <td class="text-end pe-3">
                                        ₹{{ number_format($invoice->total_amount + ($invoice->round_off ?? 0), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Amount in Words -->
                    <div class="mb-4 small">
                        <p><strong>Amount in Words:</strong> {{ $invoice->amount_in_words ?? '—' }}</p>
                    </div>

                    <!-- Bank & Signature -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-decoration-underline mb-3">Bank Details</h6>
                            <div class="small">
                                <p class="mb-1"><strong>Bank Name:</strong> {{ $invoice->bank_name ?? '—' }}</p>
                                <p class="mb-1"><strong>Account No:</strong> {{ $invoice->bank_account_no ?? '—' }}</p>
                                <p class="mb-1"><strong>IFSC Code:</strong> {{ $invoice->ifsc_code ?? '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-bold text-decoration-underline mb-3">Authorized Signature</h6>
                            <div class="mt-5">
                                <p>_________________________</p>
                                <p class="text-muted small mb-0">Authorized Signatory</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🖨️ Print Styles -->
    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #printable-area,
                #printable-area * {
                    visibility: visible;
                }

                #printable-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    padding: 0 20px;
                }

                .btn,
                .sidebar,
                .navbar,
                .footer,
                .card-header {
                    display: none !important;
                }

                .card {
                    border: none !important;
                    box-shadow: none !important;
                }

                table {
                    border-collapse: collapse !important;
                    width: 100%;
                }

                table th,
                table td {
                    border: 1px solid #000 !important;
                    padding: 8px !important;
                }

                h3,
                h6,
                p {
                    color: #000 !important;
                }
            }
        </style>
    @endpush
@endsection