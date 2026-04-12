<?php

namespace App\Http\Controllers;

use App\Models\DonateSetting;

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
            'tax_note'       => DonateSetting::get('tax_note', 'Donations to Neem Karoli Baba Charitable Trust are eligible for tax benefits under Section 80G.'),
        ];

        return view('donate', compact('settings'));
    }
}
