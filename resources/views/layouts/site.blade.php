<!doctype html>
<html lang="fa-IR" dir="rtl">
<head>
    @php
        $baseUrl = rtrim((string) config('app.url'), '/');
        $canonicalUrl = $baseUrl.(request()->routeIs('home') ? '/' : '/'.trim(request()->path(), '/'));
        $pageTitle = trim($__env->yieldContent('title', config('buildino.title')));
        $pageDescription = trim($__env->yieldContent('description', config('buildino.description')));
        $socialImage = $baseUrl.config('buildino.social_image');
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'WebSite', '@id' => $baseUrl.'/#website', 'url' => $baseUrl.'/', 'name' => config('buildino.name'), 'inLanguage' => 'fa-IR'],
                ['@type' => 'WebPage', '@id' => $canonicalUrl.'#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription, 'inLanguage' => 'fa-IR', 'isPartOf' => ['@id' => $baseUrl.'/#website']],
            ],
        ];
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="@yield('robots', 'index,follow,max-image-preview:large')">
    <meta name="theme-color" content="#0c2339">
    <meta name="color-scheme" content="light dark">
    <meta name="format-detection" content="telephone=no">
    <title>{{ $pageTitle }}</title>
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="fa-IR" href="{{ $canonicalUrl }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/brand-color.png') }}">
    <link rel="preload" href="{{ asset('fonts/iranyekanrd/IRANYekanRegularRd.woff') }}" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="{{ asset('fonts/iranyekanrd/IRANYekanExtraBoldRd.woff') }}" as="font" type="font/woff" crossorigin>
    @if(request()->routeIs('home'))
    <link rel="preload" as="image" href="{{ asset('images/buildings-960.webp') }}" imagesrcset="{{ asset('images/buildings-480.webp') }} 480w, {{ asset('images/buildings-640.webp') }} 640w, {{ asset('images/buildings-960.webp') }} 960w" imagesizes="(max-width:850px) calc(100vw - 80px), 480px" fetchpriority="high">
    @endif
    <meta property="og:locale"  content="fa_IR">
    <meta property="og:site_name" content="{{ config('buildino.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ config('buildino.social_image_alt') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $socialImage }}">
    <meta name="twitter:image:alt" content="{{ config('buildino.social_image_alt') }}">
    <script type="application/ld+json" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <script nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}">{!! file_get_contents(public_path('theme-init.js')) !!}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">پرش به محتوا</a>
    @include('partials.header')
    <main id="main">@yield('content')</main>
    @include('partials.footer')
    @include('partials.contact-float')
</body>
</html>
