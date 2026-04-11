<?php

namespace App\Providers;

use App\Models\SiteSetting;
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
            $view->with([
                'siteName'    => SiteSetting::get('site_name', 'Neem Karoli Baba Charitable Trust'),
                'siteTagline' => SiteSetting::get('site_tagline', 'Love All, Serve All'),
                'headerPhoto' => $headerPhotoPath ? \Illuminate\Support\Facades\Storage::url($headerPhotoPath) : null,
            ]);
        });
    }
}
