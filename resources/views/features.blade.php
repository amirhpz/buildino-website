@extends('layouts.site')
@section('title', 'امکانات مدیریت ساختمان | بیلدینو')
@section('description', 'شش قابلیت بیلدینو برای مدیریت واحدها، شارژ و صورتحساب، رزرو امکانات، مهمان، اطلاع‌رسانی و درخواست خدمات ساختمان.')
@section('content')
<x-page-banner title="امکانات" />
<section class="section"><div class="container"><div class="section-heading"><div><span class="eyebrow">یک پلتفرم، کارهای کمتر</span><h2>ساختمان شما، منظم و قابل پیگیری</h2></div></div>
<div class="feature-details">
@foreach(config('home.features') as $feature)
    <article class="feature-detail" id="{{ $feature['id'] }}">
        <div><span class="card-icon"><x-icon :name="$feature['icon']" size="26" /></span><h2>{{ $feature['title'] }}</h2><p>{{ $feature['detail'] }}</p><a class="text-link" href="{{ route('contact') }}">درباره نیاز ساختمان خود بپرسید <x-icon name="arrow" size="18" /></a></div>
        <x-product-preview :kind="$feature['id']" :title="$feature['title']" :show-sample="false" />
    </article>
@endforeach
</div></div></section>
@include('partials.faq')
@endsection
