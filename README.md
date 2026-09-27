# Buildino Website

وب‌سایت رسمی بیلدینو بر پایه Laravel 12 با رندر سمت‌سرور Blade و JavaScript سبک برای تعاملات رابط کاربری.

## الزامات اجرا

- PHP 8.2 یا بالاتر (PHP 8.3/8.4 نیز مناسب است)
- اکستنشن‌های استاندارد Laravel، از جمله `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml/dom`, `ctype`, `fileinfo`
- Composer 2.x فقط برای نصب/به‌روزرسانی Dependencyها
- Node.js برای ساخت Assetها لازم است؛ خروجی `public/build` همراه سورس در Git نگهداری می‌شود تا استقرار بدون دسترسی CLI روی هاست ممکن باشد
- دیتابیس برای وب‌سایت عمومی فعلی لازم نیست

## نصب

```bash
composer install --no-dev --optimize-autoloader
cp .env.production.example .env
php artisan key:generate
php artisan optimize
```

در `.env` مقدار `APP_URL` را دقیقاً برابر دامنه نهایی HTTPS تنظیم کنید. برای نسخه فعلی از `SESSION_DRIVER=file`، `CACHE_STORE=file` و `QUEUE_CONNECTION=sync` استفاده شده تا اجرای سایت به MySQL وابسته نباشد.

اگر روی هاست به CLI دسترسی ندارید، Composer را روی محیط سازگار اجرا کنید و پوشه کامل `vendor` را کنار `public` روی هاست قرار دهید. فایل `.env` واقعی را با `APP_KEY` یکتا آماده و روی هاست بارگذاری کنید. خروجی `public/build` در Git نگهداری می‌شود و باید همراه سورس منتقل شود. اگر پیش‌تر `bootstrap/cache/config.php` روی هاست ساخته شده است، پس از تغییر `.env` آن فایل cache را از طریق File Manager حذف کنید تا تنظیمات تازه خوانده شوند.

## وب‌سرور

بهترین حالت این است که Document Root دامنه مستقیماً روی پوشه `public/` تنظیم شود. اگر در هاست اشتراکی این امکان وجود ندارد، فایل `.htaccess` ریشه پروژه درخواست‌ها را به `public/` هدایت می‌کند.

PHP سرور باید حداقل نسخه 8.2 باشد. Laravel 12 روی PHP 8.1 اجرا نمی‌شود.

## SEO و Crawling

مسیرهای زیر از Laravel تولید می‌شوند:

- `/robots.txt`
- `/sitemap.xml`
- `/llms.txt`

متادیتا و Structured Data در `resources/views/home.blade.php` و تنظیمات برند/SEO در `config/buildino.php` نگهداری می‌شوند. محتوای اصلی به‌صورت Server-Side Rendered در HTML وجود دارد و برای نمایش اولیه آن به JavaScript وابسته نیست.

## Frontend

Source of Truth فایل‌های زیر است:

- `resources/css/app.css`
- `resources/js/app.js`
- `resources/views/home.blade.php`
- `config/home.php` برای محتوای صفحه اصلی

برای توسعه Assetها:

```bash
npm ci
npm run build
```

پس از تغییر CSS یا JavaScript، خروجی `public/build` را هم همراه تغییرات commit کنید. سرور برای نمایش سایت به Node.js یا اجرای build نیاز ندارد؛ فایل `public/build/manifest.json` و پوشه `public/build/assets` باید در انتشار وجود داشته باشند.

## محتوای نمایشی و فرم تماس

پروژه‌ها، آمار، مقالات و اطلاعات تماس فعلی در `config/home.php` نمونهٔ طراحی‌اند و در خود صفحه نیز مشخص شده‌اند. پیش از انتشار اطلاعات واقعی، این داده‌ها را با موارد تأییدشده جایگزین کنید. فرم تماس زمانی فعال می‌شود که `BUILDINO_CONTACT_EMAIL` و یک سرویس ارسال ایمیل واقعی به‌جای `MAIL_MAILER=log` تنظیم شده باشند. مسیر فرم دارای اعتبارسنجی، محافظت CSRF و محدودیت تعداد درخواست است. گزینه‌های واتساپ، چت‌بات و چت اپراتور تا زمان اتصال سرویس واقعی به‌عنوان «به‌زودی» نمایش داده می‌شوند.

صفحه `/pricing` جزئیات مدل تعرفه را نشان می‌دهد. کارت‌های امکانات فعلاً به خلاصه خدمات صفحه اصلی متصل‌اند و پس از آماده‌شدن صفحات جزئیات می‌توان مقصد هر کارت را در `config/home.php` تغییر داد.

## تست

```bash
php artisan test
```

برای اجرای PHPUnit/Pest، اکستنشن PHP DOM/XML باید نصب باشد.
