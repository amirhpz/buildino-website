@php($quickContact = config('home.contact'))
<div class="contact-float" data-contact-float>
    <div class="float-menu" id="quick-contact-menu" hidden>
        @if (filled($quickContact['whatsapp']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quickContact['whatsapp']) }}" target="_blank" rel="noopener noreferrer">واتساپ <span>↗</span></a>
        @else
            <span>واتساپ <small>به‌زودی</small></span>
        @endif
        <span>چت‌بات <small>به‌زودی</small></span>
        <span>چت با اپراتور <small>به‌زودی</small></span>
        <a href="{{ route('home') }}#contact" data-close-float>درخواست تماس یا مشاوره <span>↗</span></a>
    </div>
    <button class="float-toggle" type="button" data-contact-toggle aria-expanded="false" aria-controls="quick-contact-menu" aria-label="راه‌های تماس و مشاوره"><x-icon name="bell" size="23" /><span>مشاوره</span></button>
</div>
