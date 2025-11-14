<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->invoice_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        .invoice-box {
            width: 100%;
            border: 1px solid #000;
            padding: 10px 15px;
        }

        h2,
        h3,
        h4,
        h5 {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 5px 6px;
            vertical-align: middle;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .no-border td,
        .no-border th {
            border: none !important;
        }

        .small {
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="invoice-box">

        <h3 class="text-center" style="font-family: Georgia, serif;">Vaibhav Shree Jewellers</h3>
        <p class="text-center small">Elimgahat, Laheriasarai, Darbhanga</p>

        <hr style="border: 1px solid #000;">

        <h4 class="text-center" style="font-family: serif; margin-top: 5px;">INVOICE</h4>

        <table>
            <tr>
                <td colspan="2"><strong>To:</strong><br>State Bank of India</td>
                <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Branch:</strong> {{ $invoice->branch_name ?? '—' }}</td>
                <td><strong>Ref No:</strong> {{ $invoice->invoice_no }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Customer Name:</strong> {{ $invoice->customer->brauser_name ?? '—' }}</td>
            </tr>
        </table>

        <table class="text-center" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th>Description of Goods</th>
                    <th>QTY</th>
                    <th>RATE</th>
                    <th>Amount</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gold Appraised Charges</td>
                    <td>1</td>
                    <td>600</td>
                    <td>600</td>
                    <td>600</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Sub Total</strong></td>
                    <td colspan="2" class="text-end">₹{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Round Off</strong></td>
                    <td colspan="2" class="text-end">{{ number_format($invoice->round_off ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td colspan="2" class="text-end fw-bold">
                        ₹{{ number_format($invoice->total_amount + ($invoice->round_off ?? 0), 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 10px;">
            <strong>Amount Chargeable (in words):</strong> {{ $invoice->amount_in_words ?? '—' }}
        </p>

        <table style="margin-top: 15px;">
            <tr>
                <td><strong>A/C No.:</strong></td>
                <td>{{ $invoice->bank_account_no ?? '—' }}</td>
            </tr>
            <tr>
                <td><strong>Bank:</strong></td>
                <td>{{ $invoice->bank_name ?? '—' }}</td>
            </tr>
            <tr>
                <td><strong>IFSC:</strong></td>
                <td>{{ $invoice->ifsc_code ?? '—' }}</td>
            </tr>
           
        </table>

        <p class="text-center small" style="margin-top: 10px;">
            This is a computer-generated invoice. No signature required.
        </p>
    </div>
</body>

</html>