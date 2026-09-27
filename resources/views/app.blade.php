<!doctype html>
<html lang="fa-IR" dir="rtl">
<head>
    @php
        $canonicalUrl = rtrim((string) config('app.url'), '/').'/';
        $socialImage = rtrim((string) config('app.url'), '/').config('buildino.social_image');
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => $canonicalUrl.'#website',
                    'url' => $canonicalUrl,
                    'name' => config('buildino.name'),
                    'description' => config('buildino.description'),
                    'inLanguage' => config('buildino.language'),
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $canonicalUrl.'#webpage',
                    'url' => $canonicalUrl,
                    'name' => config('buildino.title'),
                    'description' => config('buildino.description'),
                    'isPartOf' => ['@id' => $canonicalUrl.'#website'],
                    'primaryImageOfPage' => [
                        '@type' => 'ImageObject',
                        'url' => $socialImage,
                        'width' => 1448,
                        'height' => 1086,
                    ],
                    'inLanguage' => config('buildino.language'),
                ],
                [
                    '@type' => 'WebApplication',
                    '@id' => $canonicalUrl.'#application',
                    'name' => config('buildino.name'),
                    'url' => $canonicalUrl,
                    'description' => config('buildino.description'),
                    'applicationCategory' => 'BusinessApplication',
                    'applicationSubCategory' => 'Building Management',
                    'operatingSystem' => 'Web',
                    'browserRequirements' => 'Requires a modern web browser',
                    'inLanguage' => config('buildino.language'),
                    'featureList' => config('buildino.features'),
                    'image' => $socialImage,
                ],
            ],
        ];
        $faYear = strtr(date('Y'), ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);
        $navItems = [
            ['overview', 'چرا بیلدینو؟'],
            ['capabilities', 'امکانات'],
            ['services', 'خدمات'],
            ['showcase', 'داخل محصول'],
            ['how', 'چطور کار می‌کند؟'],
            ['faq', 'سؤال‌های رایج'],
        ];
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="{{ config('buildino.description') }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <meta name="googlebot" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="color-scheme" content="light dark">
    <meta name="application-name" content="{{ config('buildino.name') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#0D1D2F" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#F4FAF9" media="(prefers-color-scheme: light)">

    <title>{{ config('buildino.title') }}</title>
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="fa-IR" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/brand-color.png') }}">
    <link rel="preload" href="{{ asset('fonts/iranyekanrd/IRANYekanRegularRd.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="{{ asset('fonts/iranyekanrd/IRANYekanBoldRd.ttf') }}" as="font" type="font/ttf" crossorigin>

    <meta property="og:locale" content="{{ config('buildino.locale') }}">
    <meta property="og:site_name" content="{{ config('buildino.name') }}">
    <meta property="og:title" content="{{ config('buildino.title') }}">
    <meta property="og:description" content="{{ config('buildino.og_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:image:secure_url" content="{{ $socialImage }}">
    <meta property="og:image:width" content="1448">
    <meta property="og:image:height" content="1086">
    <meta property="og:image:alt" content="{{ config('buildino.social_image_alt') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('buildino.title') }}">
    <meta name="twitter:description" content="{{ config('buildino.og_description') }}">
    <meta name="twitter:image" content="{{ $socialImage }}">
    <meta name="twitter:image:alt" content="{{ config('buildino.social_image_alt') }}">

    <script type="application/ld+json" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <script src="{{ asset('theme-init.js') }}" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="liquid-cursor" aria-hidden="true"><i></i></div>
    <a class="skip-link" href="#main">پرش به محتوای اصلی</a>

    <header class="site-header" data-site-header>
        <div class="nav-shell">
            <x-logo />
            <nav id="primary-navigation" class="main-nav" aria-label="ناوبری اصلی" data-main-nav>
                @foreach ($navItems as [$id, $label])
                    <a href="#{{ $id }}" @class(['active' => $id === 'overview'])>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="nav-actions">
                <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="استفاده از حالت تیره">
                    <span class="theme-icons"><x-icon name="sun" /><x-icon name="moon" /></span>
                </button>
                <a class="button button-small nav-cta" href="#showcase">محصول را ببینید</a>
                <button class="icon-button menu-toggle" type="button" data-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="باز کردن فهرست">
                    <span class="menu-icon-open"><x-icon name="menu" /></span>
                    <span class="menu-icon-close" hidden><x-icon name="close" /></span>
                </button>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero" id="top" aria-labelledby="hero-title">
            <div class="hero-border-orbits" aria-hidden="true"><i></i><i></i><i></i></div>
            <div class="hero-grid container">
                <div class="hero-copy">
                    <div class="hero-kicker"><span class="live-dot"></span>مدیریت هوشمند ساختمان</div>
                    <h1 id="hero-title">زندگی بهتر،<br><span>مجتمع هوشمندتر.</span></h1>
                    <p>بیلدینو، پلتفرم جامع مدیریت ساختمان و خدمات مجتمع است؛ برای زندگی منظم‌تر، امن‌تر و راحت‌تر و ارتباط ساده میان مدیر، مالک و ساکن.</p>
                    <div class="hero-actions">
                        <a class="button button-primary" href="#showcase">محصول را ببینید <x-icon name="arrow" size="19" /></a>
                        <a class="button button-ghost" href="#capabilities">چه کارهایی می‌کند؟</a>
                    </div>
                    <div class="hero-notes" aria-label="مزایای کلیدی">
                        <span><x-icon name="check" size="16" />ساکنان خوشحال</span>
                        <span><x-icon name="check" size="16" />مدیریت آسان</span>
                        <span><x-icon name="check" size="16" />خدمات سریع</span>
                        <span><x-icon name="check" size="16" />ساختمان هوشمند</span>
                    </div>
                </div>
            </div>
            <a class="scroll-cue" href="#overview"><span>بیشتر ببینید</span><i></i></a>
        </section>

        <section class="overview section" id="overview" aria-labelledby="overview-title">
            <div class="container">
                <div class="reveal section-head">
                    <h2 class="eyebrow" id="overview-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>چرا بیلدینو؟</span></h2>
                    <div class="section-statement">راهکاری مدرن برای<br><em>مدیریت ساختمان و مجتمع‌ها</em></div>
                    <p>بیلدینو با ترکیب فناوری و خدمات حرفه‌ای، کارهای پراکنده ساختمان را در یک مسیر مشخص جمع می‌کند؛ نتیجه، صرفه‌جویی در زمان و هزینه، شفافیت مالی، ارتباط بهتر مدیر و ساکنان، دسترسی سریع به خدمات و افزایش ارزش ساختمان است.</p>
                </div>
                <div class="overview-grid">
                    <div class="reveal overview-story">
                        <div class="story-number">۰۱</div>
                        <h3>هر ساختمان و هر واحد، حساب خودش را دارد</h3>
                        <p>بعد از ورود، همه واحدهایی را که به‌عنوان مالک یا ساکن به آن‌ها دسترسی دارید می‌بینید و اطلاعات هرکدام را جداگانه مدیریت می‌کنید.</p>
                        <div class="context-stack" aria-hidden="true">
                            <span><i>س</i>ساختمان سرو<small>انتخاب‌شده</small></span>
                            <span><i>۲</i>واحد ۲۱<small>خانه شما</small></span>
                            <span><i>ن</i>ساختمان نارون<small>واحد دیگر</small></span>
                        </div>
                    </div>
                    <div class="overview-points">
                        <div class="reveal overview-point" style="--delay:80ms"><span><x-icon name="layers" /></span><div><b>یک حساب برای همه واحدها</b><p>اگر در چند ساختمان مالک یا ساکن هستید، بدون خروج از حساب بین آن‌ها جابه‌جا شوید.</p></div></div>
                        <div class="reveal overview-point" style="--delay:140ms"><span><x-icon name="eye" /></span><div><b>پنل متناسب با نقش شما</b><p>مدیر، مالک و ساکن فقط اطلاعات و امکانات مرتبط با نقش و واحد خود را می‌بینند.</p></div></div>
                        <div class="reveal overview-point" style="--delay:200ms"><span><x-icon name="activity" /></span><div><b>ارتباط و اطلاع‌رسانی منظم</b><p>اطلاعیه‌ها، پیام‌های مدیریت و تغییر وضعیت درخواست‌ها به‌موقع به دست کاربران می‌رسند.</p></div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="capabilities section" id="capabilities" aria-labelledby="capabilities-title">
            <div class="container">
                <div class="reveal section-head center">
                    <h2 class="eyebrow" id="capabilities-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>امکانات بیلدینو</span></h2>
                    <div class="section-statement">از شارژ ماهانه تا رزرو سالن؛<br><em>همه‌چیز در یک اپلیکیشن</em></div>
                    <p>امکانات هر کاربر به ساختمان، واحد و سطح دسترسی او بستگی دارد؛ بنابراین هرکس دقیقاً بخش‌هایی را می‌بیند که برای او فعال شده‌اند.</p>
                </div>
                <div class="bento-grid">
                    <div class="reveal bento bento-context">
                        <div class="bento-copy"><span class="bento-icon"><x-icon name="building" /></span><small>همه اطلاعات، در یک نگاه</small><h3>همه واحدها، با دسترسی مخصوص خودشان</h3><p>مجتمع، بلوک، واحد، مالک، مستأجر و ساکنان را یک‌جا مدیریت کنید؛ اسناد، ورود و خروج، اطلاعیه‌ها و ارتباطات داخلی نیز برای هر نقش در دسترس است. ساختمان شما در دستان شماست.</p><ul><li>پنل مدیر، مالک و مستأجر</li><li>اطلاعات مستقل هر واحد</li><li>اسناد و دسترسی‌های مرتبط</li></ul></div>
                        <div class="building-visual" aria-hidden="true"><img src="{{ asset('images/buildings.webp') }}" width="1448" height="1086" loading="lazy" decoding="async" alt=""></div>
                    </div>
                    <div class="reveal bento bento-finance" style="--delay:100ms">
                        <div class="bento-copy"><span class="bento-icon"><x-icon name="wallet" /></span><small>مالی، شارژ و پرداخت‌ها</small><h3>صورتحساب‌ها، بدهی‌ها و پرداخت‌ها در یک نمای شفاف</h3><p>شارژ، سررسید، بدهی و سابقه تراکنش‌ها را در پنل مالی مالک و ساکن ببینید؛ جریمه دیرکرد یا مشوق‌ها را بررسی کنید و در صورت فعال‌بودن درگاه، آنلاین یا اقساطی پرداخت کنید.</p><ul><li>مدیریت و صدور صورتحساب</li><li>کیف پول و گزارش مالی</li><li>پرداخت آنلاین و اقساطی</li></ul></div>
                        <div class="finance-viz" aria-label="نمای نمونه کیف پول"><div class="donut"><span><b>کیف پول</b><small>اعتبار شما</small></span></div><div class="legend"><span><i></i>اعتبار فعلی</span><span><i></i>تراکنش‌ها</span><small>ورودی و خروجی حساب</small></div></div>
                    </div>
                    <div class="reveal bento bento-activity" style="--delay:140ms">
                        <span class="bento-icon"><x-icon name="activity" /></span><small>رزرو امکانات مشترک</small><h3>زمان آزاد را ببینید و درخواست رزرو بدهید</h3><p>سالن اجتماعات، باشگاه یا هر فضای قابل رزرو ساختمان را انتخاب کنید، زمان‌های خالی را ببینید و درخواستتان را ثبت کنید.</p>
                        <div class="mini-timeline"><span><i></i><b>انتخاب فضا</b><small>مثلاً سالن اجتماعات یا باشگاه</small></span><span><i></i><b>انتخاب زمان</b><small>بررسی ساعت‌های آزاد</small></span><span><i></i><b>ثبت درخواست</b><small>پیگیری نتیجه رزرو</small></span></div>
                    </div>
                    <div class="reveal bento bento-experience" style="--delay:180ms">
                        <div><span class="bento-icon"><x-icon name="layers" /></span><small>مهمان و ارتباط با مدیریت</small><h3>هماهنگی‌هایی که قبلاً با تماس انجام می‌شد</h3><p>مهمان را برای نگهبانی ثبت کنید، برای مدیریت تیکت بفرستید و پاسخ‌ها، پیام‌ها و تغییر وضعیت درخواست‌ها را از طریق اعلان‌ها دنبال کنید.</p></div>
                        <div class="theme-orbits" aria-hidden="true"><span class="orbit-light"><x-icon name="unit" /></span><i></i><span class="orbit-dark"><x-icon name="layers" /></span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="services section" id="services" aria-labelledby="services-title">
            <div class="container">
                <div class="reveal section-head">
                    <h2 class="eyebrow" id="services-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>خدمات ساختمان و واحد</span></h2>
                    <div class="section-statement">هر خدمتی که نیاز دارید؛<br><em>در دسترس و قابل پیگیری</em></div>
                    <p>برای تعمیرات، نظافت یا خدمات فوری نوع خدمت را انتخاب کنید، درخواستتان را ثبت کنید و هماهنگی با پیمانکاران موردتأیید را تا پایان کار دنبال کنید.</p>
                </div>
                <div class="services-grid">
                    <div class="reveal service-catalog">
                        <div class="service-catalog-head"><div><small>دسته‌بندی خدمات</small><h3>خدمت موردنیازتان را انتخاب کنید</h3></div><span><x-icon name="tool" /></span></div>
                        <div class="service-cards">
                            <article class="service-card"><span><x-icon name="tool" /></span><div><h4>تعمیرات و تأسیسات</h4><p>برق‌کاری، لوله‌کشی، سرمایش و گرمایش و خرابی‌های واحد</p></div><x-icon name="chevron" size="18" /></article>
                            <article class="service-card"><span><x-icon name="building" /></span><div><h4>آسانسور و تجهیزات</h4><p>رفع خرابی آسانسور، موتورخانه و تجهیزات مشترک ساختمان</p></div><x-icon name="chevron" size="18" /></article>
                            <article class="service-card"><span><x-icon name="layers" /></span><div><h4>نظافت و محوطه</h4><p>نظافت ساختمان، فضای سبز و رسیدگی به فضاهای مشترک</p></div><x-icon name="chevron" size="18" /></article>
                            <article class="service-card"><span><x-icon name="activity" /></span><div><h4>بازسازی و خدمات فوری</h4><p>خدمات بازسازی و رسیدگی سریع به درخواست‌های ضروری</p></div><x-icon name="chevron" size="18" /></article>
                        </div>
                        <p class="service-note"><x-icon name="check" size="17" /> خدمات فوری ۲۴/۷ و سایر سرویس‌ها براساس امکانات و پیمانکاران موردتأیید هر ساختمان ارائه می‌شوند؛ ثبت درخواست، پیگیری لحظه‌ای و کیفیت تضمین‌شده.</p>
                    </div>
                    <div class="reveal service-request" style="--delay:100ms" aria-label="نمونه رابط درخواست خدمات">
                        <div class="request-top"><span><x-icon name="tool" size="20" /></span><div><small>درخواست خدمات</small><b>بررسی نشتی لوله آشپزخانه</b></div><em>در حال بررسی</em></div>
                        <div class="request-context"><span><small>ساختمان</small><b>سرو</b></span><span><small>واحد</small><b>۲۱</b></span><span><small>ثبت درخواست</small><b>امروز، ۱۰:۳۰</b></span></div>
                        <div class="request-progress">
                            <div class="is-done"><i><x-icon name="check" size="15" /></i><span><b>درخواست ثبت شد</b><small>توضیحات برای مدیریت ارسال شد</small></span></div>
                            <div class="is-current"><i></i><span><b>در حال بررسی</b><small>هماهنگی با سرویس‌کار موردتأیید</small></span></div>
                            <div><i></i><span><b>تعیین زمان انجام</b><small>زمان مراجعه پس از هماهنگی اعلام می‌شود</small></span></div>
                        </div>
                        <div class="request-footer"><span><x-icon name="bell" size="18" /> تغییر وضعیت این درخواست به شما اعلام می‌شود.</span><button type="button" disabled aria-label="این دکمه بخشی از پیش‌نمایش محصول است">مشاهده درخواست</button></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="showcase section" id="showcase" aria-labelledby="showcase-title">
            <div class="showcase-glow" aria-hidden="true"></div>
            <div class="container showcase-grid">
                <div class="reveal section-head">
                    <h2 class="eyebrow" id="showcase-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>داخل محصول</span></h2>
                    <div class="section-statement"><em>خانه من</em>؛ نقطه شروع<br>همه کارهای واحد</div>
                    <p>واحد فعال، شارژهای جدید، کیف پول، درخواست‌ها و اعلان‌های مهم از یک صفحه در دسترس‌اند.</p>
                </div>
                <div class="reveal dashboard-wrap">
                    <div class="dash-window">
                        <div class="dash-sidebar"><x-logo /><nav aria-label="بخش‌های پیش‌نمایش محصول"><span class="active"><x-icon name="unit" size="18" />خانه من</span><span><x-icon name="wallet" size="18" />صورتحساب‌ها</span><span><x-icon name="activity" size="18" />درخواست‌ها</span></nav><div class="side-profile"><i>م</i><div><b>مریم احمدی</b><small>ساکن واحد ۲۱</small></div></div></div>
                        <div class="dash-main">
                            <div class="dash-top"><div><small>سلام مریم</small><h3>خانه من</h3></div><button type="button" disabled aria-label="انتخاب ساختمان در پیش‌نمایش محصول"><x-icon name="building" size="18" /><span>ساختمان سرو · واحد ۲۱</span><x-icon name="chevron" size="16" /></button></div>
                            <div class="dash-cards"><div class="dash-card hero-card"><small>پرداخت موفق</small><h4>شارژ شهریور واحد ۲۱</h4><p>از همراهی شما سپاسگزاریم</p><span><i></i>مدیریت مالی شفاف، اعتماد بیشتر</span><div class="card-wave"></div></div><div class="dash-card status-card"><small>کیف پول</small><div class="status-ring"><span>مشاهده<br>تراکنش‌ها</span></div><b>اعتبار و سابقه مالی</b></div></div>
                            <div class="dash-activity"><div><h4>آخرین اعلان‌ها</h4><span>دیدن همه</span></div><ul><li><i><x-icon name="wallet" size="17" /></i><span><b>شارژ جدید صادر شد</b><small>صورتحساب شهریور واحد ۲۱</small></span><em>امروز</em></li><li><i><x-icon name="activity" size="17" /></i><span><b>پشتیبانی پاسخ داد</b><small>درخواست بررسی تأسیسات</small></span><em>دیروز</em></li><li><i><x-icon name="layers" size="17" /></i><span><b>اطلاعیه جدید</b><small>جلسه مجمع این هفته برگزار می‌شود</small></span><em>شنبه</em></li></ul></div>
                        </div>
                    </div>
                    <div class="concept-label"><x-icon name="layers" size="15" />کارهای واحد ۲۱، در یک صفحه</div>
                </div>
            </div>
        </section>

        <section class="quality section" id="maintenance" aria-labelledby="maintenance-title">
            <div class="container quality-shell">
                <div class="reveal quality-copy"><h2 class="eyebrow" id="maintenance-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>نگهداری و بهره‌برداری</span></h2><div class="section-statement">عملکرد بهتر،<br><em>عمر بیشتر ساختمان</em></div><p>بیلدینو به مدیران ساختمان کمک می‌کند نگهداری و سرویس‌های دوره‌ای را حرفه‌ای مدیریت کنند؛ از ثبت درخواست و سوابق تعمیرات تا کنترل پیمانکاران و برنامه‌ریزی پیشگیرانه. نگهداری هوشمند برای ساختمانی مطمئن.</p></div>
                <div class="quality-list">
                    <div class="reveal quality-item" style="--delay:60ms"><x-icon name="activity" /><div><b>درخواست‌های نگهداری</b><small>ثبت درخواست و پیگیری روند انجام</small></div></div>
                    <div class="reveal quality-item" style="--delay:110ms"><x-icon name="calendar" /><div><b>سرویس‌های دوره‌ای</b><small>مدیریت زمان‌بندی و یادآوری سرویس</small></div></div>
                    <div class="reveal quality-item" style="--delay:160ms"><x-icon name="building" /><div><b>تجهیزات و سوابق تعمیرات</b><small>مدیریت تجهیزات و ثبت سابقه هر تعمیر</small></div></div>
                    <div class="reveal quality-item" style="--delay:210ms"><x-icon name="layers" /><div><b>کنترل و پیشگیری</b><small>پیمانکاران، چک‌لیست بازرسی و خدمات پیشگیرانه</small></div></div>
                </div>
            </div>
        </section>

        <section class="benefits section" aria-labelledby="benefits-title">
            <div class="container">
                <div class="reveal section-head center">
                    <h2 class="eyebrow" id="benefits-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>تجربه بهتر برای ساکنان</span></h2>
                    <div class="section-statement">ارتباط آسان‌تر؛<br><em>زندگی منظم‌تر در مجتمع</em></div>
                    <p>بیلدینو پیگیری امور روزمره را ساده‌تر می‌کند و با دسترسی سریع به اطلاعات، خدمات و مدیریت، زمان کمتری از ساکنان می‌گیرد.</p>
                </div>
                <div class="benefit-grid">
                    <div class="reveal benefit"><span>۱</span><h3>صرفه‌جویی در زمان و هزینه</h3><p>صورتحساب، درخواست و پیگیری را بدون تماس‌های مکرر یا مراجعه حضوری انجام دهید.</p></div>
                    <div class="reveal benefit" style="--delay:70ms"><span>۲</span><h3>اطلاعات و اسناد هر واحد</h3><p>اطلاعات واحد، ساکنان، اسناد در دسترس و سوابق مرتبط را منظم و جداگانه ببینید.</p></div>
                    <div class="reveal benefit" style="--delay:140ms"><span>۳</span><h3>رزرو و ورود مهمان</h3><p>امکانات مشترک را رزرو کنید و ورود مهمان را برای مدیریت یا نگهبانی ثبت کنید.</p></div>
                    <div class="reveal benefit" style="--delay:210ms"><span>۴</span><h3>همیشه در ارتباط، همیشه آگاه</h3><p>اطلاعیه‌های مجتمع، پاسخ پشتیبانی و تغییر وضعیت درخواست‌ها را به‌موقع دریافت کنید.</p></div>
                </div>
            </div>
        </section>

        <section class="how section" id="how" aria-labelledby="how-title">
            <div class="container how-grid">
                <div class="reveal section-head">
                    <h2 class="eyebrow" id="how-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>چطور کار می‌کند؟</span></h2>
                    <div class="section-statement">از ورود تا انجام کار،<br><em>چهار قدم ساده</em></div>
                    <p>بیلدینو واحد، نقش و دسترسی شما را می‌شناسد و فقط امکانات مربوط به همان ساختمان را در اختیارتان می‌گذارد.</p>
                </div>
                <div class="steps">
                    @foreach ([
                        ['۰۱', 'ثبت‌نام و ورود', 'واحدها و ساختمان‌هایی که به آن‌ها دسترسی دارید به حساب شما اضافه می‌شوند.'],
                        ['۰۲', 'انتخاب ساختمان و واحد', 'مشخص کنید می‌خواهید کارهای کدام واحد را به‌عنوان مالک یا ساکن انجام دهید.'],
                        ['۰۳', 'انجام کار موردنظر', 'صورتحساب را ببینید، رزرو ثبت کنید، مهمان معرفی کنید یا درخواست خدمات بدهید.'],
                        ['۰۴', 'پیگیری نتیجه', 'وضعیت درخواست‌ها، پاسخ پشتیبانی و اعلان‌های جدید را از داخل اپ دنبال کنید.'],
                    ] as $index => [$number, $title, $description])
                        <div class="reveal step" style="--delay:{{ $index * 60 }}ms"><span>{{ $number }}</span><div><h3>{{ $title }}</h3><p>{{ $description }}</p></div><i class="step-dot"></i></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="faq section" id="faq" aria-labelledby="faq-title">
            <div class="container faq-grid">
                <div class="reveal section-head">
                    <h2 class="eyebrow" id="faq-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>سؤال‌های رایج</span></h2>
                    <div class="section-statement">قبل از شروع، احتمالاً<br><em>این‌ها را می‌خواهید بدانید</em></div>
                    <p>جواب کوتاه و دقیق به سؤال‌هایی که معمولاً درباره بیلدینو پرسیده می‌شود.</p>
                </div>
                <div class="accordion">
                    @foreach (config('buildino.faqs') as $index => $faq)
                        <details @if($index === 0) open @endif>
                            <summary><span>{{ $faq['question'] }}</span><i><x-icon name="chevron" size="19" /></i></summary>
                            <div class="answer"><p>{{ $faq['answer'] }}</p></div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="final-cta section" aria-labelledby="organization-services-title">
            <div class="container">
                <div class="reveal cta-shell">
                    <div class="cta-building" aria-hidden="true"><img src="{{ asset('images/building-with-shadow.webp') }}" width="1448" height="1086" loading="lazy" decoding="async" alt=""></div>
                    <div class="cta-copy"><h2 class="eyebrow" id="organization-services-title"><i class="eyebrow-mark" aria-hidden="true"></i><span>خدمات ویژه و سازمانی</span></h2><div class="section-statement">ساختمان هوشمند،<br>آینده روشن‌تر</div><p>فراتر از یک اپلیکیشن؛ خرید بیمه ساختمان و خودرو، پرداخت اقساطی و تسهیلات، خدمات ویژه مجتمع‌ها، همکاری با پیمانکاران تأییدشده، نسخه سازمانی مجتمع‌های بزرگ و قابلیت توسعه خدمات آینده.</p><div><a href="#showcase" class="button button-light">داخل محصول را ببینید <x-icon name="arrow" size="19" /></a><a href="#capabilities" class="cta-link">مدیریت ساختمان و ساکنان</a></div></div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <img class="footer-skyline" src="{{ asset('images/milad-tower.webp') }}" width="1672" height="941" loading="lazy" decoding="async" alt="" aria-hidden="true">
        <div class="container footer-main">
            <div class="footer-brand">
                <x-logo />
                <p>همراه مالکان و ساکنان برای پیگیری امور ساختمان؛ از صورتحساب و خدمات تا رزرو امکانات و ارتباط با مدیریت.</p>
                <span class="footer-brand-caption">همه کارهای ساختمان، یک‌جا</span>
            </div>
            <nav class="footer-links" aria-label="آشنایی با بیلدینو">
                <h2>بیلدینو</h2>
                <a href="#overview">چرا بیلدینو؟</a>
                <a href="#capabilities">امکانات اپلیکیشن</a>
                <a href="#showcase">نگاهی به محصول</a>
            </nav>
            <nav class="footer-links" aria-label="راهنمای بیلدینو">
                <h2>بیشتر بدانید</h2>
                <a href="#services">خدمات ساختمان</a>
                <a href="#how">روش استفاده</a>
                <a href="#faq">سؤال‌های رایج</a>
            </nav>
        </div>
       <div class="container footer-legal">
            <span> طراحی و توسعه گروه تبلیغاتی بستا </span>
            <span> © تمامی حقوق مادی و معنوی برای مجموعه بیلدینو محفوظ می باشد.</span>
            <a class="footer-back-top" href="#top">بازگشت به بالا <x-icon name="arrow" size="16" /></a>
        </div>
    </footer>
</body>
</html>
