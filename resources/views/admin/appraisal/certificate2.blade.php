<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Second Appraiser Verification Certificate</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        .certificate {
            border: 1px solid #000;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        .no-border td {
            border: none !important;
        }

        .header-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .sub-text {
            text-align: center;
            margin-bottom: 10px;
        }

        .right {
            text-align: right;
        }

        /* --- STYLES FOR DATE & QR CODE ROW --- */
        .date-qr-section {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .date-block {
            display: table-cell;
            width: 70%;
            text-align: right;
            vertical-align: top;
            padding-top: 10px;
            padding-right: 10px;
        }

        .header-qr {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: top;
        }

        .header-qr img {
            width: 100px;
            height: 100px;
        }

        .signature-table-alt {
            width: 100%;
            border: 0;
            margin-top: 25px;
            font-size: 12px;
            page-break-inside: avoid;
        }
        .signature-table-alt td {
            width: 50%;
            border: 0;
            vertical-align: top;
            padding: 0;
        }

        .footer {
            margin-top: 15px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="certificate">

        <div class="header-title">Second Appraiser Verification Certificate</div>
        <div class="sub-text">(To be obtained in Duplicate for Gold Loan Verification During RFIA)</div>

        <div class="date-qr-section">
            <div class="date-block">
                Date: {{ now()->format('d-M-Y') }}
            </div>
            
            <div class="header-qr"> 
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
            </div>
        </div>

        {{-- UPPER INFO TABLE --}}
        <table>
            <tr>
                <th width="30%">Gold Loan A/c No</th>
                <td>{{ $customer->loan_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Ledger Folio No</th>
                <td>{{ $customer->ledger_folio_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Name & address of 1st appraiser</th>
                <td>{{ $admin->name }} — {{ $admin->address }}</td>
            </tr>
            <tr>
                <th>Date of Appraiser’s Certificate</th>
                <td>{{ $customer->date ? $customer->date->format('d/m/Y') : now()->format('d/m/Y') }}</td>
            </tr>
        </table>
        
        {{-- --- PHP LOGIC FOR BANK FULL FORM --- --}}
        @php
            // Get the bank name from database, force lowercase for comparison
            $rawBank = strtolower($customer->bank->bank ?? '');
            
            // Define mapping for short forms
            $bankList = [
                'sbi'    => 'State Bank of India',
                'bob'    => 'Bank of Baroda',
                'pnb'    => 'Punjab National Bank',
                'boi'    => 'Bank of India',
                'hdfc'   => 'HDFC Bank',
                'icici'  => 'ICICI Bank',
                'canara' => 'Canara Bank',
                'union'  => 'Union Bank of India',
                'idbi'   => 'IDBI Bank',
                'cbi'    => 'Central Bank of India',
                'iob'    => 'Indian Overseas Bank'
            ];

            // Check if abbreviation exists in list, otherwise just Capitalize the original text
            $finalBankName = $bankList[$rawBank] ?? ucwords($customer->bank->bank ?? 'Bank Name');
        @endphp

        <br> 
        <p>
            The Branch Manager, <br>
            
            {{-- Display Full Bank Name --}}
            <b style="font-size: 14px;">{{ $finalBankName }}</b> <br>
            
            {{-- Display Branch Address --}}
            {{ $customer->branch->branch_address ?? 'Branch Address' }} <br>

            {{-- Display Code (Branch Name ke niche/bagal me) --}}
            <span style="font-weight: bold;">
                (Branch Code: {{ $customer->bank->bank_code ?? $customer->branch->branch_code ?? 'N/A' }})
            </span>
        </p>

        <p>
            Madam/Dear Sir,<br><br>

            I hereby certify that the ornaments/Coins of the above mentioned gold loan account have been
            weighed and appraised by me on
            <b>{{ $customer->date ? $customer->date->format('d/m/Y') : '________' }}</b>
            in the presence of Sri/Smt.
            <b>{{ $customer->cash_incharge ?? '_____________' }}</b> (Cash in charge)
            and Sri/Smt.
            <b>{{ $customer->joint_custody_officer ?? '_____________' }}</b> (Joint Custody Officer)

            The exact weight, purity of the metal and market value of each item are indicated below:
        </p>

        {{-- GOLD ITEMS TABLE --}}
        <table>
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Description of Article</th>
                    <th>Gross Weight</th>
                    <th>Approx Purity of the Article (Carat)</th>
                    <th>Net Weight (Grams)</th>
                    <th>Market Value (Rs)</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                    $gross = $net = $total = 0;
                @endphp

                @foreach($items as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ number_format($item->gross_weight, 2) }}</td>
                        <td>{{ $item->purity }}</td>
                        <td>{{ number_format($item->net_weight, 2) }}</td>
                        <td>{{ number_format($item->market_value, 2) }}</td>
                    </tr>

                    @php
                        $gross += $item->gross_weight;
                        $net += $item->net_weight;
                        $total += $item->market_value;
                    @endphp
                @endforeach

                <tr>
                    <th colspan="2">TOTAL</th>
                    <th>{{ number_format($gross, 2) }}</th>
                    <th></th>
                    <th>{{ number_format($net, 2) }}</th>
                    <th>{{ number_format($total, 2) }}</th>
                </tr>
            </tbody>
        </table>

        <br>

        <p>
            <b>Method(s) used for purity testing:</b> _______________________________________
        </p>

        <p>
            I solemnly declare that weight & purity of the gold ornaments/precious stones
            indicated above are correct and I undertake to indemnify the Bank against any
            loss it may sustain on account of any inaccuracy in appraisal.
        </p>

        <table class="signature-table-alt">
            <tr>
                <td style="text-align: left;">
                    Yours faithfully <br><br><br><br>
Cash Officer in Charge                </td>
                <td style="text-align: right;">
                    <br><br><br><br>
                    (Seal)
                </td>
            </tr>
        </table>

        <br><br>

        <table class="no-border" style="width:100%; margin-top:20px;">
            <tr class="no-border">
                <td class="no-border" width="50%" style="text-align:right;">Name & Signature of the Appraiser
</td>
                <td class="no-border right" width="50%">Joint Custody Officer</td>
            </tr>
        </table>
        <div class="footer">
            Design & Developed by Jatin Mishra
        </div>

    </div>

</body>
</html>