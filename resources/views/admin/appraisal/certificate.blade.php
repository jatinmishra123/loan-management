<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $type }} - Appraiser Certificate</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
            line-height: 1.3;
        }

        .certificate {
            border: 1px solid #000;
            padding: 20px 25px;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
        }

        .header h2 {
            font-family: Georgia, serif;
            font-size: 26px;
            font-weight: bold;
            margin: 0;
        }

        .sub-header {
            font-weight: bold;
            font-size: 14px;
        }

        /* --- NEW STYLES FOR HEADER ALIGNMENT --- */
        .header-meta-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Aligns items to the top */
            margin-top: 8px;
        }

        .meta-left {
            text-align: left;
        }

        .meta-right {
            text-align: right;
        }
        /* --- END NEW STYLES --- */
        
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0 0 8px 0; /* <-- *** Corrected: Top margin set to 0 *** */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        /* --- Corrected: Replaced flex .signature-block with table for PDF compatibility --- */
        .signature-table {
            width: 100%;
            border: 0;
            margin-top: 25px; /* Added margin for space */
            font-size: 12px;
            page-break-inside: avoid; /* Try to prevent breaking table across pages */
        }
        .signature-table td {
            width: 50%;
            border: 0;
            vertical-align: top; /* Align content to the top */
        }
        /* --- End Correction --- */

        .footer-line {
            text-align: right;
            font-size: 10px;
            margin-top: 8px;
            color: #444;
        }

        .qr-box {
            text-align: right;
            margin-bottom: 5px; /* Added margin for spacing */
        }

        .qr-box img {
            width: 90px;
            height: 90px;
        }
    </style>
</head>

<body>

    <div class="certificate">
        <div class="header">
            <h2>{{ $admin->name ?? 'Jeweller Shop Name' }}</h2>
            <div class="sub-header">{{ $admin->address ?? 'Full Address Not Added' }}</div>
            <div>Appraiser Bank A/c - {{ $admin->account_number ?? 'N/A' }}</div>
        </div>

        {{-- --- CORRECTED HEADER/META SECTION --- --}}
        <div class="header-meta-container">
            {{-- Left Side --}}
            <div class="meta-left">
                
                <div>Annexure: PL-61(i)</div>

                {{-- --- *** YAHAN PAR AAPKA NAYA REFERENCE CODE HAI *** --- --}}
                <div style="margin-top: 10px;">
                    @php
                        // 1. Admin: Admin ke naam se 3 capital letters
