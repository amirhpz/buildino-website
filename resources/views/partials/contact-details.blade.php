@php($contact = config('home.contact'))
<div class="contact-details">
    @if(filled($contact['phone']))<a href="tel:{{ preg_replace('/[^+0-9]/', '', $contact['phone']) }}"><span>تلفن</span><strong dir="ltr">{{ $contact['phone'] }}</strong></a>@endif
    @if(filled($contact['email']))<a href="mailto:{{ $contact['email'] }}"><span>ایمیل</span><strong dir="ltr">{{ $contact['email'] }}</strong></a>@endif
    @if(filled($contact['address']))<div><span>آدرس</span><strong>{{ $contact['address'] }}</strong></div>@endif
</div>
<div class="social-links">
    @foreach(['instagram' => 'پرداخت‌شده', 'linkedin' => 'لینکدین'] as $key => $label)
        @if(filled($contact[$key]))<a href="{{ $contact[$key] }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a>@endif
    @endforeach
</div>
