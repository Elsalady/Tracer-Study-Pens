import { Chart } from 'chart.js';

const BAR_HORIZONTAL = {
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
};

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
                    backgroundColor: '#0ea5e9',
                }],
            },
            options: BAR_HORIZONTAL,
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
                    backgroundColor: '#8b5cf6',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            },
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
                    backgroundColor: '#f59e0b',
                }],
            },
            options: BAR_HORIZONTAL,
        });
    }
}
