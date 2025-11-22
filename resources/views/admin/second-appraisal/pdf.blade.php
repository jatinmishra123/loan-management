<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Second Appraiser Verification Certificate</title>

    <style>
        body {
            /* Reduced overall margin */
            font-family: "Times New Roman", serif;
            font-size: 11.5px; /* Slightly reduced font size */
            margin: 10px; /* Reduced from 20px */
            color: #000;
        }

        .certificate {
            /* Reduced padding */
            border: 1px solid #000;
            padding: 10px; /* Reduced from 20px */
            /* Crucial: Prevents the entire content from breaking if possible */
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px; /* Match body font size */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px 4px; /* Reduced padding in cells */
            text-align: center;
        }
        
        .items-table {
            /* Crucial: Prevents the main gold items table from breaking across pages */
            page-break-inside: avoid;
        }

        .items-table th {
            vertical-align: top;
            padding: 5px 4px;
        }

        .no-border td {
            border: none !important;
        }

        .header-title {
            text-align: center;
            font-size: 25px; /* Slightly reduced font size */
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px; /* Reduced margin */
        }

        .sub-text {
            text-align: center;
            font-size: 15px;
            margin-bottom: 5px; /* Reduced margin */
        }

        .right {
            text-align: right;
        }
        
        /* QR Code and Date Table Styles */
        .qr-date-table {
            width: 100%;
            border: none;
            margin-bottom: 5px; /* Reduced margin */
        }
        .qr-date-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }
        .qr-date-table .date-col {
            width: 70%;
            text-align: right;
            padding-top: 5px;
        }
        .qr-date-table .qr-col {
            width: 30%;
            text-align: right; 
        }
        .qr-date-table .qr-col img {
            width: 80px; /* Reduced QR size slightly */
            height: 80px;
            display: block; 
            margin-left: auto; 
        }
        
        /* Signature Styles */
        .signature-table-bottom {
            width: 100%;
            border: 0;
            margin-top: 30px; /* Reduced margin before signature block */
            font-size: 11px; /* Slightly smaller text for signatures */
            page-break-inside: avoid; /* Crucial: Keeps signatures together */
        }
        .signature-table-bottom td {
            width: 50%;
            border: 0;
            vertical-align: top;
            padding: 0;
        }

        .footer {
            margin-top: 10px; /* Reduced margin */
            font-size: 9px; /* Reduced footer size */
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="certificate">

        <div class="header-title">Second Appraiser Verification Certificate</div>
        <div class="sub-text">(To be obtained in Duplicate for Gold Loan Verification During RFIA)</div>

        {{-- QR CODE & DATE SECTION --}}
        <table class="qr-date-table">
            <tr>
                <td class="date-col">
                </td>
                <td class="qr-col">
                    <p style="margin: 0 0 3px 0;">Date: {{ now()->format('d-M-Y') }}</p>
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                </td>
            </tr>
        </table>
        
        {{-- TOP DETAIL TABLE --}}
        <table>
            <tr>
                <th width="30%">Gold Loan A/c No</th>
                <td>{{ $customer->gold_loan_account_no ?? '4357677577-8' }}</td>
            </tr>
            <tr>
                <th>Ledger Folio No</th>
                <td>{{ $customer->ledger_folio_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Name and address of first appraiser</th>
                <td>{{ $admin->name ?? 'Vaibhav Shree Jewellers' }}</td>
            </tr>
            <tr>
                <th>Date of Appraiser's Certificate</th>
                <td>{{ $customer->second_appraisal_date ? \Carbon\Carbon::parse($customer->second_appraisal_date)->format('d/m/Y') : '22/06/2025' }}</td>
            </tr>
        </table>
        
        {{-- BANK ADDRESS BLOCK --}}
        @php
            $rawBank = strtolower($customer->bank->bank ?? '');
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
                'iob'    => 'Indian Overseas Bank',
                'uboi'   => 'Union Bank of India',
            ];
            $bankName = $bankList[$rawBank] ?? ucwords($customer->bank->bank ?? 'Bank Name');
            
            $branchAddress = $customer->branch->branch_address ?? 'Tilak Nagar';
            $branchCode = $customer->branch->branch_code ?? '11829';
            $appraisalDate = $customer->second_appraisal_date ? \Carbon\Carbon::parse($customer->second_appraisal_date)->format('d/m/Y') : '________';
        @endphp
        
        <p style="margin-top: 10px;">
            The Branch Manager, <br>
            
            <b style="font-size: 13px;">{{ $bankName }}</b> <br>
            
            {{ $branchAddress ?? 'Branch Address' }} 
            (<span style="font-weight: bold;">Branch Code: {{ $branchCode ?? 'N/A' }}</span>)
        </p>

        <p style="margin-top: 5px;">
            Madam Dear Sir,
        </p>
        
        {{-- CERTIFICATE BODY TEXT --}}
        <p style="line-height: 1.4; text-align: justify; margin-top: 5px;">
            I hereby certify that the ornaments/Coins of the above mentioned gold loan account have been
            weighed and appraised by me on 
            <b style="border-bottom: 1px solid #000; padding: 0 5px;">{{ $admin->name ?? 'Rajesh Kumar' }}</b>
            in the presence of Sri/Smt.
            <b style="border-bottom: 1px solid #000; padding: 0 5px;">{{ $customer->cash_incharge ?? 'Omkar Mahto' }}</b> (Cash in charge) and Sri/Smt.
            <b style="border-bottom: 1px solid #000; padding: 0 5px;">{{ $customer->joint_custody_officer ?? 'Murari Kumar Roy' }}</b> (Joint Custody Officer) The exact weight, purity of the metal and market value of
            each item as on date are indicated below:
        </p>

        {{-- GOLD ITEMS TABLE (Market Value Calculated) --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">S No</th>
                    <th width="20%">Description of the Article/Unit</th>
                    <th width="15%">Gross Weight</th>
                    <th width="18%">Approximate weight of the precious stones in the ornaments (Grams)</th>
                    <th width="12%">Purity (Carat)</th>
                    <th width="15%">Net Weight (Grams)</th>
                    <th width="15%">Market Value Rs</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                    $gross = $precious = $net = $total = 0;
                @endphp

                @forelse($items as $item)
                    @php
                        $marketValue = ($item->net_weight ?? 0) * ($item->rate_per_gram ?? 0);

                        $itemStoneWeight = $item->stone_weight ?? 0;
                        $itemNetWeight = $item->net_weight ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td style="text-align: left; padding-left: 8px;">{{ $item->description }}</td>
                        <td>{{ number_format($item->gross_weight ?? 0, 3) }}</td>
                        <td>{{ number_format($itemStoneWeight, 3) }}</td>
                        <td>{{ $item->purity ?? '' }}</td>
                        <td>{{ number_format($itemNetWeight, 3) }}</td>
                        <td style="text-align: right; padding-right: 8px;">{{ number_format($marketValue, 2) }}</td>
                    </tr>

                    @php
                        $gross    += $item->gross_weight ?? 0;
                        $precious += $itemStoneWeight;
                        $net      += $itemNetWeight;
                        $total    += $marketValue;
                    @endphp
                @empty
                    {{-- Default empty rows for presentation --}}
                    @for ($j = 1; $j <= 6; $j++)
                        <tr>
                            <td>{{ $j }}</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                    @php $i = 7; @endphp
                @endforelse

                {{-- Empty padding rows to reach a minimum of 6 rows --}}
                @for ($j = $i; $j <= 6; $j++) 
                    <tr>
                        <td>{{ $j }}</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                
                {{-- TOTAL ROW --}}
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <th colspan="2" style="text-align: center;">Total({{ $i - 1 }})</th>
                    <th>{{ number_format($gross, 3) }}</th>
                    <th>{{ number_format($precious, 3) }}</th>
                    <th></th>
                    <th>{{ number_format($net, 3) }}</th>
                    <th style="text-align: right; padding-right: 8px;">{{ number_format($total, 2) }}</th>
                </tr>
            </tbody>
        </table>

        <br>

        <p style="margin-bottom: 5px;">
            <b>Method(s)* used for purity testing:</b> _______________________________________
        </p>

        <p style="line-height: 1.4; text-align: justify;">
            I solemnly declare that weight & purity of the gold ornaments/precious stones
            indicated above are correct and I undertake to indemnify the Bank against any
            loss it may sustain on account of any inaccuracy in appraisal.
        </p>
        
        {{-- SIGNATURE SECTION --}}
        
        <p class="right" style="margin-top: 20px; margin-bottom: 20px;">
            Yours faithfully
        </p>
        
      <p class="right" style="margin-top: 15px; font-weight: bold;">
    Name & Signature of the Appraiser &nbsp;&nbsp;&nbsp; Joint Custody Officer &nbsp;&nbsp; 
    <br><br>
    Name
</p>

        
     <table class="signature-table-bottom">
    <tr>
        <td style="text-align: left;">
            Cash Officer in Charge 
            <span style="display:block; margin-top:80px;">Name</span>
        </td>
    </tr>
</table>


        
        <div class="footer">
            Design & Developed by Jatin Mishra
        </div>

    </div>

</body>
</html>