$refAdmin = strtoupper(collect(explode(' ', $admin->name ?? 'N/A'))->map(fn($w) => substr($w, 0, 1))->implode(''));
                        
                        // 2. Bank: Bank ke naam se 3 capital letters
                        $refBank = strtoupper(substr($customer->bank?->bank ?? 'BANK', 0, 3));

                        // 3. Branch: Branch ke naam se 3 capital letters
                        $refBranch = strtoupper(substr($customer->branch?->branch_name ?? 'BRANCH', 0, 3));

                        // 4. Account: Account se 3 digits
                        $refAccount = substr($customer->account_number ?? 'N/A', 0, 3);
                    @endphp

                    Ref :-
                    {{ $refAdmin }}/
                    {{ $refBank }}/
                    {{ $refBranch }}/
                    {{ $refAccount }}
                </div>
                 {{-- --- *** END CORRECTION *** --- --}}
            </div>

            {{-- Right Side --}}
            <div class="meta-right">
                <div class="qr-box">
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                </div>
                <div>Date :-
                    {{ $customer->date ? \Carbon\Carbon::parse($customer->date)->format('d/m/Y') : date('d/m/Y') }}
                </div>
            </div>
        </div>
        {{-- --- END CORRECTION --- --}}

        
        <div class="title">APPRAISER CERTIFICATE</div>

        <p style="text-align:justify; margin: 5px 0;">
            The Branch Manager<br>

            {{-- --- *** Bank name formatting (SBI to State Bank of India) *** --- --}}
            <div style="display: flex; justify-content: space-between; font-weight: bold;">
                <span>{{ $bankName }}</span>

                <span>A/c No.: {{ $customer->account_number ?? '—' }}</span>
            </div>
            
            {{-- --- Branch name formatting (first letter capital) --- --}}
            <div>{{ ucwords(strtolower($customer->branch->branch_address ?? 'Branch Name Not Available')) }} </div>
            <br>
            {{-- --- END CORRECTION --- --}}

            Dear Sir,<br>
            I hereby certify that Sri/Smt. <b>{{ $customer->brauser_name }}</b> S/W/D of
            <b>{{ $customer->ralative_name ?? '—' }}</b> Resident of
            <b>{{ $customer->address ?? '—' }}</b> who has sought gold loan from the bank
            is not my relative and the gold against which the loan is sought is not purchased from me.

            The ornaments/coins have been weighted and appraised by me on
            <b>{{ optional($customer->date)->format('d-m-Y') ?? date('d-m-Y') }}</b>
            in the presence of Sri/Smt.
            <b>{{ $customer->cash_incharge ?? 'Cash Officer Not Added' }}</b>
            (Cash in charge)
            and the exact weight, purity and market value are indicated below:
        </p>

        {{-- GOLD TABLE --}}
        <table>
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Description of the Article</th>
                    <th>No. of Article(units)</th>
                    <th>Approximate weight of the precious stones in the ornaments (Grams)</th>
                    <th>Gross Weight (Gram)</th>
                    <th>Net Weight (Gram)</th>
                    <th>Purity (Carat)</th>
                    <th>Market Value (Rs.)</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                    $gross = $net = $stone = $total = 0;
                    $puritySummary = [];

                    // Check if goldItems exists before sorting
                    $sortedItems = $customer->goldItems 
                                    ? $customer->goldItems->sortBy(fn($item) => 
                                        (int) filter_var($item->purity, FILTER_SANITIZE_NUMBER_INT)) 
                                    : collect();
                @endphp

                @forelse($sortedItems as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->stone_weight, 2) }} Gm</td>
                        <td>{{ number_format($item->gross_weight, 2) }} Gm</td>
                        <td>{{ number_format($item->net_weight, 2) }} Gm</td>
                        <td>{{ $item->purity }} Ct</td>
                        <td>{{ number_format($item->market_value, 2) }}</td>
                    </tr>

                    @php
                        $stone += $item->stone_weight;
                        $gross += $item->gross_weight;
                        $net += $item->net_weight;
                        $total += $item->market_value;

                        $p = (int) filter_var($item->purity, FILTER_SANITIZE_NUMBER_INT);
                        if ($p > 0) { // Only add if purity is valid
                            $puritySummary[$p]['net'] = ($puritySummary[$p]['net'] ?? 0) + $item->net_weight;
                        }
                    @endphp
                @empty
                    <tr>
                        <td colspan="8">No items added.</td>
                    </tr>
                @endforelse

                <tr>
                    <th colspan="3">Total</th>
                    <th>{{ number_format($stone, 2) }}</th>
                    <th>{{ number_format($gross, 2) }}</th>
                    <th>{{ number_format($net, 2) }}</th>
                    <th></th>
                    <th>{{ number_format($total, 2) }}</th>
                </tr>
            </tbody>
        </table>

        {{-- AMOUNT SECTION --}}
        @php ksort($puritySummary); @endphp

        <div style="margin-top: 10px;">
            <table style="width:100%; border-collapse: collapse;">
                <tr>
                    <th width="25%" style="border:1px solid #000;padding:6px;text-align:left;">
                        Amount (In Words)
                    </th>
                    <td width="50%" style="border:1px solid #000;padding:6px;">
                        {{ amountToWords((int)$total) }}
                    </td>
                    <th width="12%" style="border:1px solid #000;padding:6px;text-align:center;">
                        Round Up
                    </th>
                    <td width="13%" style="border:1px solid #000;padding:6px;font-weight:bold;text-align:right;">
                        {{ number_format($total, 2) }}
                    </td>
                </tr>

                {{-- --- CORRECTED CARAT SUMMARY TABLE --- --}}
                <tr>
                    <th colspan="4" style="border:1px solid #000;padding:6px;text-align:left; border-bottom: 0;">
                        Carat Summary:
                    </th>
                </tr>
                <tr>
                    <td colspan="4" style="border:1px solid #000; padding: 0; border-top: 0;">
                        @if(!empty($puritySummary))
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    @php $colCount = count($puritySummary); @endphp
                                    @foreach($puritySummary as $karat => $data)
                                        <td style="padding:5px; text-align:center; width: {{ 100 / $colCount }}%; border-top: 0; border-left:0; border-bottom: 0; {{ $loop->last ? 'border-right:0;' : 'border-right: 1px solid #000;' }}">
                                            {{ $karat }} Ct
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($puritySummary as $karat => $data)
                                        <td style="padding:5px; text-align:center; width: {{ 100 / $colCount }}%; border-top: 1px solid #000; border-left:0; border-bottom: 0; {{ $loop->last ? 'border-right:0;' : 'border-right: 1px solid #000;' }}">
                                            {{ number_format($data['net'], 2) }} gm
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        @else
                            <div style="padding:5px; text-align: center;">No purity summary available.</div>
                        @endif
                    </td>
                </tr>
                {{-- --- END CORRECTION --- --}}

            </table>
        </div>

        
        <p style="margin-top:10px;text-align:justify;">
            <b>Method used for purity testing:</b><br>
            I solemnly declare that weight, purity of the gold ornaments/precious stones indicated above are correct
and I undertake to indemnify the Bank against any loss it may sustain on account of any inaccuracy in the
above appraisal.
        </p>

        
        {{-- --- Corrected: Replaced div.signature-block with a table for PDF compatibility --- --}}
        <table class="signature-table">
            <tr>
                <td style="text-align: left;">
                    Place: {{ $customer->city ?? 'Darbhanga' }} <br>
                    Date: {{ optional($customer->date)->format('d/m/Y') ?? date('d/m/Y') }}
                    
                    {{-- Added space for signature --}}
                    <br><br><br><br>
                    
                    <b>Name & Signature of the Borrower</b>
                </td>

                <td style="text-align: right;">
                    Yours faithfully
                    
                    {{-- Added space for signature --}}
                    <br><br><br><br>

                    <b>Name & Signature of the Appraiser</b>
                </td>
            </tr>
        </table>
        {{-- --- End Correction --- --}}

        <div class="footer-line">Design & Developed by Jatin Mishra</div>
    </div>

</body>
</html>