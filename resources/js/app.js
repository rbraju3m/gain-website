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

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

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
});
