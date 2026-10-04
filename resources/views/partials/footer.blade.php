@php($footerContact = config('home.contact'))
<footer class="site-footer" id="footer">
    <img class="footer-skyline" src="{{ asset('images/milad-tower-960.webp') }}" width="960" height="540" loading="lazy" decoding="async" alt="" aria-hidden="true">
    <div class="container footer-content">
        <div class="footer-main">
            <div class="footer-brand">
                <x-logo />
                <p>زندگی در مجتمع، با خیال آسوده‌تر.<br>بیلدینو کارهای روزمره ساختمان را به یک تجربه‌ی ساده و منظم تبدیل می‌کند.</p>
                <div class="footer-audience" aria-label="بیلدینو برای مدیر، مالک و ساکن"><span>مدیر</span><span>مالک</span><span>ساکن</span></div>
            </div>

            <nav class="footer-link-group" aria-labelledby="footer-discover-title">
                <h3 id="footer-discover-title">بیشتر بشناسید</h3>
                @foreach (['features' => 'امکانات بیلدینو', 'pricing' => 'پلن‌ها و تعرفه‌ها', 'about' => 'درباره ما', 'contact' => 'تماس با ما'] as $name => $label)
                    <a href="{{ route($name) }}">{{ $label }}</a>
                @endforeach
            </nav>

            <nav class="footer-link-group" aria-labelledby="footer-features-title">
                <h3 id="footer-features-title">مدیریت روزمره</h3>
                @foreach (['units' => 'ساختمان و واحدها', 'finance' => 'شارژ و صورتحساب', 'requests' => 'درخواست خدمات', 'booking' => 'رزرو امکانات'] as $id => $label)
                    <a href="{{ route('features') }}#{{ $id }}">{{ $label }}</a>
                @endforeach
            </nav>

            <div class="footer-contact">
                <h3>در ارتباط باشیم</h3>
                @if (filled($footerContact['phone']))
                    <a class="footer-phone" href="tel:{{ preg_replace('/[^+0-9]/', '', $footerContact['phone']) }}">
                        <x-icon name="phone" size="20" />
                        <span><small>با بیلدینو تماس بگیرید</small><strong dir="ltr">{{ $footerContact['phone'] }}</strong></span>
                    </a>
                @endif
                @if (filled($footerContact['address']))
                    <div class="footer-address"><x-icon name="location" size="20" /><address>{{ $footerContact['address'] }}</address></div>
                @endif
                @if (filled($footerContact['email']))
                    <a class="footer-email" href="mailto:{{ $footerContact['email'] }}"><x-icon name="mail" size="19" /><span dir="ltr">{{ $footerContact['email'] }}</span></a>
                @endif
                @if (filled($footerContact['instagram']) || filled($footerContact['linkedin']))
                    <div class="footer-socials">
                        @foreach (['instagram' => 'اینستاگرام', 'linkedin' => 'لینکدین'] as $key => $label)
                            @if (filled($footerContact[$key]))<a href="{{ $footerContact[$key] }}" target="_blank" rel="noopener noreferrer">{{ $label }} <x-icon name="arrow" size="14" /></a>@endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} بیلدینو. تمامی حقوق محفوظ است.</span>
            <span class="footer-credit">توسعه توسط تیم بستا</span>
            <a class="footer-back-top" href="#main">بازگشت به بالا <x-icon name="arrow-up" size="17" /></a>
        </div>
    </div>
</footer>
