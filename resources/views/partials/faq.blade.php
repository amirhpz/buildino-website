<section class="section faq-section" id="faq" aria-labelledby="faq-title">
    <div class="container faq-shell">
        <div class="section-heading"><div><span class="eyebrow">پاسخ‌های کوتاه</span><h2 id="faq-title">پرسش‌های رایج</h2></div><p>پیش از شروع، بیشتر با شیوه‌ی همکاری و امکانات آشنا شوید.</p></div>
        <div class="faq-list">
            @foreach ($questions ?? config('buildino.faqs') as $faq)
                <details class="faq-item"><summary>{{ $faq['question'] }}<span aria-hidden="true">+</span></summary><p>{{ $faq['answer'] }}</p></details>
            @endforeach
        </div>
    </div>
</section>
