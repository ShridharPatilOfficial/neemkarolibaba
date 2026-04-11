<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($pages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
        <lastmod>{{ now()->toDateString() }}</lastmod>
    </url>
@endforeach
</urlset>
