# Buildino Website

وب‌سایت رسمی بیلدینو بر پایه Laravel 12 با رندر سمت‌سرور Blade و JavaScript سبک برای تعاملات رابط کاربری.

## الزامات اجرا

- PHP 8.2 یا بالاتر (PHP 8.3/8.4 نیز مناسب است)
- اکستنشن‌های استاندارد Laravel، از جمله `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml/dom`, `ctype`, `fileinfo`
- Composer 2.x فقط برای نصب/به‌روزرسانی Dependencyها
- Node.js فقط در صورت نیاز به Build مجدد Assetها؛ نسخه Deploy شامل `public/build` آماده است
- دیتابیس برای وب‌سایت عمومی فعلی لازم نیست

## نصب

```bash
composer install --no-dev --optimize-autoloader
cp .env.production.example .env
php artisan key:generate
php artisan optimize
```

در `.env` مقدار `APP_URL` را دقیقاً برابر دامنه نهایی HTTPS تنظیم کنید. برای نسخه فعلی از `SESSION_DRIVER=file`، `CACHE_STORE=file` و `QUEUE_CONNECTION=sync` استفاده شده تا اجرای سایت به MySQL وابسته نباشد.

## وب‌سرور

بهترین حالت این است که Document Root دامنه مستقیماً روی پوشه `public/` تنظیم شود. اگر در هاست اشتراکی این امکان وجود ندارد، فایل `.htaccess` ریشه پروژه درخواست‌ها را به `public/` هدایت می‌کند.

PHP سرور باید حداقل نسخه 8.2 باشد. Laravel 12 روی PHP 8.1 اجرا نمی‌شود.

## SEO و Crawling

مسیرهای زیر از Laravel تولید می‌شوند:

- `/robots.txt`
- `/sitemap.xml`
- `/llms.txt`

متادیتا و Structured Data در `resources/views/app.blade.php` و تنظیمات برند/SEO در `config/buildino.php` نگهداری می‌شوند. محتوای اصلی به‌صورت Server-Side Rendered در HTML وجود دارد و برای نمایش آن به JavaScript وابسته نیست.

## Frontend

Source of Truth فایل‌های زیر است:

- `resources/css/app.css`
- `resources/js/app.js`
- `resources/views/app.blade.php`

برای توسعه Assetها:

```bash
npm ci
npm run build
```

فایل‌های `public/build` در بسته نهایی از قبل آماده شده‌اند.

## تست

```bash
php artisan test
```

برای اجرای PHPUnit/Pest، اکستنشن PHP DOM/XML باید نصب باشد.
