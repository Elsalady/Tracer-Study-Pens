import { Chart } from 'chart.js';
import { chartAnimation, gridOptions, palette, tooltipOptions } from './palette';

export function renderRelevansi({ distribusi = [], per_prodi: perProdi = [] } = {}) {
    const distribusiEl = document.getElementById('chart-distribusi-relevansi');

    if (distribusiEl) {
        new Chart(distribusiEl, {
            type: 'bar',
            data: {
                labels: distribusi.map((row) => `Skor ${row.skor}`),
                datasets: [{
                    label: 'Jumlah responden',
                    data: distribusi.map((row) => row.jumlah),
                    backgroundColor: palette.series[1],
                    borderRadius: 6,
                    maxBarThickness: 48,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: chartAnimation(90),
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipOptions,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: gridOptions.tickColor },
                        grid: { color: gridOptions.color },
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: gridOptions.tickColor },
                    },
                },
            },
        });
    }

    const prodiEl = document.getElementById('chart-rata-relevansi-prodi');

    if (prodiEl) {
        new Chart(prodiEl, {
            type: 'bar',
            data: {
                labels: perProdi.map((row) => row.prodi),
                datasets: [{
                    label: 'Rata-rata relevansi',
                    data: perProdi.map((row) => row.rata_rata),
                    backgroundColor: palette.series[2],
                    borderRadius: 6,
                    maxBarThickness: 22,
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: chartAnimation(180),
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipOptions,
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 5,
                        grid: { color: gridOptions.color },
                        ticks: { color: gridOptions.tickColor },
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: gridOptions.tickColor },
                    },
                },
            },
        });
    }
}
