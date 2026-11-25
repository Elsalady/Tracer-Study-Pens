export function initSidebar() {
    const toggle = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    const sidebar = document.getElementById('sidebar');

    if (!toggle || !overlay || !sidebar) {
        return;
    }

    const close = () => {
        document.body.classList.remove('sidebar-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Buka menu');
    };

    const open = () => {
        document.body.classList.add('sidebar-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Tutup menu');
    };

    toggle.addEventListener('click', () => {
        if (document.body.classList.contains('sidebar-open')) {
            close();
        } else {
            open();
        }
    });

    overlay.addEventListener('click', close);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });

    sidebar.querySelectorAll('a, button').forEach((element) => {
        element.addEventListener('click', () => {
            if (window.matchMedia('(max-width: 1023px)').matches) {
                close();
            }
        });
    });

    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches) {
            close();
        }
    });
}
