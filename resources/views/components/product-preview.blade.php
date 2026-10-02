@props(['kind' => 'finance', 'title' => 'نمای محصول'])
<div class="product-preview" role="img" aria-label="{{ $title }}؛ قاب نمایشی با داده‌های نمونه">
<div class="preview-bar"><span class="preview-brand"><x-icon name="building" size="18" />بیلدینو</span><span class="sample-badge">داده‌ی نمونه</span></div>
<div class="preview-body">
@switch($kind)
@case('finance')
<div class="preview-context">مجتمع نمونه / واحد ۱۲</div><strong class="preview-heading">صورتحساب‌های من</strong><div class="preview-balance"><span>شارژ این ماه</span><strong>۲٬۴۰۰٬۰۰۰ <small>تومان</small></strong><span class="preview-status">در انتظار پرداخت</span></div><div class="preview-row"><span>هزینه‌ی نگهداری</span><b>ثبت‌شده</b></div><div class="preview-row"><span>شارژ ماه گذشته</span><b>پرداخت‌شده</b></div><span class="preview-footnote">اتصال درگاه پرداخت در نسخه‌ی کامل</span>
@break
@case('requests')
<div class="preview-context">خدمات ساختمان</div><strong class="preview-heading">درخواست تعمیر روشنایی</strong><div class="preview-request"><x-icon name="tool" size="28" /><div><b>روشنایی راهرو</b><small>درخواست نمونه / بخش مشترک</small></div><span class="preview-status">در حال بررسی</span></div><ol class="preview-timeline"><li>ثبت درخواست</li><li>بررسی مدیریت</li><li>هماهنگی انجام خدمات</li></ol>
@break
@case('booking')
<div class="preview-context">امکانات مشترک</div><strong class="preview-heading">رزرو سالن چندمنظوره</strong><div class="preview-calendar">@foreach(['ش','ی','د','س','چ','پ','ج','۱','۲','۳','۴','۵','۶','۷'] as $day)<span @class(['selected' => $day === '۴'])>{{ $day }}</span>@endforeach</div><div class="preview-row"><span>زمان انتخابی</span><b>۱۸:۰۰ تا ۱۹:۰۰</b></div><span class="preview-action">درخواست رزرو</span>
@break
@case('units')
<div class="preview-context">مدیریت مجتمع</div><strong class="preview-heading">ساختمان و واحدهای من</strong>@foreach(['بلوک آفتاب / واحد ۱۲','بلوک سرو / واحد ۸','نقش شما: مالک و ساکن'] as $row)<div class="preview-row"><x-icon name="unit" size="20" /><b>{{ $row }}</b></div>@endforeach<span class="preview-footnote">اطلاعات متناسب با نقش و دسترسی هر کاربر</span>
@break
@case('guests')
<div class="preview-context">هماهنگی با نگهبانی</div><strong class="preview-heading">مهمان‌های واحد من</strong><div class="preview-request"><x-icon name="unit" size="28" /><div><b>مهمان نمونه</b><small>واحد ۱۲ / امروز ساعت ۱۷</small></div></div><div class="preview-row"><span>وضعیت هماهنگی</span><b>اطلاع به نگهبانی</b></div><span class="preview-footnote">نمایش جزئیات براساس دسترسی مجاز</span>
@break
@default
<div class="preview-context">پیام‌های مدیریت</div><strong class="preview-heading">تابلوی اطلاع‌رسانی</strong><div class="preview-request"><x-icon name="bell" size="28" /><div><b>سرویس آسانسور</b><small>فردا، از ساعت ۹ تا ۱۱</small></div></div><div class="preview-row"><span>پاسخ به درخواست شما</span><b>پیام جدید</b></div><div class="preview-row"><span>صورتحساب این ماه</span><b>منتشر شد</b></div>
@endswitch
</div></div>
