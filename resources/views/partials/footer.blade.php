<footer class="site-footer">
    <img class="footer-skyline" src="{{ asset('images/milad-tower.webp') }}" width="1672" height="941" loading="lazy" decoding="async" alt="" aria-hidden="true">
    <div class="container footer-main">
        <div><x-logo /><p>راهکاری برای مدیریت ساده‌تر ساختمان و ارتباط بهتر مدیر، مالک و ساکن.</p></div>
        <nav aria-label="پیوندهای پایین صفحه">
            @foreach (['features' => 'امکانات', 'pricing' => 'تعرفه‌ها', 'about' => 'درباره ما', 'contact' => 'تماس'] as $name => $label)
                <a href="{{ route($name) }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="footer-contact">
            <a href="tel:{{ preg_replace('/[^+0-9]/', '', config('home.contact.phone')) }}" dir="ltr">{{ config('home.contact.phone') }}</a>
            <p>{{ config('home.contact.address') }}</p>
        </div>
    </div>
    <div class="container footer-bottom"><span>© {{ date('Y') }} بیلدینو. تمامی حقوق محفوظ است.</span><a href="#main">بازگشت به بالا ↑</a></div>
</footer>
