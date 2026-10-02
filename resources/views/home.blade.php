<!doctype html>
<html lang="fa-IR" dir="rtl">
<head>
    @php
        $canonicalUrl = rtrim((string) config('app.url'), '/').'/';
        $socialImage = rtrim((string) config('app.url'), '/').config('buildino.social_image');
        $contact = config('home.contact');
        $contactReady = filled($contact['recipient']) && !in_array(config('mail.default'), ['log', 'array'], true);
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('buildino.name'),
            'url' => $canonicalUrl,
            'description' => config('buildino.description'),
            'inLanguage' => config('buildino.language'),
        ];
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="{{ config('buildino.description') }}">
    <meta name="theme-color" content="#0c2339">
    <title>{{ config('buildino.title') }}</title>
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/brand-color.png') }}">
    <link rel="preload" href="{{ asset('fonts/iranyekanrd/IRANYekanRegularRd.ttf') }}" as="font" type="font/ttf" crossorigin>
    <meta property="og:locale" content="{{ config('buildino.locale') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('buildino.title') }}">
    <meta property="og:description" content="{{ config('buildino.og_description') }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <script type="application/ld+json" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <script src="{{ asset('theme-init.js') }}" nonce="{{ Illuminate\Support\Facades\Vite::cspNonce() }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">پرش به محتوا</a>

    <header class="site-header" data-site-header>
        <div class="container nav-shell">
            <x-logo />
            <nav id="primary-navigation" class="main-nav" aria-label="ناوبری اصلی" data-main-nav>
                <a href="#features">امکانات</a>
                <a href="#services">خدمات</a>
                @if (count(config('home.projects', [])))<a href="#projects">پروژه‌ها</a>@endif
                <a href="#pricing">تعرفه‌ها</a>
                <a href="#about">درباره ما</a>
            </nav>
            <div class="nav-actions">
                <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="تغییر حالت نمایش">
                    <span class="theme-icons"><x-icon name="moon" /><x-icon name="sun" /></span>
                </button>
                <button type="button" data-consultation-open aria-haspopup="dialog" class="button button-small button-primary nav-cta">درخواست مشاوره</button>
                <button class="icon-button menu-toggle" type="button" data-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="باز کردن فهرست">
                    <span class="menu-icon-open"><x-icon name="menu" /></span>
                    <span class="menu-icon-close" hidden><x-icon name="close" /></span>
                </button>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero" id="top" aria-label="معرفی بیلدینو">
            <div class="hero-border-orbits" aria-hidden="true"><i></i><i></i><i></i></div>
            <div class="container hero-shell" data-carousel data-autoplay="true">
                <div class="hero-slides" aria-live="off">
                    @foreach (config('home.slides') as $slide)
                        <article class="hero-slide @if ($loop->first) is-active @endif" data-slide @unless ($loop->first) inert aria-hidden="true" @endunless>
                            <div class="hero-content">
                                <span class="hero-kicker"><span class="kicker-dot"></span>{{ $slide['eyebrow'] }}</span>
                                @if ($loop->first)
                                    <h1>{{ $slide['title'] }}</h1>
                                @else
                                    <h2>{{ $slide['title'] }}</h2>
                                @endif
                                <p>{{ $slide['description'] }}</p>
                                <div class="hero-actions">
                                    <a class="button button-mint" href="{{ $slide['target'] }}">{{ $slide['cta'] }} <x-icon name="arrow" size="18" /></a>
                                    <button type="button" data-consultation-open aria-haspopup="dialog" class="button button-outline-light">گفت‌وگو درباره نیاز شما</button>
                                </div>
                            </div>
                            <div class="hero-visual">
                                <span class="visual-glow" aria-hidden="true"></span>
                                <img src="{{ asset($slide['image']) }}" alt="{{ $slide['image_alt'] }}" width="720" height="540" @if (!$loop->first) loading="lazy" @endif>
                                <div class="visual-caption"><span class="caption-icon"><x-icon name="building" size="18" /></span><span>بیلدینو<small>همراه مدیریت هوشمند مجتمع</small></span></div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="hero-bottom">
                    <div class="slider-dots" aria-label="انتخاب اسلاید">
                        @foreach (config('home.slides') as $slide)
                            <button type="button" data-slide-dot aria-label="نمایش اسلاید {{ $loop->iteration }}" @if ($loop->first) aria-current="true" @endif></button>
                        @endforeach
                    </div>
                    <div class="slider-arrows">
                        <button type="button" data-slide-prev aria-label="اسلاید قبلی"><x-icon name="chevron" size="18" /></button>
                        <button type="button" data-slide-next aria-label="اسلاید بعدی"><x-icon name="chevron" size="18" /></button>
                    </div>
                </div>
            </div>
        </section>

        <section class="audience-strip" aria-label="بیلدینو برای چه کسانی است">
            <div class="container audience-grid">
                <div><span>برای مدیر</span><strong>مدیریت منظم‌تر مجتمع</strong></div>
                <div><span>برای مالک</span><strong>شفافیت در امور واحد</strong></div>
                <div><span>برای ساکن</span><strong>خدمات در دسترس‌تر</strong></div>
            </div>
        </section>

        <section class="section" id="features" aria-labelledby="features-title">
            <div class="container">
                <div class="section-heading">
                    <div><span class="eyebrow">امکانات بیلدینو</span><h2 id="features-title">هر آنچه برای یک مجتمع منظم لازم است</h2></div>
                    <p>امکانات اصلی را در یک نگاه ببینید. دسترسی هر کاربر براساس نقش و تنظیمات ساختمان او تعریف می‌شود.</p>
                </div>
                <div class="feature-grid">
                    @foreach (config('home.features') as $feature)
                        <a class="feature-card" href="{{ $feature['target'] }}">
                            <span class="card-icon"><x-icon :name="$feature['icon']" size="26" /></span>
                            <h3>{{ $feature['title'] }}</h3>
                            <p>{{ $feature['description'] }}</p>
                            <span class="card-arrow" aria-hidden="true"><x-icon name="arrow" size="18" /></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section section-soft" id="services" aria-labelledby="services-title">
            <div class="container">
                <div class="section-heading">
                    <div><span class="eyebrow">خدمات ما</span><h2 id="services-title">از مدیریت روزمره تا خدمات آینده</h2></div>
                    <p>خدمات موردنیاز ساختمان را بشناسید و درخواست‌های خود را پیگیری کنید.</p>
                </div>
                <div class="service-grid">
                    @foreach (config('home.services') as $service)
                        <article class="service-card">
                            <span class="service-icon"><x-icon :name="$service['icon']" size="22" /></span>
                            <div><h3>{{ $service['title'] }}</h3><p>{{ $service['description'] }}</p></div>
                            <span class="service-status @if ($service['status'] === 'در برنامه توسعه') is-future @endif">{{ $service['status'] }}</span>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        @if (count(config('home.projects', [])))
        <section class="section projects-section" id="projects" aria-labelledby="projects-title">
            <div class="container">
                <div class="section-heading">
                    <div><span class="eyebrow">همراهان بیلدینو</span><h2 id="projects-title">ساختمان‌های تحت پوشش ما</h2></div>
                    <p>با ساختمان‌ها و مجتمع‌های همراه بیلدینو آشنا شوید.</p>
                </div>
                <div class="project-carousel" data-carousel data-autoplay="true" role="region" aria-roledescription="اسلایدر" aria-labelledby="projects-title" tabindex="0">
                    <div aria-live="off">
                        @foreach (config('home.projects') as $project)
                            <article class="project-slide" data-slide role="group" aria-roledescription="اسلاید" aria-label="{{ $loop->iteration }} از {{ $loop->count }}" @if (!$loop->first) hidden @endif>
                                @if (!empty($project['image']))
                                    <img class="covered-building-photo" src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] ?? $project['name'] }}" loading="lazy" width="640" height="480">
                                @else
                                    <div class="covered-building-icon" aria-hidden="true"><x-icon name="building" size="100" /></div>
                                @endif
                                <div class="project-copy">
                                    <span>{{ $project['location'] ?? 'تحت پوشش بیلدینو' }}</span>
                                    <h3>{{ $project['name'] }}</h3>
                                    @if (!empty($project['description']))<p>{{ $project['description'] }}</p>@endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @if (count(config('home.projects')) > 1)
                        <div class="project-controls">
                            <button type="button" data-slide-prev aria-label="ساختمان قبلی"><x-icon name="chevron" size="18" /></button>
                            <button type="button" data-slide-next aria-label="ساختمان بعدی"><x-icon name="chevron" size="18" /></button>
                        </div>
                        <div class="covered-building-dots slider-dots" aria-label="انتخاب ساختمان">
                            @foreach (config('home.projects') as $project)
                                <button type="button" data-slide-dot aria-label="نمایش {{ $project['name'] }}" @if ($loop->first) aria-current="true" @endif></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        @if (count(config('home.statistics', [])))
        <section class="section stats-section" id="stats" aria-labelledby="stats-title">
            <div class="container stats-shell">
                <div><span class="eyebrow">بیلدینو در یک نگاه</span><h2 id="stats-title">رشد در یک نگاه</h2><p>ساختمان‌ها، ساکنان و خدمات بیلدینو در یک نگاه.</p></div>
                <div class="stats-grid">
                    @foreach (['مجتمع‌ها', 'واحدهای تحت مدیریت', 'کاربران', 'خدمات ثبت‌شده'] as $label)
                        <div><strong>{{ config('home.statistics.'.$loop->index.'.value', '—') }}</strong><span>{{ config('home.statistics.'.$loop->index.'.label', $label) }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="section" id="pricing" aria-labelledby="pricing-title">
            <div class="container">
                <div class="section-heading">
                    <div><span class="eyebrow">تعرفه‌ها</span><h2 id="pricing-title">راهکار متناسب با اندازه ساختمان شما</h2></div>
                    <p>هزینه نهایی با توجه به تعداد واحدها، خدمات انتخابی و نیازهای هر مجموعه مشخص می‌شود.</p>
                </div>
                <div class="pricing-grid">
                    @foreach (config('home.plans') as $plan)
                        <article class="pricing-card @if ($loop->index === 1) is-featured @endif">
                            <span class="plan-index">پلن {{ $loop->iteration }}</span><h3>{{ $plan['name'] }}</h3><p>{{ $plan['subtitle'] }}</p>
                            <div class="price-line">تعرفه با استعلام</div>
                            <ul>@foreach ($plan['items'] as $item)<li><x-icon name="check" size="18" />{{ $item }}</li>@endforeach</ul>
                            <a class="button @if ($loop->index === 1) button-primary @else button-outline @endif" href="{{ route('pricing') }}">جزئیات تعرفه <x-icon name="arrow" size="17" /></a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section enterprise-section" id="enterprise" aria-labelledby="enterprise-title">
            <div class="container enterprise-shell">
                <div class="enterprise-copy"><span class="eyebrow">مشتریان سازمانی</span><h2 id="enterprise-title">مدیریت برج‌ها و مجتمع‌های بزرگ</h2><p>برج‌ها، مجتمع‌های چندبلوکی و مجموعه‌های سازمانی به فرایندها و سطح دسترسی متناسب با ساختار خود نیاز دارند. بیلدینو این نیازها را در قالب راهکار اختصاصی بررسی می‌کند.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-mint">گفت‌وگو درباره مجموعه شما <x-icon name="arrow" size="18" /></button></div>
                <div class="enterprise-visual" aria-hidden="true"><span class="enterprise-orbit"></span><img src="{{ asset('images/buildings.webp') }}" alt="" loading="lazy" width="570" height="430"></div>
            </div>
        </section>

        @if (count(config('home.articles', [])))
        <section class="section" id="insights" aria-labelledby="insights-title">
            <div class="container">
                <div class="section-heading"><div><span class="eyebrow">اخبار و مقالات</span><h2 id="insights-title">دانش بهتر برای مدیریت بهتر</h2></div><p>راهنماها و خبرهای مدیریت ساختمان.</p></div>
                @if (count(config('home.articles')))
                    <div class="article-grid">
                        @foreach (array_slice(config('home.articles'), 0, 3) as $article)
                            <article class="article-card"><img src="{{ asset($article['image']) }}" alt="{{ $article['image_alt'] }}" loading="lazy"><div><span>{{ $article['category'] }}</span><h3>@if (isset($article['url']))<a href="{{ $article['url'] }}">{{ $article['title'] }}</a>@else{{ $article['title'] }}@endif</h3><p>{{ $article['excerpt'] }}</p></div></article>
                        @endforeach
                    </div>
                @else
                    <div class="insights-placeholder"><span class="card-icon"><x-icon name="layers" size="28" /></span><div><h3>مجله بیلدینو در راه است</h3><p>به‌زودی راهنماها و خبرهای مرتبط با مدیریت ساختمان را اینجا منتشر می‌کنیم.</p></div></div>
                @endif
            </div>
        </section>
        @endif

        <section class="section section-soft about-section" id="about" aria-labelledby="about-title">
            <div class="container about-shell"><div><span class="eyebrow">درباره ما</span><h2 id="about-title">زندگی بهتر، با مدیریت هوشمندتر مجتمع.</h2></div><div><p>بیلدینو کارهای روزمره ساختمان را ساده‌تر می‌کند؛ از مدیریت شارژ و درخواست خدمات تا رزرو امکانات و ارتباط با مدیر ساختمان.</p><a class="text-link" href="#contact">با بیلدینو در ارتباط باشید <x-icon name="arrow" size="18" /></a></div></div>
        </section>

        <section class="section contact-section" id="contact" aria-labelledby="contact-title">
            <div class="container contact-shell">
                <div class="contact-intro"><span class="eyebrow">تماس با ما</span><h2 id="contact-title">برای ساختمان شما چه کاری می‌توانیم انجام دهیم؟</h2><p>برای شناخت راهکار مناسب مجموعه‌تان و دریافت اطلاعات تعرفه‌ها با ما در ارتباط باشید.</p>
                    <div class="contact-details">
                        @if (filled($contact['phone']))<a href="tel:{{ preg_replace('/[^+0-9]/', '', $contact['phone']) }}"><span>تلفن</span><strong dir="ltr">{{ $contact['phone'] }}</strong></a>@endif
                        @if (filled($contact['email']))<a href="mailto:{{ $contact['email'] }}"><span>ایمیل</span><strong dir="ltr">{{ $contact['email'] }}</strong></a>@endif
                        @if (filled($contact['address']))<div><span>آدرس</span><strong>{{ $contact['address'] }}</strong></div>@endif
                    </div>
                    <div class="social-links">
                        @if (filled($contact['instagram']))<a href="{{ $contact['instagram'] }}" target="_blank" rel="noopener noreferrer">اینستاگرام</a>@endif
                        @if (filled($contact['linkedin']))<a href="{{ $contact['linkedin'] }}" target="_blank" rel="noopener noreferrer">لینکدین</a>@endif
                    </div>
                </div>
                @if ($contactReady)
                <div class="contact-form-card"><span class="form-kicker">درخواست مشاوره</span><h3>پیام خود را برای ما بنویسید</h3>
                    @if (session('contact_success'))<p class="form-alert" role="status">{{ session('contact_success') }}</p>@endif
                    @if ($errors->any())<p class="form-alert is-error" role="alert">لطفاً اطلاعات فرم را بررسی کنید و دوباره بفرستید.</p>@endif
                    <form action="{{ route('contact.store') }}" method="post">
                        @csrf
                        <div class="form-row"><label>نام و نام خانوادگی<input name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required @disabled(!$contactReady)></label><label>شماره تماس<input name="phone" value="{{ old('phone') }}" inputmode="tel" autocomplete="tel" maxlength="30" required @disabled(!$contactReady)></label></div>
                        <label>موضوع<select name="subject" required @disabled(!$contactReady)><option value="">انتخاب موضوع</option><option value="consultation" @selected(old('subject') === 'consultation')>مشاوره و راه‌اندازی</option><option value="pricing" @selected(old('subject') === 'pricing')>تعرفه‌ها</option><option value="services" @selected(old('subject') === 'services')>خدمات</option></select></label>
                        <label>پیام<textarea name="message" rows="4" maxlength="2000" required @disabled(!$contactReady)>{{ old('message') }}</textarea></label>
                        <button class="button button-primary" type="submit" @disabled(!$contactReady)>ارسال درخواست <x-icon name="arrow" size="17" /></button>
                    </form>
                </div>
                @endif
            </div>
        </section>
    </main>

    <footer class="site-footer"><img class="footer-skyline" src="{{ asset('images/milad-tower.webp') }}" width="1672" height="941" loading="lazy" decoding="async" alt="" aria-hidden="true"><div class="container footer-main"><div><x-logo /><p>راهکاری برای مدیریت ساده‌تر ساختمان و ارتباط بهتر مدیر، مالک و ساکن.</p></div><nav aria-label="پیوندهای پایین صفحه"><a href="#features">امکانات</a><a href="#services">خدمات</a><a href="#pricing">تعرفه‌ها</a><a href="#contact">تماس</a></nav></div><div class="container footer-bottom"><span>© {{ date('Y') }} بیلدینو. تمامی حقوق محفوظ است.</span><a href="#top">بازگشت به بالا ↑</a></div></footer>

    @include('partials.contact-float')
</body>
</html>
