const root = document.documentElement;
root.classList.add('js-reveal');

const onReady = (callback) => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
        return;
    }

    callback();
};

onReady(() => {
    const header = document.querySelector('[data-site-header]');
    const navigation = document.querySelector('[data-main-nav]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const themeToggle = document.querySelector('[data-theme-toggle]');
    const menuOpenIcon = menuToggle?.querySelector('.menu-icon-open');
    const menuCloseIcon = menuToggle?.querySelector('.menu-icon-close');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const setMenuOpen = (open) => {
        if (!navigation || !menuToggle) return;

        navigation.classList.toggle('is-open', open);
        document.body.classList.toggle('menu-open', open);
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'بستن فهرست' : 'باز کردن فهرست');

        if (menuOpenIcon) menuOpenIcon.hidden = open;
        if (menuCloseIcon) menuCloseIcon.hidden = !open;
    };

    const updateHeader = () => header?.classList.toggle('is-scrolled', window.scrollY > 24);
    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    menuToggle?.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    navigation?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setMenuOpen(false);
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) setMenuOpen(false);
    }, { passive: true });

    const sectionIds = ['overview', 'capabilities', 'services', 'showcase', 'how', 'faq'];
    if ('IntersectionObserver' in window) {
        const navigationObserver = new IntersectionObserver((entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;

                navigation?.querySelectorAll('a').forEach((link) => {
                    const active = link.getAttribute('href') === `#${entry.target.id}`;
                    link.classList.toggle('active', active);
                    if (active) link.setAttribute('aria-current', 'location');
                    else link.removeAttribute('aria-current');
                });
            }
        }, { rootMargin: '-25% 0px -65%' });

        sectionIds.forEach((id) => {
            const section = document.getElementById(id);
            if (section) navigationObserver.observe(section);
        });
    }

    const revealElements = document.querySelectorAll('.reveal');
    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealElements.forEach((element) => element.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        }, { threshold: 0.12 });

        revealElements.forEach((element) => revealObserver.observe(element));
    }

    const syncThemeButton = () => {
        if (!themeToggle) return;
        themeToggle.setAttribute(
            'aria-label',
            root.dataset.theme === 'dark' ? 'استفاده از حالت روشن' : 'استفاده از حالت تیره',
        );
    };
    syncThemeButton();

    themeToggle?.addEventListener('click', (event) => {
        const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        const applyTheme = () => {
            root.dataset.theme = nextTheme;
            root.style.colorScheme = nextTheme;

            try {
                localStorage.setItem('buildino-theme', nextTheme);
            } catch {
                // Theme persistence is optional when browser storage is unavailable.
            }

            syncThemeButton();
        };

        if (!document.startViewTransition || reduceMotion) {
            applyTheme();
            return;
        }

        const bounds = event.currentTarget.getBoundingClientRect();
        const originX = bounds.left + bounds.width / 2;
        const originY = bounds.top + bounds.height / 2;
        const farthestX = Math.max(originX, window.innerWidth - originX);
        const farthestY = Math.max(originY, window.innerHeight - originY);
        const radius = Math.ceil(Math.hypot(farthestX, farthestY) * 1.04);

        root.style.setProperty('--theme-origin-x', `${originX}px`);
        root.style.setProperty('--theme-origin-y', `${originY}px`);
        root.style.setProperty('--theme-wipe-radius', `${radius}px`);
        root.classList.add('theme-transitioning');

        const cleanup = () => {
            root.classList.remove('theme-transitioning');
            root.style.removeProperty('--theme-origin-x');
            root.style.removeProperty('--theme-origin-y');
            root.style.removeProperty('--theme-wipe-radius');
        };

        const transition = document.startViewTransition(applyTheme);
        transition.finished.finally(cleanup);
        window.setTimeout(cleanup, 900);
    });

    const liquidCursor = document.querySelector('.liquid-cursor');
    if (!liquidCursor || reduceMotion || !window.matchMedia('(pointer: fine)').matches) return;

    let targetX = -80;
    let targetY = -80;
    let currentX = targetX;
    let currentY = targetY;
    let frame = 0;

    const renderCursor = () => {
        currentX += (targetX - currentX) * 0.24;
        currentY += (targetY - currentY) * 0.24;
        liquidCursor.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
        frame = window.requestAnimationFrame(renderCursor);
    };

    document.documentElement.classList.add('has-liquid-cursor');

    window.addEventListener('pointermove', (event) => {
        targetX = event.clientX;
        targetY = event.clientY;
        liquidCursor.classList.add('is-visible');
    }, { passive: true });

    document.addEventListener('pointerover', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        liquidCursor.classList.toggle(
            'is-active',
            Boolean(target?.closest('a, button, summary, input, select, textarea, [role="button"]')),
        );
    }, { passive: true });

    document.documentElement.addEventListener('mouseleave', () => {
        liquidCursor.classList.remove('is-visible');
    });

    frame = window.requestAnimationFrame(renderCursor);
    window.addEventListener('pagehide', () => window.cancelAnimationFrame(frame), { once: true });
});
