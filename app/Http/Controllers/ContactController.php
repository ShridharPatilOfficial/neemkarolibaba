<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $request->session()->put('captcha_contact', $num1 + $num2);

        $settings = [
            'address'  => SiteSetting::get('address', 'Chandigarh - 160002'),
            'phone'    => SiteSetting::get('phone', '+91 94644 33808'),
            'email'    => SiteSetting::get('email', 'support@neemkarolibaba.org.in'),
            'whatsapp' => SiteSetting::get('whatsapp', '919464433808'),
        ];

        return view('contact', compact('num1', 'num2', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'last_name'  => ['required', 'string', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'email'      => ['required', 'email:rfc', 'max:100'],
            'phone'      => ['required', 'regex:/^[6789]\d{9}$/'],
            'message'    => ['required', 'string', 'max:1000', 'regex:/^[^<>{}]*$/'],
            'captcha'    => ['required', 'integer'],
        ], [
            'first_name.regex' => 'Name may only contain letters and spaces.',
            'last_name.regex'  => 'Name may only contain letters and spaces.',
            'phone.regex'      => 'Enter a valid 10-digit Indian mobile number.',
            'message.regex'    => 'Message must be plain text only (no special characters like <, >, {, }).',
            'captcha.required' => 'Please answer the security question.',
        ]);

        if ((int) $request->captcha !== (int) $request->session()->get('captcha_contact')) {
            return back()->withErrors(['captcha' => 'Incorrect answer. Please try again.'])->withInput();
        }

        ContactSubmission::create([
            'first_name' => strip_tags(trim($request->first_name)),
            'last_name'  => strip_tags(trim($request->last_name)),
            'email'      => $request->email,
            'phone'      => $request->phone,
            'message'    => strip_tags(trim($request->message)),
            'ip_address' => $request->ip(),
        ]);

        $request->session()->forget('captcha_contact');

        return back()->with('success', 'Your message has been sent! We will respond within 24 hours.');
    }
}
