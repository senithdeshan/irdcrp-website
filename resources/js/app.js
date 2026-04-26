import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* Fade in sections on scroll (home page) */
document.addEventListener('DOMContentLoaded', () => {
    const nodes = document.querySelectorAll('.irdc-reveal-on-scroll');
    if (nodes.length === 0) {
        return;
    }
    if (!('IntersectionObserver' in window)) {
        nodes.forEach((el) => el.classList.add('irdc-reveal-on-scroll--visible'));
        return;
    }
    const obs = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('irdc-reveal-on-scroll--visible');
                    obs.unobserve(e.target);
                }
            });
        },
        { root: null, rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );
    nodes.forEach((el) => obs.observe(el));
});
