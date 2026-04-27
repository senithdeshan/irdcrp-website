import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

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
