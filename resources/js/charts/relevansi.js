import { Chart } from 'chart.js';

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
                    backgroundColor: '#0ea5e9',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
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
                    backgroundColor: '#10b981',
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: { x: { beginAtZero: true, max: 5 } },
            },
        });
    }
}
