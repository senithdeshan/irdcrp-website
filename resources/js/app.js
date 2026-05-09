import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
document.documentElement.classList.add('js');

function irdcWmoCategory(code) {
    const c = Number(code);
    if (c === 0) return 'clear';
    if (c >= 1 && c <= 3) return 'cloudy';
    if (c === 45 || c === 48) return 'fog';
    if (c >= 51 && c <= 57) return 'drizzle';
    if ((c >= 61 && c <= 67) || (c >= 80 && c <= 82)) return 'rain';
    if (c >= 71 && c <= 77) return 'snow';
    if (c >= 95) return 'thunder';
    return 'cloudy';
}

Alpine.data('irdcWeather', (config) => ({
    areas: config.areas,
    locale: config.locale,
    defaultImage: config.defaultImage,
    condLabels: config.condLabels,
    strings: config.strings,
    selected: 0,
    loading: true,
    error: null,
    payload: null,
    init() {
        this.fetchWx();
    },
    select(i) {
        if (this.selected === i) return;
        this.selected = i;
        this.fetchWx();
    },
    get area() {
        return this.areas[this.selected];
    },
    areaImage() {
        const p = this.area?.image;
        if (p) {
            if (p.startsWith('http://') || p.startsWith('https://')) return p;
            return p.startsWith('/') ? p : `/${p}`;
        }
        const d = this.defaultImage;
        if (d.startsWith('http://') || d.startsWith('https://')) return d;
        return d.startsWith('/') ? d : `/${d}`;
    },
    districtLabel() {
        const n = this.area?.name;
        if (!n) return '';
        return n[this.locale] || n.en || '';
    },
    intlLocale() {
        if (this.locale === 'si') return 'si-LK';
        if (this.locale === 'ta') return 'ta-LK';
        return 'en-LK';
    },
    formatDay(iso) {
        if (!iso) return '';
        try {
            return new Intl.DateTimeFormat(this.intlLocale(), { weekday: 'long' }).format(new Date(`${iso}T12:00:00`));
        } catch {
            return iso;
        }
    },
    formatDayShort(iso) {
        if (!iso) return '';
        try {
            return new Intl.DateTimeFormat(this.intlLocale(), { weekday: 'short' }).format(new Date(`${iso}T12:00:00`));
        } catch {
            return iso;
        }
    },
    categoryFromWmo(code) {
        return irdcWmoCategory(code);
    },
    condLabel(code) {
        const k = irdcWmoCategory(code);
        return this.condLabels[k] || this.condLabels.cloudy;
    },
    iconKind(code) {
        const k = irdcWmoCategory(code);
        if (k === 'clear') return 'sun';
        if (k === 'rain' || k === 'drizzle' || k === 'thunder') return 'rain';
        if (k === 'snow') return 'snow';
        if (k === 'fog') return 'fog';
        return 'cloud';
    },
    async fetchWx() {
        if (!this.areas?.length || !this.area) {
            this.loading = false;
            this.error = true;
            return;
        }
        this.loading = true;
        this.error = null;
        const { lat, lon } = this.area;
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=Asia%2FColombo&forecast_days=7`;
        try {
            const r = await fetch(url);
            if (!r.ok) {
                throw new Error('forecast failed');
            }
            this.payload = await r.json();
        } catch {
            this.error = true;
            this.payload = null;
        } finally {
            this.loading = false;
        }
    },
    currentTemp() {
        const t = this.payload?.current?.temperature_2m;
        return t === undefined || t === null ? null : Math.round(t);
    },
    currentCode() {
        return this.payload?.current?.weather_code;
    },
    dailyRows() {
        const d = this.payload?.daily;
        if (!d?.time?.length) return [];
        return d.time.map((t, i) => ({
            date: t,
            code: d.weather_code[i],
            max: d.temperature_2m_max[i],
            min: d.temperature_2m_min[i],
        }));
    },
}));

Alpine.data('irdcDeadlineCountdown', (deadlineDate) => ({
    label: '',
    expired: false,
    timer: null,
    deadline: null,
    initDeadline() {
        this.deadline = new Date(`${deadlineDate}T23:59:59`);
    },
    format(ms) {
        if (ms <= 0) {
            this.expired = true;
            return 'Deadline finished - view notice';
        }
        this.expired = false;
        const totalMinutes = Math.floor(ms / 60000);
        const days = Math.floor(totalMinutes / 1440);
        const hours = Math.floor((totalMinutes % 1440) / 60);
        const minutes = totalMinutes % 60;
        const parts = [];
        if (days > 0) parts.push(`${days} day${days === 1 ? '' : 's'}`);
        if (hours > 0 || days > 0) parts.push(`${hours} hour${hours === 1 ? '' : 's'}`);
        parts.push(`${minutes} min`);
        return `${parts.join(' ')} remaining`;
    },
    tick() {
        if (!this.deadline || Number.isNaN(this.deadline.getTime())) {
            this.label = '';
            return;
        }
        this.label = this.format(this.deadline.getTime() - Date.now());
    },
    start() {
        this.initDeadline();
        this.tick();
        this.timer = window.setInterval(() => this.tick(), 60000);
    },
    destroy() {
        if (this.timer) window.clearInterval(this.timer);
    },
}));

Alpine.start();

/* Fade in sections on scroll (home page) */
document.addEventListener('DOMContentLoaded', () => {
    const setStaggerDelays = () => {
        document.querySelectorAll('[data-reveal-stagger]').forEach((parent) => {
            Array.from(parent.children).forEach((child, idx) => {
                child.style.transitionDelay = `${Math.min(idx * 90, 540)}ms`;
            });
        });
    };

    const setupTyping = () => {
        document.querySelectorAll('[data-typing]').forEach((el) => {
            const fullText = (el.textContent || '').trim();
            if (!fullText) return;
            el.dataset.typingDone = 'false';
            el.textContent = '';
            let i = 0;
            const tick = () => {
                if (i <= fullText.length) {
                    el.textContent = fullText.slice(0, i);
                    i += 1;
                    window.setTimeout(tick, 28);
                } else {
                    el.dataset.typingDone = 'true';
                }
            };
            tick();
        });
    };

    const setupCountUp = () => {
        const counters = document.querySelectorAll('[data-countup][data-target]');
        if (counters.length === 0) return;
        const animate = (el) => {
            const target = Number(el.getAttribute('data-target') || 0);
            if (!Number.isFinite(target) || target <= 0) return;
            const startAt = performance.now();
            const duration = 1200;
            const step = (now) => {
                const p = Math.min((now - startAt) / duration, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                const value = Math.round(target * eased);
                el.textContent = value.toLocaleString();
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };
        const obs = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && entry.target instanceof HTMLElement) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.35 });
        counters.forEach((counter) => obs.observe(counter));
    };

    const setupHeroParallax = () => {
        const layers = document.querySelectorAll('.irdc-hero-bg-layer');
        if (layers.length === 0) return;
        const onScroll = () => {
            const y = Math.min(window.scrollY, 500);
            const shift = y * 0.05;
            layers.forEach((layer) => {
                if (layer instanceof HTMLElement) {
                    /* No scale — scale() crops background images (especially with contain/cover) */
                    layer.style.transform = `translateY(${shift}px)`;
                }
            });
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    };

    setStaggerDelays();
    setupTyping();
    setupCountUp();
    setupHeroParallax();

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
