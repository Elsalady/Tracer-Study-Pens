const styles = getComputedStyle(document.documentElement);

const read = (name, fallback) => styles.getPropertyValue(name).trim() || fallback;

export const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export const palette = {
    primary: read('--color-primary', '#0b5cab'),
    primarySoft: read('--color-primary-soft', '#e8f1fb'),
    accent: read('--color-accent', '#f59e0b'),
    ink: read('--color-ink', '#0f172a'),
    muted: read('--color-muted', '#475569'),
    line: read('--color-line', '#e2e8f0'),
    card: read('--color-card', '#ffffff'),
    surface: read('--color-surface', '#f8fafc'),
    series: [
        read('--color-series-1', '#0b5cab'),
        read('--color-series-2', '#38bdf8'),
        read('--color-series-3', '#93c5fd'),
        read('--color-series-4', '#1d4ed8'),
    ],
    status: {
        BEKERJA: read('--color-status-bekerja', '#0f766e'),
        KULIAH_LANJUT: read('--color-status-kuliah', '#7c3aed'),
        WIRAUSAHA: read('--color-status-wirausaha', '#be185d'),
        BELUM_BEKERJA: read('--color-status-belum', '#334155'),
    },
};

export const chartAnimation = (delay = 0) => prefersReducedMotion
    ? false
    : { duration: 600, delay, easing: 'easeOutQuart' };

export const donutAnimation = (delay = 0) => prefersReducedMotion
    ? false
    : { duration: 600, delay, easing: 'easeOutQuart', animateRotate: true, animateScale: true };

export const legendOptions = {
    position: 'bottom',
    labels: {
        color: palette.ink,
        usePointStyle: true,
        pointStyle: 'circle',
        boxWidth: 8,
        boxHeight: 8,
        padding: 16,
        font: { size: 11 },
    },
};

export const tooltipOptions = {
    backgroundColor: palette.card,
    titleColor: palette.ink,
    bodyColor: palette.muted,
    borderColor: palette.line,
    borderWidth: 1,
    padding: 10,
    usePointStyle: true,
};

export const gridOptions = {
    color: palette.line,
    tickColor: palette.muted,
    tickFontColor: palette.muted,
};
