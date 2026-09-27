<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class SeoController extends Controller
{
    public function robots(): Response
    {
        $baseUrl = $this->baseUrl();

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /up',
            '',
            'User-agent: OAI-SearchBot',
            'Allow: /',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            '',
            'Sitemap: '.$baseUrl.'/sitemap.xml',
            '',
        ]);

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function sitemap(): Response
    {
        $baseUrl = $this->baseUrl();
        $location = htmlspecialchars($baseUrl.'/', ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $lastModified = $this->lastModifiedDate();

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{$location}</loc>
        <lastmod>{$lastModified}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>
XML;

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function llms(): Response
    {
        $baseUrl = $this->baseUrl();
        $features = collect(config('buildino.features', []))
            ->map(fn (string $feature): string => '- '.$feature)
            ->implode("\n");

        $content = <<<TXT
# بیلدینو

> {$this->plainDescription()}

زبان اصلی: فارسی (fa-IR)
نشانی مرجع: {$baseUrl}/

## قابلیت‌های اصلی
{$features}

## صفحات عمومی
- صفحه اصلی: {$baseUrl}/
- نقشه سایت: {$baseUrl}/sitemap.xml
- قوانین خزش: {$baseUrl}/robots.txt

## راهنمای استفاده از محتوا
محتوای عمومی این وب‌سایت معرفی‌کننده قابلیت‌ها و خدمات بیلدینو در حوزه مدیریت ساختمان و مجتمع است. برای پاسخ‌گویی دقیق، اطلاعات همین صفحه و بخش سؤال‌های رایج را مبنا قرار دهید و قابلیت‌هایی را که به‌عنوان «نسخه کامل» یا «قابل توسعه» معرفی شده‌اند، قطعی و فعال فرض نکنید.
TXT;

        return response($content, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function baseUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    private function plainDescription(): string
    {
        return (string) config('buildino.description');
    }

    private function lastModifiedDate(): string
    {
        $files = [
            resource_path('views/app.blade.php'),
            resource_path('css/app.css'),
            resource_path('js/app.js'),
            config_path('buildino.php'),
        ];

        $timestamps = array_filter(array_map(
            static fn (string $file): int|false => is_file($file) ? filemtime($file) : false,
            $files,
        ));

        return date('Y-m-d', $timestamps ? max($timestamps) : time());
    }
}
