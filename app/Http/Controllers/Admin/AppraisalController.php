<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use PDF;
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
     * ✔ Return correct blade based on appraisal type
     */
    private function getViewFile($type)
    {
        return strtolower(trim($type)) === 'appraisal 2'
            ? 'admin.appraisal.certificate2'
            : 'admin.appraisal.certificate';
    }


    /**
     * ✔ Format Bank Name
     */
    private function formatBankName($bankName)
    {
        if (!$bankName) {
            return "Bank Name Not Available";
        }

        $name = strtolower(trim($bankName));

        $aliases = [

            // SBI
            'State Bank Of India' => ['sbi', 's.b.i', 'state bank', 'state bank india'],

            // BANK OF BARODA
            'Bank Of Baroda' => ['bob', 'b.o.b', 'bank of baroda'],

            // PNB
            'Punjab National Bank' => ['pnb', 'punjab national'],

            // HDFC
            'HDFC Bank' => ['hdfc'],

            // ICICI
            'ICICI Bank' => ['icici'],

            // AXIS
            'Axis Bank' => ['axis', 'axisbank'],

            // UNION BANK
            'Union Bank Of India' => ['ubi', 'union bank'],

            // CANARA
            'Canara Bank' => ['canara'],

            // CENTRAL BANK
            'Central Bank Of India' => ['cbi', 'central bank'],

            // BANK OF INDIA
            'Bank Of India' => ['boi'],

            // INDIAN BANK
            'Indian Bank' => ['indian bank'],

            // UCO BANK
            'UCO Bank' => ['uco', 'uco bank'],

            // IDBI
            'IDBI Bank' => ['idbi'],

            // KOTAK
            'Kotak Mahindra Bank' => ['kotak'],

            // YES BANK
            'Yes Bank' => ['yes bank', 'yesbank'],

            // FEDERAL
            'Federal Bank' => ['federal'],

            // INDUSIND
            'IndusInd Bank' => ['indusind'],

            // SOUTH INDIAN BANK
            'South Indian Bank' => ['sib'],

            // RBL
            'RBL Bank' => ['rbl', 'ratnakar']
        ];

        foreach ($aliases as $main => $list) {
            if (in_array($name, $list)) {
                return $main;
            }
        }

        return ucwords($name);
    }


    /**
     * ✔ QR Code Generator
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
     * ✔ Gold Items Filtering (Range)
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
     * ✔ AJAX — Load Certificate HTML (with correct blade)
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

        $view = $this->getViewFile($type); // ← Auto-switch between Appraisal 1 & 2

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
     * ✔ PDF Download (with correct blade)
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
}
