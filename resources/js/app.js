import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* ─────────────────────────────────────────────────────────────────────────────
 *  Polish: scroll-reveal + counter-up
 *  Pure vanilla, no external library. Respects prefers-reduced-motion.
 * ───────────────────────────────────────────────────────────────────────────── */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/** Format a number like 15000 → "15,000". */
function formatNumber(n) {
    return n.toLocaleString('en-US');
}

/** Animate textContent from 0 to data-counter (easeOutCubic). */
function animateCounter(el) {
    const target   = parseFloat(el.dataset.counter);
    const decimals = parseInt(el.dataset.counterDecimals || '0', 10);
    const prefix   = el.dataset.counterPrefix || '';
    const suffix   = el.dataset.counterSuffix || '';
    const duration = 1600;

    if (reduceMotion || !Number.isFinite(target)) {
        el.textContent = `${prefix}${formatNumber(target)}${suffix}`;
        return;
    }

    const start = performance.now();
    function tick(now) {
        const t = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - t, 3);
        const v = target * eased;
        const text = decimals > 0 ? v.toFixed(decimals) : formatNumber(Math.round(v));
        el.textContent = `${prefix}${text}${suffix}`;
        if (t < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

document.addEventListener('DOMContentLoaded', () => {
    // 1. Reveal — fade + rise elements as they enter the viewport, once only.
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    document.querySelectorAll('.reveal, .reveal-image').forEach(el => revealObserver.observe(el));

    // 2. Counter — animate stat numbers when they appear.
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));

    // 3. Scroll-driven polish: progress bar + hero image parallax.
    //    Single rAF-throttled scroll handler; no-ops under reduced motion.
    if (!reduceMotion) {
        const progressEl = document.querySelector('[data-scroll-progress]');
        const heroEl     = document.querySelector('[data-hero-parallax]');
        let ticking = false;

        const update = () => {
            const scrollY  = window.scrollY || window.pageYOffset;
            const docH     = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docH > 0 ? Math.min(scrollY / docH, 1) : 0;

            if (progressEl) {
                progressEl.style.setProperty('--scroll-progress', progress.toFixed(4));
            }
            if (heroEl) {
                // Translate the hero image down a touch as the user scrolls into the page.
                // Capped at +60px so it never wanders far. Disabled below 640 viewport (mobile).
                const translate = window.innerWidth >= 640
                    ? Math.min(scrollY * 0.12, 60)
                    : 0;
                heroEl.style.setProperty('--hero-parallax', translate.toFixed(2));
            }
            ticking = false;
        };

        const onScroll = () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        };

        update();
        window.addEventListener('scroll',  onScroll, { passive: true });
        window.addEventListener('resize',  onScroll, { passive: true });
    }
});
