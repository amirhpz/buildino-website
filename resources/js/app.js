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
        const stackedSlides = carousel.classList.contains('hero-shell');
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
            slides.forEach((slide, slideIndex) => {
                const active = slideIndex === index;
                if (stackedSlides) {
                    slide.classList.toggle('is-active', active);
                    slide.toggleAttribute('inert', !active);
                    if (active) slide.removeAttribute('aria-hidden');
                    else slide.setAttribute('aria-hidden', 'true');
                } else {
                    slide.hidden = !active;
                }
            });
            dots.forEach((dot, dotIndex) => {
                if (dotIndex === index) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        };
        previous?.addEventListener('click', () => show(index - 1));
        next?.addEventListener('click', () => show(index + 1));
        dots.forEach((dot, dotIndex) => dot.addEventListener('click', () => show(dotIndex)));
        if (carousel.classList.contains('project-carousel')) {
            carousel.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                    event.preventDefault();
                    show(index + (event.key === 'ArrowLeft' ? 1 : -1));
                }
            });
            let touchStartX = null;
            carousel.addEventListener('touchstart', (event) => {
                touchStartX = event.touches.length === 1 ? event.touches[0].clientX : null;
            }, { passive: true });
            carousel.addEventListener('touchend', (event) => {
                if (touchStartX === null) return;
                const distance = event.changedTouches[0].clientX - touchStartX;
                if (Math.abs(distance) > 50) show(index + (distance > 0 ? 1 : -1));
                touchStartX = null;
            }, { passive: true });
        }


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

    const consultationModal = document.querySelector('[data-consultation-modal]');
    const consultationForm = consultationModal?.querySelector('[data-consultation-form]');
    const consultationComplete = consultationModal?.querySelector('[data-consultation-complete]');
    const consultationSubmit = consultationForm?.querySelector('[type="submit"]');
    const consultationLabel = consultationForm?.querySelector('[data-submit-label]');
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
            scheduleConsultation(closeConsultation, reduceMotion ? 900 : 1500);
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
        consultationLabel.textContent = 'ارسال درخواست';
        consultationComplete.hidden = true;
    });

});
