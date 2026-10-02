<section class="section product-section" id="product" aria-labelledby="product-title">
    <div class="container">
        <div class="section-heading"><div><span class="eyebrow">نمای محصول</span><h2 id="product-title">کارهای روزمره، در یک نمای روشن</h2></div><p>این قاب‌ها معرفی نمایشی رابط کاربری با داده‌های نمونه‌اند؛ تصاویر واقعی محصول جایگزین خواهند شد.</p></div>
        <div class="product-grid">
            @foreach (['finance' => 'شارژ و صورتحساب', 'requests' => 'درخواست خدمات', 'booking' => 'رزرو امکانات'] as $kind => $title)
                <article class="product-card"><x-product-preview :kind="$kind" :title="$title" /><h3>{{ $title }}</h3><a class="text-link" href="{{ route('features') }}#{{ $kind }}">بیشتر درباره این امکان <x-icon name="arrow" size="16" /></a></article>
            @endforeach
        </div>
    </div>
</section>
