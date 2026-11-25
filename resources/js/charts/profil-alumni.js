import { Chart } from 'chart.js';
import { chartAnimation, gridOptions, palette, tooltipOptions } from './palette';

const horizontalOptions = (delay) => ({
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    animation: chartAnimation(delay),
    plugins: {
        legend: { display: false },
        tooltip: tooltipOptions,
    },
    scales: {
        x: {
            beginAtZero: true,
            grid: { color: gridOptions.color },
            ticks: { precision: 0, color: gridOptions.tickColor },
        },
        y: {
            grid: { display: false },
            ticks: { color: gridOptions.tickColor },
        },
    },
});

const verticalOptions = (delay) => ({
    responsive: true,
    maintainAspectRatio: false,
    animation: chartAnimation(delay),
    plugins: {
        legend: { display: false },
        tooltip: tooltipOptions,
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: gridOptions.color },
            ticks: { precision: 0, color: gridOptions.tickColor },
        },
        x: {
            grid: { display: false },
            ticks: { color: gridOptions.tickColor },
        },
    },
});

export function renderProfilAlumni({ bidang = [], skala_gaji: skalaGaji = [], kabupaten_top: kabupaten = [] } = {}) {
    const bidangEl = document.getElementById('chart-bidang-pekerjaan');

    if (bidangEl) {
        new Chart(bidangEl, {
            type: 'bar',
            data: {
                labels: bidang.map((row) => row.label),
                datasets: [{
                    label: 'Jumlah alumni',
                    data: bidang.map((row) => row.jumlah),
                    backgroundColor: palette.series[1],
                    borderRadius: 6,
                    maxBarThickness: 22,
                }],
            },
            options: horizontalOptions(90),
        });
    }

    const gajiEl = document.getElementById('chart-skala-gaji');

    if (gajiEl) {
        new Chart(gajiEl, {
            type: 'bar',
            data: {
                labels: skalaGaji.map((row) => row.label),
                datasets: [{
                    label: 'Jumlah alumni',
                    data: skalaGaji.map((row) => row.jumlah),
                    backgroundColor: palette.series[2],
                    borderRadius: 6,
                    maxBarThickness: 42,
                }],
            },
            options: verticalOptions(180),
        });
    }

    const kabupatenEl = document.getElementById('chart-kabupaten');

    if (kabupatenEl) {
        new Chart(kabupatenEl, {
            type: 'bar',
            data: {
                labels: kabupaten.map((row) => row.label),
                datasets: [{
                    label: 'Jumlah alumni',
                    data: kabupaten.map((row) => row.jumlah),
                    backgroundColor: palette.series[3],
                    borderRadius: 6,
                    maxBarThickness: 20,
                }],
            },
            options: horizontalOptions(270),
        });
    }
}
