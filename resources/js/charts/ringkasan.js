import { Chart } from 'chart.js';

const LABEL_STATUS = {
    BEKERJA: 'Bekerja',
    KULIAH_LANJUT: 'Kuliah Lanjut',
    WIRAUSAHA: 'Wirausaha',
    BELUM_BEKERJA: 'Belum Bekerja',
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
                    borderColor: '#0284c7',
                    backgroundColor: 'rgba(2, 132, 199, 0.12)',
                    pointBackgroundColor: '#0369a1',
                    tension: 0.3,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, max: 100 } },
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
                    backgroundColor: ['#0284c7', '#38bdf8', '#10b981', '#f59e0b'],
                }],
            },
            options: { responsive: true, maintainAspectRatio: false },
        });
    }
}
