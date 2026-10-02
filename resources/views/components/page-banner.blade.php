@props(['title'])
<section class="pricing-hero" id="top">
    <nav class="container" aria-label="مسیر صفحه"><a class="pricing-back" href="{{ route('home') }}">صفحه اصلی</a><span class="breadcrumb-separator" aria-hidden="true">/</span><h1 aria-current="page">{{ $title }}</h1></nav>
</section>
