<!doctype html>
<html lang="fa-IR" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="پلن‌ها و مدل قیمت‌گذاری بیلدینو برای ساختمان، مجتمع و مجموعه سازمانی.">
    <meta name="theme-color" content="#0c2339">
    <title>تعرفه‌ها | بیلدینو</title>
    <link rel="canonical" href="{{ route('pricing') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/brand-color.png') }}">
    <script src="{{ asset('theme-init.js') }}" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">پرش به محتوا</a>
    <header class="site-header" data-site-header>
        <div class="container nav-shell">
            <x-logo />
            <nav id="primary-navigation" class="main-nav" aria-label="ناوبری اصلی" data-main-nav>
                <a href="{{ route('home') }}#features">امکانات</a>
                <a href="{{ route('home') }}#services">خدمات</a>
                @if (count(config('home.projects', [])))<a href="{{ route('home') }}#projects">پروژه‌ها</a>@endif
                <a href="{{ route('home') }}#pricing" class="active">تعرفه‌ها</a>
                <a href="{{ route('home') }}#about">درباره ما</a>
            </nav>
            <div class="nav-actions">
                <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="تغییر حالت نمایش"><span class="theme-icons"><x-icon name="moon" /><x-icon name="sun" /></span></button>
                <button type="button" data-consultation-open aria-haspopup="dialog" class="button button-small button-primary nav-cta">درخواست مشاوره</button>
                <button class="icon-button menu-toggle" type="button" data-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="باز کردن فهرست"><span class="menu-icon-open"><x-icon name="menu" /></span><span class="menu-icon-close" hidden><x-icon name="close" /></span></button>
            </div>
        </div>
    </header>
    <main id="main">
        <section class="pricing-hero" id="top"><nav class="container" aria-label="مسیر صفحه"><a class="pricing-back" href="{{ route('home') }}">صفحه اصلی</a><span class="breadcrumb-separator" aria-hidden="true">/</span><h1 aria-current="page">تعرفه‌ها</h1></nav></section>
        <section class="section" aria-labelledby="plans-title"><div class="container"><div class="section-heading"><div><span class="eyebrow">مدل همکاری</span><h2 id="plans-title">پلن‌ها را مقایسه کنید</h2></div><p>امکانات هر پلن را ببینید و متناسب با نیاز ساختمان خود انتخاب کنید.</p></div><div class="pricing-grid">
            @foreach (config('home.plans') as $plan)
                <article class="pricing-card @if ($loop->index === 1) is-featured @endif"><span class="plan-index">پلن {{ $loop->iteration }}</span><h3>{{ $plan['name'] }}</h3><p>{{ $plan['subtitle'] }}</p><div class="price-line">تعرفه با استعلام</div><ul>@foreach ($plan['items'] as $item)<li><x-icon name="check" size="18" />{{ $item }}</li>@endforeach</ul><button type="button" data-consultation-open aria-haspopup="dialog" class="button @if ($loop->index === 1) button-primary @else button-outline @endif">درخواست مشاوره <x-icon name="arrow" size="17" /></button></article>
            @endforeach
        </div></div></section>
        <section class="section section-soft"><div class="container pricing-explainer"><div><span class="eyebrow">قیمت‌گذاری شفاف</span><h2>تعرفه نهایی چطور مشخص می‌شود؟</h2></div><div><p>هزینه راه‌اندازی و اشتراک به تعداد واحدها و خدمات موردنیاز ساختمان بستگی دارد. برای دریافت پیشنهاد قیمت، با ما تماس بگیرید.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-primary">درخواست بررسی مجموعه شما <x-icon name="arrow" size="17" /></button></div></div></section>
    </main>
    <footer class="site-footer"><img class="footer-skyline" src="{{ asset('images/milad-tower.webp') }}" width="1672" height="941" loading="lazy" decoding="async" alt="" aria-hidden="true"><div class="container footer-main"><div><x-logo /><p>راهکاری برای مدیریت ساده‌تر ساختمان و ارتباط بهتر مدیر، مالک و ساکن.</p></div><nav aria-label="پیوندهای پایین صفحه"><a href="{{ route('home') }}#features">امکانات</a><a href="{{ route('home') }}#services">خدمات</a><a href="{{ route('home') }}#contact">تماس</a></nav></div><div class="container footer-bottom"><span>© {{ date('Y') }} بیلدینو. تمامی حقوق محفوظ است.</span><a href="#top">بازگشت به بالا ↑</a></div></footer>
    @include('partials.contact-float')
</body>
</html>
