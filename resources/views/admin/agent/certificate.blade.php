<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Appraiser Verification Certificate</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .meta-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }
        
        .meta-table .label {
            font-weight: bold;
            width: 30%;
        }
        
        .letter-body {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .letter-body p {
            margin: 8px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .declaration {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .signature-box {
            text-align: center;
            width: 30%;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .duplicate-note {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .appraiser-address {
            text-align: center;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- First Copy -->
    <div class="duplicate-note">(Original Copy)</div>
    
    <div class="header">
        <h1>Second Appraiser Verification Certificate</h1>
        <p>(To be obtained in Duplicate for Gold Loan Verification During RFIA)</p>
    </div>
    
    <table class="meta-table">
        <tr>
            <td class="label">Date</td>
            <td>{{ $date ?? now()->format('d-M/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Gold Loan A/c No</td>
            <td>{{ $agent->loan_account_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Ledger Folio No</td>
            <td>{{ $agent->ledger_folio_no ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Name and address of first appraiser</td>
            <td>
                <div class="appraiser-address">
                    <strong>Vaibhav Shree Jewellers</strong><br>
                    Ekmighat, Laheriasarai, Darbhanga
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Date of Appraiser's Certificate</td>
            <td>{{ $date ?? now()->format('d/m/Y') }}</td>
        </tr>
    </table>
    
    <div class="letter-body">
        <p>The Branch Manager,</p>
        <p>{{ $agent->bank->bank ?? 'State Bank of India' }},</p>
        <p>Branch {{ $agent->branch->branch_address ?? 'BAHERL (11829)' }}</p>
        <br>
        <p>Madam/Dear Sir,</p>
        <br>
        <p>I hereby certify that the ornaments/items of the above mentioned gold loan account have been weighed and appraised by me on <strong>{{ $agent->name ?? 'Customer Name' }}</strong>. In the presence of Shri/Smt. <strong>{{ $agent->cash_in_charge ?? 'Cash Officer' }}</strong> (Cash in charge) and <strong>{{ $agent->joint_custody_officer ?? 'Joint Custody Officer' }}</strong> (Joint Custody Officer). The exact weight, purity of the metal and market value of each item as on date are indicated below.</p>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th>S No</th>
                <th>Description of the Article/Unit</th>
                <th>Gross Weight (Grams)</th>
                <th>Approximate weight of the precious stones in the ornaments (Grams)</th>
                <th>Purity (Carat)</th>
                <th>Net Weight (Grams)</th>
                <th>Market Value Rs</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($goldItems) && count($goldItems) > 0)
                @foreach($goldItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['description'] ?? '' }}</td>
                        <td>{{ $item['gross_weight'] ?? '' }}</td>
                        <td>{{ $item['stone_weight'] ?? '' }}</td>
                        <td>{{ $item['purity'] ?? '' }}</td>
                        <td>{{ $item['net_weight'] ?? '' }}</td>
                        <td>{{ $item['market_value'] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <!-- Sample data when no items provided -->
                <tr>
                    <td>1</td>
                    <td>Necklace (1)</td>
                    <td>17.600</td>
                    <td>0.600</td>
                    <td>18</td>
                    <td>17.00</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Bracelet (2)</td>
                    <td>16.500</td>
                    <td>0.500</td>
                    <td>18</td>
                    <td>14.500</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="letter-body">
        <p><strong>Method used for purity testing:</strong> {{ $purity_method ?? 'Electronic Gold Testing' }}</p>
    </div>
    
    <div class="declaration">
        <p>I solemnly declare that weight, purity of the gold ornaments/precious stones indicated above are correct and I undertake to indemnify the Bank against any loss it may sustain on account of any inaccuracy in the above appraisal.</p>
    </div>
    
    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Name & Signature of the Appraiser</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Cash Officer in Charge</p>
            <p>{{ $agent->cash_in_charge ?? '' }}</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Joint Custody Officer</p>
            <p>{{ $agent->joint_custody_officer ?? '' }}</p>
        </div>
    </div>
    
    <!-- Second Copy -->
    <div class="page-break"></div>
    
    <div class="duplicate-note">(Duplicate Copy)</div>
    
    <div class="header">
        <h1>Second Appraiser Verification Certificate</h1>
        <p>(To be obtained in Duplicate for Gold Loan Verification During RFIA)</p>
    </div>
    
    <table class="meta-table">
        <tr>
            <td class="label">Date</td>
            <td>{{ $date ?? now()->format('d-M/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Gold Loan A/c No</td>
            <td>{{ $agent->loan_account_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Ledger Folio No</td>
            <td>{{ $agent->ledger_folio_no ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Name and address of first appraiser</td>
            <td>
                <div class="appraiser-address">
                    <strong>Vaibhav Shree Jewellers</strong><br>
                    Ekmighat, Laheriasarai, Darbhanga
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Date of Appraiser's Certificate</td>
            <td>{{ $date ?? now()->format('d/m/Y') }}</td>
        </tr>
    </table>
    
    <div class="letter-body">
        <p>The Branch Manager,</p>
        <p>{{ $agent->bank->bank ?? 'State Bank of India' }},</p>
        <p>Branch {{ $agent->branch->branch_address ?? 'BAHERL (11829)' }}</p>
        <br>
        <p>Madam/Dear Sir,</p>
        <br>
        <p>I hereby certify that the ornaments/items of the above mentioned gold loan account have been weighed and appraised by me on <strong>{{ $agent->name ?? 'Customer Name' }}</strong>. In the presence of Shri/Smt. <strong>{{ $agent->cash_in_charge ?? 'Cash Officer' }}</strong> (Cash in charge) and <strong>{{ $agent->joint_custody_officer ?? 'Joint Custody Officer' }}</strong> (Joint Custody Officer). The exact weight, purity of the metal and market value of each item as on date are indicated below.</p>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th>S No</th>
                <th>Description of the Article/Unit</th>
                <th>Gross Weight (Grams)</th>
                <th>Approximate weight of the precious stones in the ornaments (Grams)</th>
                <th>Purity (Carat)</th>
                <th>Net Weight (Grams)</th>
                <th>Market Value Rs</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($goldItems) && count($goldItems) > 0)
                @foreach($goldItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['description'] ?? '' }}</td>
                        <td>{{ $item['gross_weight'] ?? '' }}</td>
                        <td>{{ $item['stone_weight'] ?? '' }}</td>
                        <td>{{ $item['purity'] ?? '' }}</td>
                        <td>{{ $item['net_weight'] ?? '' }}</td>
                        <td>{{ $item['market_value'] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <!-- Sample data when no items provided -->
                <tr>
                    <td>1</td>
                    <td>Necklace (1)</td>
                    <td>17.600</td>
                    <td>0.600</td>
                    <td>18</td>
                    <td>17.00</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Bracelet (2)</td>
                    <td>16.500</td>
                    <td>0.500</td>
                    <td>18</td>
                    <td>14.500</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="letter-body">
        <p><strong>Method used for purity testing:</strong> {{ $purity_method ?? 'Electronic Gold Testing' }}</p>
    </div>
    
    <div class="declaration">
        <p>I solemnly declare that weight, purity of the gold ornaments/precious stones indicated above are correct and I undertake to indemnify the Bank against any loss it may sustain on account of any inaccuracy in the above appraisal.</p>
    </div>
    
    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Name & Signature of the Appraiser</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Cash Officer in Charge</p>
            <p>{{ $agent->cash_in_charge ?? '' }}</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Joint Custody Officer</p>
            <p>{{ $agent->joint_custody_officer ?? '' }}</p>
        </div>
    </div>
</body>
</html>