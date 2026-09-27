const ready = (callback) => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
    } else {
        callback();
    }
};

ready(() => {
    const root = document.documentElement;
    const header = document.querySelector('[data-site-header]');
    const menu = document.querySelector('[data-main-nav]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const themeToggle = document.querySelector('[data-theme-toggle]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const closeMenu = () => {
        menu?.classList.remove('is-open');
        menuToggle?.setAttribute('aria-expanded', 'false');
        menuToggle?.setAttribute('aria-label', 'باز کردن فهرست');
        if (menuToggle) {
            menuToggle.querySelector('.menu-icon-open').hidden = false;
            menuToggle.querySelector('.menu-icon-close').hidden = true;
        }
    };

    menuToggle?.addEventListener('click', () => {
        const open = menuToggle.getAttribute('aria-expanded') !== 'true';
        menu.classList.toggle('is-open', open);
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'بستن فهرست' : 'باز کردن فهرست');
        menuToggle.querySelector('.menu-icon-open').hidden = open;
        menuToggle.querySelector('.menu-icon-close').hidden = !open;
    });
    menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
    window.addEventListener('resize', () => { if (window.innerWidth > 850) closeMenu(); }, { passive: true });

    const updateHeader = () => header?.classList.toggle('is-scrolled', window.scrollY > 16);
    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    const syncThemeLabel = () => themeToggle?.setAttribute('aria-label', root.dataset.theme === 'dark' ? 'استفاده از حالت روشن' : 'استفاده از حالت تیره');
    syncThemeLabel();
    themeToggle?.addEventListener('click', () => {
        const theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        root.dataset.theme = theme;
        root.style.colorScheme = theme;
        try { localStorage.setItem('buildino-theme', theme); } catch { /* Optional preference. */ }
        syncThemeLabel();
    });

    document.querySelectorAll('[data-carousel]').forEach((carousel) => {
        const slides = [...carousel.querySelectorAll('[data-slide]')];
        const dots = [...carousel.querySelectorAll('[data-slide-dot]')];
        const previous = carousel.querySelector('[data-slide-prev]');
        const next = carousel.querySelector('[data-slide-next]');
        if (slides.length < 2) {
            previous?.setAttribute('hidden', '');
            next?.setAttribute('hidden', '');
            return;
        }

        let index = 0;
        const show = (target) => {
            index = (target + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => { slide.hidden = slideIndex !== index; });
            dots.forEach((dot, dotIndex) => {
                if (dotIndex === index) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        };
        previous?.addEventListener('click', () => show(index - 1));
        next?.addEventListener('click', () => show(index + 1));
        dots.forEach((dot, dotIndex) => dot.addEventListener('click', () => show(dotIndex)));

        if (carousel.dataset.autoplay === 'true' && !reduceMotion) {
            window.setInterval(() => {
                if (!document.hidden && !carousel.matches(':hover') && !carousel.contains(document.activeElement)) show(index + 1);
            }, 7000);
        }
    });

    const contactFloat = document.querySelector('[data-contact-float]');
    const contactToggle = document.querySelector('[data-contact-toggle]');
    const contactMenu = document.getElementById('quick-contact-menu');
    const closeContact = () => {
        if (contactMenu) contactMenu.hidden = true;
        contactToggle?.setAttribute('aria-expanded', 'false');
    };
    contactToggle?.addEventListener('click', () => {
        const open = contactToggle.getAttribute('aria-expanded') !== 'true';
        contactMenu.hidden = !open;
        contactToggle.setAttribute('aria-expanded', String(open));
    });
    contactFloat?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeContact));
    document.addEventListener('click', (event) => {
        if (contactFloat && !contactFloat.contains(event.target)) closeContact();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') { closeMenu(); closeContact(); }
    });
});
