@extends('layouts.site')
@section('title', 'تماس با ما | بیلدینو')
@section('description', 'تلفن و آدرس بیلدینو؛ برای بررسی نیازهای ساختمان و دریافت اطلاعات راه‌اندازی و تعرفه‌ها با ما تماس بگیرید.')
@section('content')
<x-page-banner title="تماس" />
<section class="section contact-section"><div class="container contact-shell">
    <div class="contact-intro"><span class="eyebrow">با ما در ارتباط باشید</span><h2>درباره ساختمان شما گفت‌وگو کنیم</h2><p>برای شناخت راهکار مناسب ساختمان، مجتمع یا مجموعه سازمانی خود با ما تماس بگیرید.</p>@include('partials.contact-details')</div>
    <div class="contact-form-card"><span class="form-kicker">شروع همکاری</span><h3>نیاز مجموعه‌تان را با ما در میان بگذارید</h3><p>تعداد واحدها، ساختار مدیریت و امکانات موردنیاز، نقطه‌ی شروع بررسی راهکار مناسب شماست.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-primary">درخواست مشاوره <x-icon name="arrow" size="18" /></button><p class="form-note">فرم در این نسخه نمایشی است. برای ارتباط واقعی از تلفن بالا استفاده کنید.</p></div>
</div></section>
@endsection
