import { Chart } from 'chart.js';

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
                backgroundColor: '#0284c7',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, max: 100 } },
        },
    });
}
