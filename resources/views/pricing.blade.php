@extends('layouts.site')
@section('title', 'تعرفه‌ها | بیلدینو')
@section('description', 'مقایسه پلن‌های ساختمان، مجتمع و سازمانی بیلدینو؛ هزینه راه‌اندازی و اشتراک با استعلام متناسب با نیاز مجموعه.')
@section('content')

        <x-page-banner title="تعرفه‌ها" />
        <section class="section" aria-labelledby="plans-title"><div class="container"><div class="section-heading"><div><span class="eyebrow">مدل همکاری</span><h2 id="plans-title">پلن‌ها را مقایسه کنید</h2></div><p>امکانات هر پلن را ببینید و متناسب با نیاز ساختمان خود انتخاب کنید.</p></div>@include('partials.plans', ['consultation' => true])</div></section>
        <section class="section section-soft"><div class="container pricing-explainer"><div><span class="eyebrow">قیمت‌گذاری شفاف</span><h2>تعرفه نهایی چطور مشخص می‌شود؟</h2></div><div><p>هزینه راه‌اندازی و اشتراک به تعداد واحدها و خدمات موردنیاز ساختمان بستگی دارد. برای دریافت پیشنهاد قیمت، با ما تماس بگیرید.</p><button type="button" data-consultation-open aria-haspopup="dialog" class="button button-primary">درخواست بررسی مجموعه شما <x-icon name="arrow" size="17" /></button></div></div></section>

<section class="section comparison-section" aria-labelledby="comparison-title"><div class="container">
    <div class="section-heading"><div><span class="eyebrow">انتخاب آگاهانه</span><h2 id="comparison-title">تفاوت پلن‌ها در یک نگاه</h2></div><p>دامنه‌ی راهکار هر مجموعه در گفت‌وگوی اولیه مشخص می‌شود.</p></div>
    <div class="comparison-table"><table><caption class="sr-only">مقایسه امکانات پلن‌های بیلدینو</caption><thead><tr><th scope="col">امکانات</th>@foreach(config('home.plans') as $plan)<th scope="col">{{ $plan['name'] }}</th>@endforeach</tr></thead><tbody>
        @foreach(config('home.comparison') as $row)<tr><th scope="row">{{ $row['label'] }}</th>@foreach($row['values'] as $value)<td>{{ $value }}</td>@endforeach</tr>@endforeach
    </tbody></table></div>
    <div class="comparison-mobile">@foreach(config('home.plans') as $plan)<details class="faq-item"><summary>مقایسه پلن {{ $plan['name'] }}<span aria-hidden="true">+</span></summary><dl>@foreach(config('home.comparison') as $row)<div><dt>{{ $row['label'] }}</dt><dd>{{ $row['values'][$loop->parent->index] }}</dd></div>@endforeach</dl></details>@endforeach</div>
</div></section>
@include('partials.faq', ['questions' => config('home.pricing_faqs')])

@endsection
