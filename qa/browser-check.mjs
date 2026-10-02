import { chromium, firefox, webkit } from '@playwright/test';
import { readFile, writeFile, mkdir } from 'node:fs/promises';
import assert from 'node:assert/strict';

const base = process.env.QA_URL || 'http://127.0.0.1:8013';
await mkdir('qa/screenshots', { recursive: true });
const results = [];
const browsers = [['chrome', chromium, { channel: 'chrome' }], ['firefox', firefox, {}], ['webkit', webkit, {}]];
for (const [name, engine, options] of browsers) {
    const browser = await engine.launch({ ...options, headless: true });
    const context = await browser.newContext({ reducedMotion: 'reduce' });
    const page = await context.newPage();
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    page.on('console', msg => { if (msg.type() === 'error' && !msg.text().includes('404')) errors.push(msg.text()); });
    if (name === 'chrome') {
        await page.setViewportSize({ width: 1200, height: 630 });
        await page.goto(base + '/');
        await page.setContent(await readFile('qa/brand-share.html', 'utf8'));
        await page.evaluate(() => document.fonts.ready);
        await page.waitForFunction(() => [...document.images].every(image => image.complete));
        await page.screenshot({ path: 'public/images/brand-share.png' });
    }
    for (const width of [360, 390, 768, 1024, 1440]) {
        await page.setViewportSize({ width, height: 900 });
        for (const theme of ['light', 'dark']) {
            await page.addInitScript(value => localStorage.setItem('buildino-theme', value), theme);
            for (const path of ['/', '/pricing', '/features', '/about', '/contact']) {
                const response = await page.goto(base + path);
                assert.equal(response.status(), 200, name + path);
                await page.evaluate(() => document.fonts.ready);
                await page.evaluate(() => document.querySelectorAll('img[loading=lazy]').forEach(img => { img.loading = 'eager'; }));
                await page.waitForFunction(() => [...document.images].every(image => image.complete));
                await page.evaluate(() => window.scrollTo(0, 0));
                const data = await page.evaluate(() => ({
                    width: document.documentElement.clientWidth,
                    scroll: document.documentElement.scrollWidth,
                    images: [...document.images].filter(image => !image.naturalWidth).map(image => image.src),
                    headings: document.querySelectorAll('h1').length,
                    canonical: document.querySelector('[rel=canonical]').href,
                    og: document.querySelector('[property="og:url"]').content,
                    theme: document.documentElement.dataset.theme,
                    logo: document.querySelector('header .logo').pathname,
                    active: document.querySelector('header [aria-current=page]')?.pathname,
                    json: JSON.parse(document.querySelector('[type="application/ld+json"]').textContent),
                }));
                assert.ok(data.scroll <= data.width + 1, JSON.stringify({ name, path, width, theme, data }));
                assert.deepEqual(data.images, [], 'Missing images');
                assert.equal(await page.locator('body').innerText().then(text => /\?{3,}/.test(text)), false, 'Text encoding');
                assert.equal(data.headings, 1, 'One H1 per page');
                assert.equal(data.theme, theme);
                assert.equal(data.logo, '/');
                assert.equal(data.canonical, data.og);
                assert.equal(new URL(data.canonical).pathname, path);
                if (path !== '/') assert.equal(data.active, path);
                results.push({ browser: name, width, theme, path, pass: true });
                if (name === 'chrome' && [390, 1440].includes(width)) {
                    await page.screenshot({ path: 'qa/screenshots/' + (path === '/' ? 'home' : path.slice(1)) + '-' + width + '-' + theme + '.png', fullPage: true });
                }
            }
        }
    }
    // Empty/invalid form, Persian + Arabic + English digits, interrupted sending and reopening.
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(base + '/');
    let sent = 0;
    page.on('request', request => { if (request.method() === 'POST') sent++; });
    const opener = page.locator('.float-toggle');
    const modal = page.locator('[data-consultation-modal]');
    await opener.click();
    await modal.locator('[type=submit]').click();
    assert.equal(await modal.evaluate(el => el.classList.contains('is-submitting')), false);

    await page.locator('#consultation-name').fill('نام نمونه');
    for (const bad of ['abcdefg', '-------', '123', '۱۲۳۴۵۶۷۸۹۰۱۲۳۴۵۶۷']) {
        await page.locator('#consultation-phone').fill(bad);
        assert.equal(await page.locator('#consultation-phone').evaluate(el => el.checkValidity()), false, bad);
    }
    for (const good of ['09121234567', '۰۹۱۲۱۲۳۴۵۶۷', '٠٩١٢١٢٣٤٥٦٧', '+98 (912) 123-4567']) {
        await page.locator('#consultation-phone').fill(good);
        assert.equal(await page.locator('#consultation-phone').evaluate(el => el.checkValidity()), true, good);
    }
    await page.screenshot({ path: 'qa/screenshots/modal-' + name + '.png' });
    await modal.locator('[type=submit]').click();
    await page.keyboard.press('Escape');
    await page.waitForFunction(() => !document.querySelector('dialog').open);
    assert.equal(await opener.evaluate(el => el === document.activeElement), true);
    await opener.click();
    assert.equal(await page.locator('#consultation-phone').inputValue(), '');
    await page.locator('#consultation-name').fill('نمونه');
    await page.locator('#consultation-phone').fill('۰۹۱۲۱۲۳۴۵۶۷');
    await modal.locator('[type=submit]').click();
    await page.waitForFunction(() => !document.querySelector('dialog').open);
    assert.equal(sent, 0, 'Demo form must not post');
    await opener.click();
    await page.mouse.click(4, 4);
    await page.waitForFunction(() => !document.querySelector('dialog').open);
    await opener.click();
    await modal.locator('[data-consultation-close]').click();
    await page.waitForFunction(() => !document.querySelector('dialog').open);
    // Narrow keyboard viewport surrogate, with scrolling to the focused field.
    await page.setViewportSize({ width: 390, height: 420 });
    await opener.click();
    await page.locator('#consultation-message').focus();
    assert.equal(await modal.evaluate(el => el.getBoundingClientRect().height <= window.innerHeight), true);
    await page.keyboard.press('Escape');
    await page.waitForFunction(() => !document.querySelector('dialog').open);
    await page.setViewportSize({ width: 390, height: 844 });
    // Mobile menu, accordion and logo destinations.
    await page.locator('[data-menu-toggle]').click();
    assert.equal(await page.locator('[data-main-nav]').isVisible(), true);
    await page.locator('[data-main-nav] a[href$="/pricing"]').click();
    await page.waitForURL('**/pricing');
    assert.equal(await page.locator('[data-menu-toggle]').getAttribute('aria-expanded'), 'false');
    await page.locator('.comparison-mobile summary').first().click();
    assert.equal(await page.locator('.comparison-mobile details').first().getAttribute('open'), '');
    await page.locator('.faq-item summary').last().click();
    assert.equal(await page.locator('.faq-item').last().getAttribute('open'), '');
    await page.locator('header .logo').click();
    await page.waitForURL(base + '/');
    const hero = page.locator('.hero-shell');
    const before = await hero.boundingBox();
    assert.equal(await hero.locator('[data-autoplay-toggle]').getAttribute('aria-pressed'), 'true');
    await hero.locator('[data-slide-next]').click();
    const after = await hero.boundingBox();
    assert.equal(Math.round(before.height), Math.round(after.height), 'Stable hero height');
    assert.equal(await hero.locator('[data-slide-dot][aria-current=true]').count(), 1);
    await hero.locator('[data-autoplay-toggle]').click();
    assert.equal(await hero.locator('[data-autoplay-toggle]').getAttribute('aria-pressed'), 'false');
    await hero.locator('[data-autoplay-toggle]').click();
    // Vertical gestures must leave the active slide unchanged; horizontal gestures change it.
    const project = page.locator('.project-carousel');
    await project.scrollIntoViewIfNeeded();
    const current = await project.locator('[data-slide].is-active').getAttribute('aria-label');
    await project.evaluate(el => {
        const start = new Event('touchstart'); start.touches = [{clientX:150,clientY:100}];
        const end = new Event('touchend'); end.changedTouches = [{clientX:220,clientY:350}];
        el.dispatchEvent(start); el.dispatchEvent(end);
    });
    assert.equal(await project.locator('[data-slide].is-active').getAttribute('aria-label'), current);
    await project.evaluate(el => {
        const start = new Event('touchstart'); start.touches = [{clientX:150,clientY:100}];
        const end = new Event('touchend'); end.changedTouches = [{clientX:250,clientY:110}];
        el.dispatchEvent(start); el.dispatchEvent(end);
    });
    assert.notEqual(await project.locator('[data-slide].is-active').getAttribute('aria-label'), current);
    const missing = await page.goto(base + '/missing-page-for-qa');
    assert.equal(missing.status(), 404);
    assert.equal(await page.locator('meta[name=robots]').getAttribute('content'), 'noindex,follow');
    assert.deepEqual(errors, [], name + ' console');
    results.push({ browser: name, interactions: true, pass: true });
    await browser.close();
    console.log(name + ': matrix and interactions passed');
}
await writeFile('qa/browser-results.json', JSON.stringify(results, null, 2));
console.log(results.length + ' checks passed');
