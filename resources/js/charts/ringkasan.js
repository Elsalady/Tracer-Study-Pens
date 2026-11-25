import { Chart } from 'chart.js';
import {
    chartAnimation,
    donutAnimation,
    gridOptions,
    legendOptions,
    palette,
    prefersReducedMotion,
    tooltipOptions,
} from './palette';

const LABEL_STATUS = {
    BEKERJA: 'Bekerja',
    KULIAH_LANJUT: 'Kuliah Lanjut',
    WIRAUSAHA: 'Wirausaha',
    BELUM_BEKERJA: 'Belum Bekerja',
};

const centerText = {
    id: 'centerText',
    afterDraw(chart) {
        const values = chart.data.datasets[0]?.data ?? [];
        const total = values.reduce((jumlah, nilai) => jumlah + nilai, 0);

        if (!total) {
            return;
        }

        const { ctx, chartArea } = chart;
        const x = (chartArea.left + chartArea.right) / 2;
        const y = (chartArea.top + chartArea.bottom) / 2;

        ctx.save();
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = palette.ink;
        ctx.font = '600 18px "Instrument Sans", sans-serif';
        ctx.fillText(String(total), x, y - 8);
        ctx.fillStyle = palette.muted;
        ctx.font = '500 11px "Instrument Sans", sans-serif';
        ctx.fillText('responden', x, y + 12);
        ctx.restore();
    },
};

export function renderRingkasan({ tren = [], komposisi = [] } = {}) {
    const trenEl = document.getElementById('chart-tren-keterserapan');

    if (trenEl) {
        new Chart(trenEl, {
            type: 'line',
            data: {
                labels: tren.map((row) => row.tahun_lulus),
                datasets: [{
                    label: 'Keterserapan (%)',
                    data: tren.map((row) => row.persentase),
                    borderColor: palette.primary,
                    backgroundColor: palette.primarySoft,
                    pointBackgroundColor: palette.primary,
                    pointBorderColor: palette.card,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: chartAnimation(),
                animations: { x: { duration: prefersReducedMotion ? 0 : 600 } },
                plugins: { tooltip: tooltipOptions },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: gridOptions.color },
                        ticks: { color: gridOptions.tickColor },
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: gridOptions.tickColor },
                    },
                },
            },
        });
    }

    const komposisiEl = document.getElementById('chart-komposisi-status');

    if (komposisiEl) {
        new Chart(komposisiEl, {
            type: 'doughnut',
            data: {
                labels: komposisi.map((row) => LABEL_STATUS[row.status] ?? row.status),
                datasets: [{
                    data: komposisi.map((row) => row.jumlah),
                    backgroundColor: komposisi.map((row) => palette.status[row.status] ?? palette.muted),
                    borderColor: palette.card,
                    borderWidth: 2,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: donutAnimation(90),
                plugins: {
                    legend: legendOptions,
                    tooltip: tooltipOptions,
                },
            },
            plugins: [centerText],
        });
    }
}
