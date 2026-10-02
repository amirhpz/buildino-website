# Buildino Website

وب‌سایت بیلدینو با Laravel 12 و Blade، در مسیر F:/Projects/buildino-website.

## صفحات و رفتار

پنج صفحه عمومی: /، /pricing، /features، /about و /contact، به همراه ۴۰۴ اختصاصی.
قالب مشترک در resources/views/layouts/site.blade.php است؛ اجزای مشترک در partialها و components.
امکانات، پلن‌ها، مقایسه و ساختمان‌ها در config/home.php؛ برند و FAQ در config/buildino.php.

قاب‌های محصول و سه ساختمان فعلی نمونه‌ی طراحی‌اند. آمار و مقاله‌های خالی نمایش داده نمی‌شوند.
قیمت پلن‌ها با استعلام است. بازارچه، خدمات خودرو، پرداخت اعتباری و بیمه در برنامه توسعه‌اند؛ درگاه پرداخت مربوط به نسخه کامل است.

فرم مشاوره و انیمیشن ارسال نمایشی‌اند؛ هیچ اطلاعاتی ارسال یا ذخیره نمی‌شود. شماره فارسی، عربی و انگلیسی با ۷ تا ۱۵ رقم پذیرفته می‌شود.
بستن با Escape، کلیک بیرون و دکمه بستن، پاک‌شدن وضعیت و بازگشت فوکوس پشتیبانی می‌شوند. ارسال و بسته‌شدن حدود دو ثانیه است.
مسیر POST تماس از نسخه قبلی باقی است اما هیچ فرم فعلی به آن متصل نیست؛ تنظیم ایمیل نیز فرم نمایشی را فعال نمی‌کند.
اسلایدرها کنترل دستی و توقف/ادامه دارند؛ کاهش حرکت، پخش خودکار را متوقف می‌کند و حرکت عمودی لمس اسلاید را تغییر نمی‌دهد.

## توسعه

PHP 8.2+، Composer 2 و Node.js 20.19+ یا 22.12+ لازم‌اند.

~~~bash
composer install
npm ci
npm run build
php artisan view:cache
php artisan serve --port=8013
~~~

سورس و public/build را با هم ثبت کنید. manifest و assets همراه بسته انتشار هستند؛ Node روی هاست لازم نیست.

## استقرار روی هاست اشتراکی PHP

طبق [راهنمای Laravel](https://laravel.com/docs/12.x/deployment)، Document Root را روی public/ بگذارید.
سورس، vendor و .env باید خارج از ریشه عمومی باشند.
اگر تغییر Document Root ممکن نیست، محتوای public را به ریشه عمومی ببرید و مسیرهای autoload و bootstrap در index.php را به محل خصوصی پروژه تنظیم کنید.

~~~bash
composer install --no-dev --optimize-autoloader
cp .env.production.example .env
php artisan key:generate
php artisan optimize
~~~

APP_URL را دامنه HTTPS نهایی، APP_ENV=production و APP_DEBUG=false قرار دهید. OPcache را در تنظیمات PHP هاست فعال کنید؛ سنجش عملکرد تولید با OPcache انجام شده است.
SESSION_DRIVER=file، CACHE_STORE=file و QUEUE_CONNECTION=sync کافی‌اند؛ سایت عمومی به دیتابیس نیاز ندارد.
storage و bootstrap/cache باید برای PHP قابل نوشتن باشند. APP_KEY یکتا باشد و .env واقعی در Git ثبت نشود.
برای هاست بدون CLI، vendor و build را در محیط سازگار آماده و همراه سورس منتقل کنید؛ cacheهای توسعه را منتقل نکنید.
پس از تغییر .env، cache config قبلی را پاک یا دوباره روی همان هاست ایجاد کنید.

## SEO و کش

canonical، Open Graph، Twitter، sitemap و llms از APP_URL استفاده می‌کنند.
تصویر برند: public/images/brand-share.png؛ منبع طراحی آن: qa/brand-share.html.
sitemap شامل هر پنج صفحه است. داده‌های ساختاریافته WebSite/WebPage با محتوای قابل مشاهده هماهنگ‌اند.
CSS و JS دارای هش کش بلندمدت دارند؛ theme-init.js برای حذف درخواست مسدودکننده با nonce در قالب درج می‌شود؛ نسخه عمومی فایل نیز revalidation دارد.
اصلاح pattern طبق [MDN](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes/pattern) انجام شده است.

## بررسی

~~~bash
npm run build
php artisan view:cache
node --check resources/js/app.js
npx playwright install firefox webkit
node qa/browser-check.mjs
npx lighthouse http://127.0.0.1:8013/ --chrome-flags="--headless --disable-gpu" --output=json --output=html --output-path=qa/lighthouse-mobile --quiet
~~~

QA_URL برای تغییر نشانی آزمون قابل تنظیم است. آزمون از Chrome نصب‌شده، Firefox و WebKit استفاده می‌کند.
WebKit جای بررسی Safari واقعی روی دستگاه اپل را نمی‌گیرد. کیبورد واقعی موبایل باید پیش از انتشار روی دستگاه هم بررسی شود.
گزارش و تصاویر دسکتاپ و موبایل در qa/ قرار می‌گیرند.
هدف Lighthouse موبایل ≥۹۰ است. اهداف میدانی LCP ≤۲٫۵s، CLS ≤۰٫۱ و INP ≤۲۰۰ms پس از انتشار اندازه‌گیری می‌شوند.
[تعریف Web Vitals](https://web.dev/articles/vitals).

مرحله بعد: اتصال فرم، تأیید محتوای محصول و پلن‌ها، جایگزینی نمونه‌ها، سیاست حریم خصوصی و پایش درخواست‌ها.
پنل، وبلاگ، چت و CRM در این مرحله نیستند.

بسته‌ی کامل هاست با vendor تولید در qa/buildino-shared-host.zip ساخته می‌شود. env آزمایشی و cacheهای محیط محلی در بسته قرار نمی‌گیرند؛ .env را روی هاست از مثال تولید بسازید.
