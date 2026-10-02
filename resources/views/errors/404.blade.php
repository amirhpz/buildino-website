@extends('layouts.site')
@section('title', 'صفحه پیدا نشد | بیلدینو')
@section('description', 'صفحه موردنظر پیدا نشد؛ به صفحه اصلی بیلدینو برگردید یا امکانات مدیریت ساختمان را ببینید.')
@section('robots', 'noindex,follow')
@section('content')
<x-page-banner title="صفحه پیدا نشد" />
<section class="section"><div class="container error-page"><span class="error-code">۴۰۴</span><h2>این صفحه در دسترس نیست</h2><p>نشانی را بررسی کنید یا از صفحه‌ی اصلی ادامه دهید.</p><a class="button button-primary" href="{{ route('home') }}">بازگشت به صفحه اصلی</a><a class="button button-outline" href="{{ route('features') }}">دیدن امکانات</a></div></section>
@endsection
