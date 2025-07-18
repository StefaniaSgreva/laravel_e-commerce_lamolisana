import './bootstrap';
import { initLoader } from './components/loader';
import { initArrowUp } from './components/arrowUp';


document.addEventListener('DOMContentLoaded', () => {
    initLoader();
    initArrowUp();

    const header = document.getElementById('main-header');
    const logoContainer = document.getElementById('logo-container');
    const nav = document.querySelector('nav');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const scrollThreshold = 100;
    let lastKnownScroll = 0;
    let animationId = null;

    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', String(!isExpanded));

            // Animazione menu
            if (isExpanded) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            // Forza il reflow per attivare le transizioni
            void mobileMenuButton.offsetHeight;
        });
    }

    // Chiudi menu quando si clicca su un link
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        });
    });

    function updateHeaderState(scrollY) {
        const isMobile = window.innerWidth < 768;
        const progress = Math.min(scrollY / scrollThreshold, 1);

        if (isMobile) {
            // Comportamento mobile semplificato
            if (scrollY > 30) {
                header.classList.add('shrink');
            } else {
                header.classList.remove('shrink');
            }
        } else {
            // Comportamento desktop originale
            if (progress > 0 && progress < 1) {
                header.style.height = `${180 - (100 * progress)}px`;
                logoContainer.style.height = `${120 - (120 * progress)}px`;
                logoContainer.style.opacity = `${1 - progress}`;
                nav.style.paddingTop = `${1 - (0.5 * progress)}rem`;
                nav.style.paddingBottom = `${1 - (0.5 * progress)}rem`;

                if (progress > 0.5) {
                    header.classList.add('shrink');
                } else {
                    header.classList.remove('shrink');
                }
            } else if (progress >= 1) {
                header.classList.add('shrink');
                header.style.height = '';
                logoContainer.style.height = '';
                logoContainer.style.opacity = '';
                nav.style.paddingTop = '';
                nav.style.paddingBottom = '';
            } else {
                header.classList.remove('shrink');
                header.style.height = '';
                logoContainer.style.height = '';
                logoContainer.style.opacity = '';
                nav.style.paddingTop = '';
                nav.style.paddingBottom = '';
            }
        }
    }

    function onScroll() {
        lastKnownScroll = window.scrollY;

        if (!animationId) {
            animationId = requestAnimationFrame(() => {
                updateHeaderState(lastKnownScroll);
                animationId = null;
            });
        }
    }

    // Configurazione iniziale
    updateHeaderState(window.scrollY);

    // Event listener ottimizzato
    window.addEventListener('scroll', onScroll, { passive: true });

    // Pulisci gli stili al resize per evitare artefatti
    window.addEventListener('resize', () => {
        header.style.height = '';
        logoContainer.style.height = '';
        updateHeaderState(window.scrollY);
    });
});
