<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share site name and tagline with every view so pages never need
        // to hardcode the trust name — change it once in admin settings.
        View::composer('*', function ($view) {
            $headerPhotoPath = SiteSetting::get('header_photo');

            // Real unique visitor count (distinct IPs)
            $realVisitors = VisitorLog::distinct('ip_address')->count('ip_address');
            // Frontend shows real count + 1230 padding; admin sees real count
            $frontendVisitors = $realVisitors + 1230;

            $view->with([
                'siteName'         => SiteSetting::get('site_name', 'Neem Karoli Baba Charitable Trust'),
                'siteTagline'      => SiteSetting::get('site_tagline', 'Love All, Serve All'),
                'headerPhoto'      => $headerPhotoPath ? \Illuminate\Support\Facades\Storage::url($headerPhotoPath) : null,
                'frontendVisitors' => $frontendVisitors,
            ]);
        });
    }
}
