<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $pages = [
            ['url' => route('home'),             'priority' => '1.0',  'changefreq' => 'weekly'],
            ['url' => route('about'),             'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => route('about.founders'),    'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('about.org-profile'), 'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('about.documents'),   'priority' => '0.6',  'changefreq' => 'monthly'],
            ['url' => route('activities'),        'priority' => '0.8',  'changefreq' => 'weekly'],
            ['url' => route('events'),            'priority' => '0.8',  'changefreq' => 'daily'],
            ['url' => route('future-plan'),       'priority' => '0.6',  'changefreq' => 'monthly'],
            ['url' => route('gallery'),           'priority' => '0.7',  'changefreq' => 'weekly'],
            ['url' => route('media-coverage'),    'priority' => '0.7',  'changefreq' => 'weekly'],
            ['url' => route('donate'),            'priority' => '0.9',  'changefreq' => 'monthly'],
            ['url' => route('join-us'),           'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('contact'),           'priority' => '0.6',  'changefreq' => 'monthly'],
        ];

        $xml = view('sitemap', compact('pages'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
