import { Chart, registerables } from 'chart.js';
import { renderRingkasan } from './ringkasan';
import { renderKeterserapan } from './keterserapan';
import { renderRelevansi } from './relevansi';
import { renderProfilAlumni } from './profil-alumni';

Chart.register(...registerables);

window.TracerCharts = {
    ringkasan: renderRingkasan,
    keterserapan: renderKeterserapan,
    relevansi: renderRelevansi,
    profilAlumni: renderProfilAlumni,
};
