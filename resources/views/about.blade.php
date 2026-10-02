@extends('layouts.site')
@section('title', 'درباره ما | بیلدینو')
@section('description', 'بیلدینو برای ارتباط بهتر مدیر، مالک و ساکن و مدیریت منظم ساختمان؛ با شیوه همکاری و راه‌اندازی متناسب با نیاز مجموعه آشنا شوید.')
@section('content')
<x-page-banner title="درباره ما" />
<section class="section"><div class="container about-shell"><div><span class="eyebrow">همراه زندگی در مجتمع</span><h2>کارهای پراکنده، یک مسیر مشخص</h2><p>بیلدینو راهکاری برای مدیریت ساختمان و مجتمع است؛ اطلاعات واحدها، شارژ، درخواست‌ها و پیام‌های مدیریت را در یک فضای مشترک جمع می‌کند.</p><p>هدف ما ساده‌ترشدن کارهای روزمره و روشن‌ترشدن ارتباط بین مدیر، مالک و ساکن است. امکانات و سطح دسترسی با نیاز هر مجموعه تنظیم می‌شوند.</p></div><x-product-preview kind="units" title="مدیریت مجتمع و واحدها" /></div></section>
<section class="section section-soft"><div class="container"><div class="section-heading"><div><span class="eyebrow">مخاطبان ما</span><h2>همراه هر نقش در ساختمان</h2></div></div><div class="steps-grid">
@foreach(['مدیر ساختمان' => 'برای پیگیری امور واحدها، صورتحساب‌ها، پیام‌ها و درخواست‌های ساختمان.', 'مالک' => 'برای دسترسی به اطلاعات واحدهای مرتبط و پیگیری امور مالی و مدیریتی.', 'ساکن' => 'برای دریافت اطلاعیه‌ها، درخواست خدمات، رزرو امکانات و هماهنگی مهمان.'] as $title => $text)
<article class="step-card"><span class="card-icon"><x-icon name="building" size="24" /></span><h3>{{ $title }}</h3><p>{{ $text }}</p></article>
@endforeach
</div></div></section>
@include('partials.steps')
<section class="section"><div class="container about-shell"><div><span class="eyebrow">همکاری متناسب با نیاز شما</span><h2>از شناخت ساختمان شروع می‌کنیم</h2></div><div><p>تعداد واحدها، ساختار مدیریت و خدمات موردنیاز را با هم بررسی می‌کنیم تا دامنه‌ی راهکار و هزینه‌ی آن پیش از راه‌اندازی روشن باشد.</p><button type="button" class="button button-primary" data-consultation-open aria-haspopup="dialog">درخواست مشاوره</button></div></div></section>
@endsection
