@php($showConsultationDemoNote = !request()->routeIs('contact'))
<dialog class="consultation-modal" data-consultation-modal aria-labelledby="consultation-title" @if($showConsultationDemoNote) aria-describedby="consultation-description" @endif>
    <div class="consultation-content">
        <button class="consultation-close" type="button" data-consultation-close aria-label="بستن فرم">×</button>
        <div class="consultation-intro"><span class="consultation-badge"><x-icon name="building" size="24" /></span>
        <span class="eyebrow">مشاوره بیلدینو</span>
        <h2 id="consultation-title">از ساختمان شما شروع کنیم</h2>
        @if($showConsultationDemoNote)<p id="consultation-description">این فرم نمایشی است؛ اطلاعات ارسال یا ذخیره نمی‌شوند.</p>@endif</div>
        <form method="dialog" data-consultation-form>
            <div class="consultation-fields">
                <label for="consultation-name">نام و نام خانوادگی<input id="consultation-name" name="name" autocomplete="name" maxlength="100" required autofocus placeholder="نام شما"></label>
                <label for="consultation-phone">شماره تماس<input id="consultation-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" dir="ltr" pattern="\+?[0-9۰-۹٠-٩ \(\)\-]{7,20}" minlength="7" maxlength="20" required placeholder="0912 123 4567" title="شماره تماس را با ۷ تا ۱۵ رقم فارسی یا انگلیسی وارد کنید" aria-describedby="phone-help"></label>
            </div>
            <small id="phone-help" class="form-note">شماره تماس: ۷ تا ۱۵ رقم فارسی یا انگلیسی؛ فاصله و پرانتز مجاز است.</small>
            <label for="consultation-building"><span class="field-label">نام ساختمان <small>اختیاری</small></span><input id="consultation-building" name="building" maxlength="100" placeholder="نام ساختمان یا مجتمع"></label>
            <label for="consultation-message"><span class="field-label">پیام شما <small>اختیاری</small></span><textarea id="consultation-message" name="message" rows="2" maxlength="2000" placeholder="درباره نیاز ساختمان خود بنویسید"></textarea></label>
            <button class="button button-primary consultation-submit" type="submit"><span data-submit-label>{{ $showConsultationDemoNote ? 'نمایش ارسال درخواست' : 'ارسال درخواست' }}</span><span class="consultation-send-icon"><x-icon name="arrow" size="18" /></span><span class="consultation-spinner" aria-hidden="true"></span></button>
        </form>
        <div class="consultation-complete" data-consultation-complete role="status" tabindex="-1" hidden>
            <div class="consultation-success-art" aria-hidden="true">
                <span class="consultation-success-halo"></span>
                <span class="consultation-success-ring"></span>
                <svg viewBox="0 0 80 80" class="consultation-success-check"><circle cx="40" cy="40" r="35" /><path d="M24 40l11 11 22-24" /></svg>
                <span class="consultation-spark spark-one"></span><span class="consultation-spark spark-two"></span><span class="consultation-spark spark-three"></span><span class="consultation-spark spark-four"></span>
            </div>
            <h3>سپاس از شما</h3>
            @if($showConsultationDemoNote)<p>نمایش کامل شد؛ اطلاعاتی ارسال نشده است.</p>@endif
        </div>
    </div>
</dialog>
