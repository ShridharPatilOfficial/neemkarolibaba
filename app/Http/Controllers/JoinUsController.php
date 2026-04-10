<?php

namespace App\Http\Controllers;

use App\Models\JoinUsSubmission;
use Illuminate\Http\Request;

class JoinUsController extends Controller
{
    public function index(Request $request)
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $request->session()->put('captcha_join', $num1 + $num2);

        return view('join-us', compact('num1', 'num2'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'phone'   => ['required', 'regex:/^[6789]\d{9}$/'],
            'email'   => ['required', 'email:rfc', 'max:100'],
            'message' => ['required', 'string', 'max:1000', 'regex:/^[^<>{}]*$/'],
            'captcha' => ['required', 'integer'],
        ], [
            'name.regex'    => 'Name may only contain letters and spaces.',
            'phone.regex'   => 'Enter a valid 10-digit Indian mobile number.',
            'message.regex' => 'Message must be plain text only (no special characters like <, >, {, }).',
            'captcha.required' => 'Please answer the security question.',
        ]);

        if ((int) $request->captcha !== (int) $request->session()->get('captcha_join')) {
            return back()->withErrors(['captcha' => 'Incorrect answer. Please try again.'])->withInput();
        }

        JoinUsSubmission::create([
            'name'       => strip_tags(trim($request->name)),
            'phone'      => $request->phone,
            'email'      => $request->email,
            'message'    => strip_tags(trim($request->message)),
            'ip_address' => $request->ip(),
        ]);

        $request->session()->forget('captcha_join');

        return back()->with('success', 'Thank you for joining us! We will get back to you soon.');
    }
}
