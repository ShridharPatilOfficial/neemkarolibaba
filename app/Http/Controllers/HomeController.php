<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ImpactStat;
use App\Models\Partner;
use App\Models\PresidentMessage;
use App\Models\RecentActivity;
use App\Models\SiteSetting;
use App\Models\MediaCoverage;
use App\Models\Principle;
use App\Models\Slider;
use App\Models\WorkVideo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => SiteSetting::get('site_name', 'Neem Karoli Baba Charitable Trust'),
            'reg_no'    => SiteSetting::get('reg_no', 'IN-CH44392214903842V'),
            'email'     => SiteSetting::get('email', 'support@neemkarolibaba.org.in'),
            'phone'     => SiteSetting::get('phone', '+91 94644 33808'),
            'whatsapp'  => SiteSetting::get('whatsapp', '919464433808'),
            'address'   => SiteSetting::get('address', 'Chandigarh - 160002'),
            'ticker'    => SiteSetting::get('ticker', 'All donations are eligible for tax exemption as we are a 12A and 80G CSR registered organization. Donate to Neem Karoli Baba Charitable Trust today!'),
            'mission'   => SiteSetting::get('mission', ''),
            'vision'    => SiteSetting::get('vision', ''),
            'objectives'=> SiteSetting::get('objectives', ''),
        ];

        $sliders          = Slider::where('is_active', true)->orderBy('sort_order')->get();
        $partners         = Partner::where('is_active', true)->orderBy('sort_order')->get();
        $impactStats      = ImpactStat::where('is_active', true)->orderBy('sort_order')->get();
        $recentActivities = RecentActivity::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $events           = Event::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $presidentMessage = PresidentMessage::where('is_active', true)->first();
        $principles       = Principle::where('is_active', true)->orderBy('sort_order')->get();
        $workVideos       = WorkVideo::where('is_active', true)->orderBy('sort_order')->take(8)->get();
        $mediaCoverages   = MediaCoverage::where('is_active', true)->orderByDesc('published_date')->take(6)->get();

        return view('home', compact(
            'settings',
            'sliders',
            'partners',
            'impactStats',
            'recentActivities',
            'events',
            'presidentMessage',
            'principles',
            'workVideos',
            'mediaCoverages'
        ));
    }
}
