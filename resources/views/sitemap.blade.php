<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{url('/')}}</loc>
        <lastmod>2023-01-07T10:29:00Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    @foreach ($tenants as $tenant)
        <url>
            <loc>https://{{$tenant->id}}.mymarks.in</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($tenant->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
