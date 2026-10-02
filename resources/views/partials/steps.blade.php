<section class="section section-soft" id="how" aria-labelledby="how-title">
    <div class="container">
        <div class="section-heading"><div><span class="eyebrow">شروع همکاری</span><h2 id="how-title">سه گام تا مدیریت منظم‌تر</h2></div><p>از شناخت نیاز ساختمان تا آماده‌شدن راهکار، همراه شما هستیم.</p></div>
        <div class="steps-grid">
            @foreach (config('home.steps') as $step)
                <article class="step-card"><span class="step-number">{{ ['۰۱','۰۲','۰۳'][$loop->index] }}</span><h3>{{ $step['title'] }}</h3><p>{{ $step['description'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>
