<header class="site-header" data-site-header>
        <div class="container nav-shell">
            <x-logo />
            <nav id="primary-navigation" class="main-nav" aria-label="ناوبری اصلی" data-main-nav>
                @foreach (['features' => 'امکانات', 'pricing' => 'تعرفه‌ها', 'about' => 'درباره ما', 'contact' => 'تماس'] as $name => $label)
                    <a href="{{ route($name) }}" @class(['active' => request()->routeIs($name)]) @if(request()->routeIs($name)) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="nav-actions">
                <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="تغییر حالت نمایش">
                    <span class="theme-icons"><x-icon name="moon" /><x-icon name="sun" /></span>
                </button>
                <button type="button" data-consultation-open aria-haspopup="dialog" class="button button-small button-primary nav-cta">درخواست مشاوره</button>
                <button class="icon-button menu-toggle" type="button" data-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="باز کردن فهرست">
                    <span class="menu-icon-open"><x-icon name="menu" /></span>
                    <span class="menu-icon-close" hidden><x-icon name="close" /></span>
                </button>
            </div>
        </div>
    </header>
