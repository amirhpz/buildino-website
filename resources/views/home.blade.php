@extends('layouts.site')
@section('content')
@php($contact = config('home.contact'))

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
                                <img src="{{ asset($slide['image']) }}" srcset="{{ asset(str_replace('.webp', '-480.webp', $slide['image'])) }} 480w, {{ asset(str_replace('.webp', '-640.webp', $slide['image'])) }} 640w, {{ asset(str_replace('.webp', '-960.webp', $slide['image'])) }} 960w" sizes="(max-width:850px) calc(100vw - 80px), 480px" alt="{{ $slide['image_alt'] }}" width="720" height="540" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif decoding="async">
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
                    <div class="slider-arrows"><button type="button" class="autoplay-toggle" data-autoplay-toggle aria-pressed="false" aria-label="توقف پخش خودکار">توقف</button>
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

        @include('partials.product')

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
                </div>
                <div class="project-carousel" data-carousel data-autoplay="true" role="region" aria-roledescription="اسلایدر" aria-labelledby="projects-title" tabindex="0">
                    <div aria-live="off">
                        @foreach (config('home.projects') as $project)
                            <article class="project-slide @if ($loop->first) is-active @endif" data-slide role="article" aria-roledescription="اسلاید" aria-label="{{ $loop->iteration }} از {{ $loop->count }}" @unless ($loop->first) inert aria-hidden="true" @endunless>
                                @if (!empty($project['image']))
                                    <img class="covered-building-photo" src="{{ asset($project['image']) }}" srcset="{{ asset(str_replace('.webp', '-480.webp', $project['image'])) }} 480w, {{ asset(str_replace('.webp', '-640.webp', $project['image'])) }} 640w, {{ asset(str_replace('.webp', '-960.webp', $project['image'])) }} 960w" sizes="(max-width:850px) calc(100vw - 80px), 480px" alt="{{ $project['image_alt'] ?? $project['name'] }}" loading="lazy" width="640" height="480">
                                @else
                                    <div class="covered-building-icon" aria-hidden="true"><x-icon name="building" size="100" /></div>
                                @endif
                                <div class="project-copy">
                                    @if (!empty($project['location']))<span>{{ $project['location'] }}</span>@endif
                                    <h3>{{ $project['name'] }}</h3>
                                    @if (!empty($project['description']))<p>{{ $project['description'] }}</p>@endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @if (count(config('home.projects')) > 1)
                        <div class="project-controls"><button type="button" class="autoplay-toggle" data-autoplay-toggle aria-pressed="false" aria-label="توقف پخش خودکار">توقف</button>
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

        @include('partials.steps')

        <section class="section" id="pricing" aria-labelledby="pricing-title">
            <div class="container">
                <div class="section-heading">
                    <div><span class="eyebrow">تعرفه‌ها</span><h2 id="pricing-title">راهکار متناسب با اندازه ساختمان شما</h2></div>
                    <p>هزینه نهایی با توجه به تعداد واحدها، خدمات انتخابی و نیازهای هر مجموعه مشخص می‌شود.</p>
                </div>
                @include('partials.plans')
            </div>
        </section>

        <section class="section enterprise-section" id="enterprise" aria-labelledby="enterprise-title">
            <div class="container enterprise-shell">
                <div class="enterprise-copy"><span class="eyebrow">مشتریان سازمانی</span><h2 id="enterprise-title">مدیریت برج‌ها و مجتمع‌های بزرگ</h2><p>برج‌ها، مجتمع‌های چندبلوکی و مجموعه‌های سازمانی به فرایندها و سطح دسترسی متناسب با ساختار خود نیاز دارند. بیلدینو این نیازها را در قالب راهکار اختصاصی بررسی می‌کند.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-mint">گفت‌وگو درباره مجموعه شما <x-icon name="arrow" size="18" /></button></div>
                <div class="enterprise-visual" aria-hidden="true"><span class="enterprise-orbit"></span><img src="{{ asset('images/buildings-960.webp') }}" srcset="{{ asset('images/buildings-480.webp') }} 480w, {{ asset('images/buildings-640.webp') }} 640w, {{ asset('images/buildings-960.webp') }} 960w" sizes="(max-width:850px) calc(100vw - 80px), 480px" alt="" loading="lazy" width="570" height="430"></div>
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
            <div class="container about-shell"><div><span class="eyebrow">درباره ما</span><h2 id="about-title">زندگی بهتر، با مدیریت هوشمندتر مجتمع.</h2></div><div><p>بیلدینو کارهای روزمره ساختمان را ساده‌تر می‌کند؛ از مدیریت شارژ و درخواست خدمات تا رزرو امکانات و ارتباط با مدیر ساختمان.</p><a class="text-link" href="{{ route('about') }}">بیشتر درباره بیلدینو <x-icon name="arrow" size="18" /></a></div></div>
        </section>

        @include('partials.faq')

        <section class="section contact-section" id="contact" aria-labelledby="contact-title">
            <div class="container contact-shell">
                <div class="contact-intro"><span class="eyebrow">تماس با ما</span><h2 id="contact-title">برای ساختمان شما چه کاری می‌توانیم انجام دهیم؟</h2><p>برای شناخت راهکار مناسب مجموعه‌تان و دریافت اطلاعات تعرفه‌ها با ما در ارتباط باشید.</p>
                    @include('partials.contact-details')
                </div>
                <div class="contact-form-card"><span class="form-kicker">گفت‌وگو درباره نیاز ساختمان</span><h3>از مشاوره شروع کنید</h3><p>برای بررسی نیازهای مجموعه‌تان با ما تماس بگیرید.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-primary">درخواست مشاوره</button><a class="text-link contact-page-link" href="{{ route('contact') }}">اطلاعات کامل تماس <x-icon name="arrow" size="18" /></a></div>
            </div>
        </section>

@endsection
