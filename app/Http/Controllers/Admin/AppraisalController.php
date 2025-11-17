<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\AppraisalRecord;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppraisalController extends Controller
{
    /**
     * Show appraisal page (ADMIN-WISE)
     */
    public function index()
    {
        $adminId = auth('admin')->id();

        $customers = Customer::where('admin_id', $adminId)
            ->select('id', 'brauser_name')
            ->orderBy('brauser_name')
            ->get();

        $types = ['Appraisal 1', 'Appraisal 2'];

        return view('admin.appraisal.index1', compact('customers', 'types'));
    }


    /**
     * Return correct view file
     */
    private function getViewFile($type)
    {
        return strtolower(trim($type)) === 'appraisal 2'
            ? 'admin.appraisal.certificate2'
            : 'admin.appraisal.certificate';
    }


    /**
     * Format Bank Name
     */
    private function formatBankName($bankName)
    {
        if (!$bankName) {
            return "Bank Name Not Available";
        }

        $name = strtolower(trim($bankName));

        $aliases = [
            'State Bank Of India'     => ['sbi', 's.b.i', 'state bank', 'state bank india'],
            'Bank Of Baroda'          => ['bob', 'b.o.b', 'bank of baroda'],
            'Punjab National Bank'    => ['pnb', 'punjab national'],
            'HDFC Bank'               => ['hdfc'],
            'ICICI Bank'              => ['icici'],
            'Axis Bank'               => ['axis', 'axisbank'],
            'Union Bank Of India'     => ['ubi', 'union bank'],
            'Canara Bank'             => ['canara'],
            'Central Bank Of India'   => ['cbi', 'central bank'],
            'Bank Of India'           => ['boi'],
            'Indian Bank'             => ['indian bank'],
            'UCO Bank'                => ['uco'],
            'IDBI Bank'               => ['idbi'],
            'Kotak Mahindra Bank'     => ['kotak'],
            'Yes Bank'                => ['yes bank', 'yesbank'],
            'Federal Bank'            => ['federal'],
            'IndusInd Bank'           => ['indusind'],
            'South Indian Bank'       => ['sib'],
            'RBL Bank'                => ['rbl', 'ratnakar']
        ];

        foreach ($aliases as $main => $list) {
            if (in_array($name, $list)) {
                return $main;
            }
        }

        return ucwords($name);
    }


    /**
     * QR Code Generator
     */
    private function buildQr(Customer $customer, $type)
    {
        $bank = $this->formatBankName($customer->bank->bank ?? 'N/A');

        $dataString =
            "Customer: {$customer->brauser_name}\n" .
            "Account: {$customer->account_number}\n" .
            "Bank: {$bank}\n" .
            "Branch: " . ($customer->branch->branch_name ?? 'N/A') . "\n" .
            "Type: {$type}\n" .
            "Date: " . ($customer->date ? $customer->date->format('d/m/Y') : date('d/m/Y'));

        return base64_encode(
            QrCode::format('png')->size(150)->generate($dataString)
        );
    }


    /**
     * Gold Items Filtering (Range)
     */
    private function filterItems($items)
    {
        $range = request()->range;

        if (!$range) {
            return $items;
        }

        [$start, $end] = explode('-', $range);

        return $items->slice($start - 1, ($end - $start) + 1);
    }


    /**
     * AJAX — Load Certificate HTML
     */
    public function getData($customerId, $type)
    {
        $admin = auth('admin')->user();

        $customer = Customer::where('admin_id', $admin->id)
            ->with(['goldItems', 'bank', 'branch'])
            ->findOrFail($customerId);

        $items    = $this->filterItems($customer->goldItems);
        $bankName = $this->formatBankName($customer->bank->bank ?? null);
        $qrCode   = $this->buildQr($customer, $type);

        $view = $this->getViewFile($type);

        return view($view, [
            'customer' => $customer,
            'type'     => $type,
            'admin'    => $admin,
            'qrCode'   => $qrCode,
            'items'    => $items,
            'bankName' => $bankName
        ])->render();
    }


    /**
     * PDF Download + Save to appraisal_records table
     */
    public function downloadPdf($customerId, $type)
    {
        $admin = auth('admin')->user();

        $customer = Customer::where('admin_id', $admin->id)
            ->with(['goldItems', 'bank', 'branch'])
            ->findOrFail($customerId);

        $items    = $this->filterItems($customer->goldItems);
        $bankName = $this->formatBankName($customer->bank->bank ?? null);
        $qrCode   = $this->buildQr($customer, $type);

        $view = $this->getViewFile($type);

        /**
         * ✅ SAVE RECORD IN appraisal_records
         */
        AppraisalRecord::create([
            'customer_id'        => $customerId,
            'gold_items_snapshot'=> json_encode($items),
            'total_value'        => $items->sum('value'),
            'status'             => $type,
            'downloaded_at'      => Carbon::now()
        ]);

        /**
         * Generate PDF
         */
        $pdf = PDF::loadView($view, [
            'customer' => $customer,
            'type'     => $type,
            'admin'    => $admin,
            'qrCode'   => $qrCode,
            'items'    => $items,
            'bankName' => $bankName
        ])->setPaper('a4', 'portrait');

        $file = $customer->brauser_name . '_' . str_replace(' ', '_', $type) . '.pdf';

        return $pdf->download($file);
    }
    public function downloadAgain($id)
{
    $record = \App\Models\AppraisalRecord::with('customer')->findOrFail($id);

    // Gold items
    $items = collect(json_decode($record->gold_items_snapshot, true));

    // PDF filename
    $file = $record->customer->brauser_name . '_' . str_replace(' ', '_', $record->status) . '.pdf';

    // IMPORTANT: Detect correct view
    $view = strtolower($record->status) === 'appraisal 2'
        ? 'admin.appraisal.certificate2'
        : 'admin.appraisal.certificate';

    // Generate PDF Again
    $pdf = \PDF::loadView($view, [
        'customer' => $record->customer,
        'items'    => $items,
        'type'     => $record->status,
        'admin'    => auth('admin')->user(),
        'bankName' => '',          // optional
        'qrCode'   => ''           // optional
    ])->setPaper('a4', 'portrait');

    return $pdf->download($file);
}

}
