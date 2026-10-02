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
    const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
    const reduceMotion = motionPreference.matches;

    const closeMenu = () => {
        menu?.classList.remove('is-open');
        document.body.classList.remove('menu-open');
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
        document.body.classList.toggle('menu-open', open);
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
    let themeTransitionRunning = false;
    themeToggle?.addEventListener('click', (event) => {
        if (themeTransitionRunning) return;
        const theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        const applyTheme = () => {
            root.dataset.theme = theme;
            root.style.colorScheme = theme;
            try { localStorage.setItem('buildino-theme', theme); } catch { /* Optional preference. */ }
            syncThemeLabel();
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
        themeTransitionRunning = true;

        const cleanup = () => {
            root.classList.remove('theme-transitioning');
            root.style.removeProperty('--theme-origin-x');
            root.style.removeProperty('--theme-origin-y');
            root.style.removeProperty('--theme-wipe-radius');
            themeTransitionRunning = false;
        };

        const transition = document.startViewTransition(applyTheme);
        transition.finished.then(cleanup, cleanup);
        window.setTimeout(cleanup, 900);
    });


    document.querySelectorAll('[data-carousel]').forEach((carousel) => {
        const slides = [...carousel.querySelectorAll('[data-slide]')];
        const dots = [...carousel.querySelectorAll('[data-slide-dot]')];
        const toggle = carousel.querySelector('[data-autoplay-toggle]');
        if (slides.length < 2) {
            carousel.querySelectorAll('[data-slide-prev], [data-slide-next], [data-autoplay-toggle]').forEach((button) => { button.hidden = true; });
            return;
        }
        let index = 0;
        let paused = motionPreference.matches;
        let timer;
        let inView = true;
        let touchStart = null;
        let hovering = false;
        let focusWithin = false;
        const liveRegion = carousel.querySelector('[aria-live]');
        const show = (target) => {
            index = (target + slides.length) % slides.length;
            slides.forEach((slide, position) => {
                const active = position === index;
                slide.hidden = false;
                slide.classList.toggle('is-active', active);
                slide.inert = !active;
                slide.setAttribute('aria-hidden', String(!active));
            });
            dots.forEach((dot, position) => {
                if (position === index) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        };
        const sync = () => {
            window.clearInterval(timer);
            const playing = !paused && inView && !document.hidden && !hovering && !focusWithin;
            if (toggle) {
                toggle.textContent = paused ? 'ادامه' : 'توقف';
                toggle.setAttribute('aria-pressed', String(paused));
                toggle.setAttribute('aria-label', paused ? 'ادامه پخش خودکار' : 'توقف پخش خودکار');
            }
            liveRegion?.setAttribute('aria-live', playing ? 'off' : 'polite');
            if (playing && carousel.dataset.autoplay === 'true') timer = window.setInterval(() => show(index + 1), 7000);
        };
        const manual = (target) => { paused = true; show(target); sync(); };
        carousel.querySelector('[data-slide-prev]')?.addEventListener('click', () => manual(index - 1));
        carousel.querySelector('[data-slide-next]')?.addEventListener('click', () => manual(index + 1));
        dots.forEach((dot, position) => dot.addEventListener('click', () => manual(position)));
        toggle?.addEventListener('click', () => { paused = !paused; sync(); });
        carousel.addEventListener('keydown', (event) => {
            if (event.target.closest('input, textarea, select')) return;
            if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                event.preventDefault();
                manual(index + (event.key === 'ArrowLeft' ? 1 : -1));
            }
        });
        carousel.addEventListener('touchstart', (event) => {
            touchStart = event.touches.length === 1 ? { x: event.touches[0].clientX, y: event.touches[0].clientY } : null;
        }, { passive: true });
        carousel.addEventListener('touchmove', (event) => {
            if (event.touches.length !== 1) touchStart = null;
        }, { passive: true });
        carousel.addEventListener('touchend', (event) => {
            if (!touchStart || !event.changedTouches.length) return;
            const dx = event.changedTouches[0].clientX - touchStart.x;
            const dy = event.changedTouches[0].clientY - touchStart.y;
            if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) manual(index + (dx > 0 ? 1 : -1));
            touchStart = null;
        }, { passive: true });
        carousel.addEventListener('touchcancel', () => { touchStart = null; }, { passive: true });
        carousel.addEventListener('pointerenter', (event) => { if (event.pointerType === 'mouse') { hovering = true; sync(); } });
        carousel.addEventListener('pointerleave', () => { hovering = false; sync(); });
        carousel.addEventListener('focusin', () => { focusWithin = true; sync(); });
        carousel.addEventListener('focusout', (event) => { focusWithin = carousel.contains(event.relatedTarget); sync(); });
        document.addEventListener('visibilitychange', sync);
        motionPreference.addEventListener('change', (event) => { if (event.matches) paused = true; sync(); });
        window.addEventListener('pagehide', () => window.clearInterval(timer));
        window.addEventListener('pageshow', sync);
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(([entry]) => { inView = entry.isIntersecting; sync(); }, { threshold: 0.1 }).observe(carousel);
        }
        show(0);
        sync();
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

    const consultationModal = document.querySelector('[data-consultation-modal]');
    const consultationForm = consultationModal?.querySelector('[data-consultation-form]');
    const consultationComplete = consultationModal?.querySelector('[data-consultation-complete]');
    const consultationSubmit = consultationForm?.querySelector('[type="submit"]');
    const consultationLabel = consultationForm?.querySelector('[data-submit-label]');
    const consultationPhone = consultationForm?.querySelector('[name="phone"]');
    let consultationTrigger = null;
    const validatePhone = () => {
        if (!consultationPhone) return;
        const normalized = consultationPhone.value.replace(/[۰-۹]/g, (digit) => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(digit))).replace(/[٠-٩]/g, (digit) => String('٠١٢٣٤٥٦٧٨٩'.indexOf(digit))).replace(/[()\s-]/g, '');
        consultationPhone.setCustomValidity(consultationPhone.value && !/^\+?[0-9]{7,15}$/.test(normalized) ? 'شماره تماس را با ۷ تا ۱۵ رقم فارسی یا انگلیسی وارد کنید.' : '');
    };
    consultationPhone?.addEventListener('input', validatePhone);
    let consultationTimers = [];
    const clearConsultationTimers = () => {
        consultationTimers.forEach(window.clearTimeout);
        consultationTimers = [];
    };
    const scheduleConsultation = (callback, delay) => {
        consultationTimers.push(window.setTimeout(callback, delay));
    };
    const closeConsultation = () => {
        if (!consultationModal?.open || consultationModal.classList.contains('is-closing')) return;
        clearConsultationTimers();
        consultationModal.classList.add('is-closing');
        scheduleConsultation(() => consultationModal.close(), reduceMotion ? 0 : 280);
    };
    document.querySelectorAll('[data-consultation-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            if (!consultationModal || consultationModal.open) return;
            closeMenu();
            closeContact();
            consultationTrigger = trigger;
            consultationModal.showModal();
            document.body.classList.add('consultation-open');
        });
    });
    consultationModal?.querySelector('[data-consultation-close]')?.addEventListener('click', closeConsultation);
    consultationModal?.addEventListener('cancel', (event) => {
        event.preventDefault();
        closeConsultation();
    });
    consultationModal?.addEventListener('click', (event) => {
        const bounds = consultationModal.getBoundingClientRect();
        if (event.target === consultationModal && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) closeConsultation();
    });
    consultationForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        if (consultationModal.classList.contains('is-submitting') || consultationModal.classList.contains('is-complete') || consultationModal.classList.contains('is-closing')) return;
        validatePhone();
        if (!consultationForm.reportValidity()) return;
        consultationModal.classList.add('is-submitting');
        consultationForm.setAttribute('aria-busy', 'true');
        consultationSubmit.disabled = true;
        consultationLabel.textContent = 'یک لحظه…';
        // Presentation only; this form does not send or persist information.
        scheduleConsultation(() => {
            consultationModal.classList.remove('is-submitting');
            consultationModal.classList.add('is-complete');
            consultationForm.removeAttribute('aria-busy');
            consultationComplete.hidden = false;
            consultationComplete.focus({ preventScroll: true });
            consultationForm.inert = true;
            scheduleConsultation(closeConsultation, reduceMotion ? 900 : 1000);
        }, reduceMotion ? 0 : 650);
    });
    consultationModal?.addEventListener('close', () => {
        clearConsultationTimers();
        document.body.classList.remove('consultation-open');
        consultationModal.classList.remove('is-submitting', 'is-complete', 'is-closing');
        consultationForm.removeAttribute('aria-busy');
        consultationForm.inert = false;
        consultationForm.reset();
        consultationSubmit.disabled = false;
        consultationLabel.textContent = 'نمایش ارسال درخواست';
        consultationComplete.hidden = true;
        consultationPhone?.setCustomValidity('');
        consultationTrigger?.focus({ preventScroll: true });
    });

    const syncDialogViewport = () => {
        if (!window.visualViewport) return;
        consultationModal?.style.setProperty('--dialog-available-height', Math.max(160, window.visualViewport.height - 24) + 'px');
        if (consultationModal?.open && consultationModal.contains(document.activeElement)) document.activeElement.scrollIntoView({ block: 'nearest' });
    };
    window.visualViewport?.addEventListener('resize', syncDialogViewport);
    syncDialogViewport();

});
