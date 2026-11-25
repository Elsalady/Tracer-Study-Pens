import { prefersReducedMotion } from './charts/palette';

const DURATION = 600;

export function initCountUp() {
    if (prefersReducedMotion) {
        return;
    }

    document.querySelectorAll('[data-count]').forEach((element) => {
        const finalText = element.textContent.trim();
        const match = finalText.match(/(\d[\d.,]*)/);

        if (!match) {
            return;
        }

        const numericText = match[1];
        const normalized = numericText.replace(/\./g, '').replace(',', '.');
        const target = Number(normalized);

        if (!Number.isFinite(target)) {
            return;
        }

        const decimals = /,\d/.test(numericText) ? numericText.split(',')[1].length : 0;
        const prefix = finalText.slice(0, match.index);
        const suffix = finalText.slice(match.index + numericText.length);

        const format = (value) => {
            const [bulat, desimal] = value.toFixed(decimals).split('.');
            const denganTitik = bulat.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            const bagianDesimal = decimals ? `,${desimal}` : '';

            return `${prefix}${denganTitik}${bagianDesimal}${suffix}`;
        };

        element.textContent = format(0);

        const mulai = performance.now();

        const langkah = (waktu) => {
            const progres = Math.min((waktu - mulai) / DURATION, 1);
            const ease = 1 - (1 - progres) ** 3;

            element.textContent = format(target * ease);

            if (progres < 1) {
                requestAnimationFrame(langkah);
            } else {
                element.textContent = finalText;
            }
        };

        requestAnimationFrame(langkah);
    });
}
