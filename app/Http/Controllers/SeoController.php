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
        $lastModified = $this->lastModifiedDate();
        $entries = '';
        foreach (['/', '/pricing', '/features', '/about', '/contact'] as $path) {
            $location = htmlspecialchars($baseUrl.$path, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $entries .= "<url><loc>{$location}</loc><lastmod>{$lastModified}</lastmod></url>\n";
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$entries.'</urlset>';

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
- تعرفه‌ها: {$baseUrl}/pricing
- نقشه سایت: {$baseUrl}/sitemap.xml
- قوانین خزش: {$baseUrl}/robots.txt

## راهنمای استفاده از محتوا
محتوای عمومی این وب‌سایت معرفی‌کننده قابلیت‌ها و خدمات بیلدینو در حوزه مدیریت ساختمان و مجتمع است. پروژه‌ها، آمار و مقاله‌هایی که با برچسب «نمایشی» مشخص شده‌اند داده واقعی نیستند. قابلیت‌های «در برنامه توسعه» را فعال فرض نکنید.
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
        $files = array_merge(glob(resource_path('views/*.blade.php')), glob(resource_path('views/partials/*.blade.php')), glob(resource_path('views/layouts/*.blade.php')), [
            resource_path('views/home.blade.php'),
            resource_path('views/pricing.blade.php'),
            resource_path('css/app.css'),
            resource_path('js/app.js'),
            config_path('buildino.php'),
            config_path('home.php'),
        ]);

        $timestamps = array_filter(array_map(
            static fn (string $file): int|false => is_file($file) ? filemtime($file) : false,
            $files,
        ));

        return date('Y-m-d', $timestamps ? max($timestamps) : time());
    }
}
