<div class="pricing-grid">
    @foreach (config('home.plans') as $plan)
        <article class="pricing-card @if ($loop->index === 1) is-featured @endif">
            <span class="plan-index">پلن {{ $loop->iteration }}</span><h3>{{ $plan['name'] }}</h3><p>{{ $plan['subtitle'] }}</p>
            <div class="price-line">تعرفه با استعلام</div>
            <ul>@foreach ($plan['items'] as $item)<li><x-icon name="check" size="18" />{{ $item }}</li>@endforeach</ul>
            @if ($consultation ?? false)
                <button type="button" data-consultation-open aria-haspopup="dialog" class="button @if ($loop->index === 1) button-primary @else button-outline @endif">درخواست مشاوره <x-icon name="arrow" size="17" /></button>
            @else
                <a class="button @if ($loop->index === 1) button-primary @else button-outline @endif" href="{{ route('pricing') }}">داده‌ی نمونه <x-icon name="arrow" size="17" /></a>
            @endif
        </article>
    @endforeach
</div>
