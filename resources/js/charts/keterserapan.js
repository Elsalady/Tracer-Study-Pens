import { Chart } from 'chart.js';
import { chartAnimation, gridOptions, palette, tooltipOptions } from './palette';

export function renderKeterserapan({ per_prodi: perProdi = [] } = {}) {
    const el = document.getElementById('chart-keterserapan-prodi');

    if (!el) {
        return;
    }

    new Chart(el, {
        type: 'bar',
        data: {
            labels: perProdi.map((row) => row.prodi),
            datasets: [{
                label: 'Keterserapan (%)',
                data: perProdi.map((row) => row.persentase),
                backgroundColor: palette.series[0],
                borderRadius: 6,
                maxBarThickness: 42,
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
