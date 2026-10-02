<dialog class="consultation-modal" data-consultation-modal aria-labelledby="consultation-title" aria-describedby="consultation-description">
    <div class="consultation-content">
        <button class="consultation-close" type="button" data-consultation-close aria-label="بستن فرم">×</button>
        <div class="consultation-intro"><span class="consultation-badge"><x-icon name="building" size="24" /></span>
        <span class="eyebrow">مشاوره بیلدینو</span>
        <h2 id="consultation-title">از ساختمان شما شروع کنیم</h2>
        <p id="consultation-description">نام و شماره تماس خود را وارد کنید.</p></div>
        <form method="dialog" data-consultation-form>
            <div class="consultation-fields">
                <label for="consultation-name">نام و نام خانوادگی<input id="consultation-name" name="name" autocomplete="name" maxlength="100" required autofocus placeholder="نام شما"></label>
                <label for="consultation-phone">شماره تماس<input id="consultation-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" dir="ltr" pattern="[+0-9۰-۹٠-٩ ()\-]{7,20}" minlength="7" maxlength="20" required placeholder="0912 123 4567" title="شماره تماس را با ارقام وارد کنید"></label>
            </div>
            <label for="consultation-building">نام ساختمان <span>(اختیاری)</span><input id="consultation-building" name="building" maxlength="100" placeholder="نام ساختمان یا مجتمع"></label>
            <label for="consultation-message">پیام شما <span>(اختیاری)</span><textarea id="consultation-message" name="message" rows="3" maxlength="2000" placeholder="درباره نیاز ساختمان خود بنویسید"></textarea></label>
            <button class="button button-primary consultation-submit" type="submit"><span data-submit-label>ارسال درخواست</span><span class="consultation-send-icon"><x-icon name="arrow" size="18" /></span><span class="consultation-spinner" aria-hidden="true"></span></button>
        </form>
        <div class="consultation-complete" data-consultation-complete role="status" tabindex="-1" hidden>
            <div class="consultation-success-art" aria-hidden="true">
                <span class="consultation-success-halo"></span>
                <span class="consultation-success-ring"></span>
                <svg viewBox="0 0 80 80" class="consultation-success-check"><circle cx="40" cy="40" r="35" /><path d="M24 40l11 11 22-24" /></svg>
                <span class="consultation-spark spark-one"></span><span class="consultation-spark spark-two"></span><span class="consultation-spark spark-three"></span><span class="consultation-spark spark-four"></span>
            </div>
            <h3>سپاس از شما</h3>
            <p>از همراهی شما با بیلدینو خوشحالیم.</p>
        </div>
    </div>
</dialog>
