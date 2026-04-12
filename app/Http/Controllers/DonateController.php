<?php

namespace App\Http\Controllers;

use App\Models\DonateSetting;
use App\Models\TaxBadge;

class DonateController extends Controller
{
    public function index()
    {
        $settings = [
            'description'    => DonateSetting::get('description', 'Your donation can make a significant impact in the lives of those in need. By contributing to Neem Karoli Baba Charitable Trust, you support vital initiatives in education, health, and empowerment.'),
            'account_holder' => DonateSetting::get('account_holder', ''),
            'bank_name'      => DonateSetting::get('bank_name', 'Axis Bank'),
            'branch_name'    => DonateSetting::get('branch_name', 'CHANDIGARH, 160047'),
            'account_number' => DonateSetting::get('account_number', '924020005347509'),
            'ifsc_code'      => DonateSetting::get('ifsc_code', 'UTIB0004866'),
            'qr_image'       => DonateSetting::get('qr_image', ''),
            'upi_id'         => DonateSetting::get('upi_id', ''),
            'tax_title'      => DonateSetting::get('tax_title', 'Tax Exemption'),
            'tax_desc'       => DonateSetting::get('tax_desc', 'All donations are eligible for tax exemption under Section 80G of the Income Tax Act. Certificate provided on request.'),
        ];

        $taxBadges = TaxBadge::with('document')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('donate', compact('settings', 'taxBadges'));
    }
}
