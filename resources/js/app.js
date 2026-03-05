import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.AOS = AOS;

let hasInitializedAos = false;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    window.setTimeout(() => {
        document.body.classList.remove('page-enter');
    }, 420);

    initAosAnimations();
    initScrollspy();
    initBackToTop();
    initPageTransitions();
});

window.addEventListener('load', () => {
    if (!hasInitializedAos) {
        return;
    }

    AOS.refreshHard();
});

window.addEventListener('pageshow', () => {
    document.body.classList.remove('page-leaving');

    if (!hasInitializedAos) {
        return;
    }

    AOS.refreshHard();
});

function initAosAnimations() {
    const revealOnlyElements = document.querySelectorAll('[data-reveal]:not([data-aos])');

    revealOnlyElements.forEach((element) => {
        element.setAttribute('data-aos', 'fade-up');

        if (!element.hasAttribute('data-aos-duration')) {
            element.setAttribute('data-aos-duration', '700');
        }
    });

    AOS.init({
        duration: 760,
        delay: 0,
        easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
        once: true,
        mirror: false,
        offset: 48,
        disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    });

    hasInitializedAos = true;

    window.requestAnimationFrame(() => {
        AOS.refreshHard();
    });
}

function initPageTransitions() {
    document.addEventListener(
        'click',
        (event) => {
            const link = event.target.closest('a[href]');

            if (!link) {
                return;
            }

            if (
                link.target === '_blank' ||
                event.defaultPrevented ||
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey ||
                link.hasAttribute('download')
            ) {
                return;
            }

            const url = new URL(link.href, window.location.origin);
            const href = link.getAttribute('href') ?? '';

            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
                return;
            }

            if (url.origin !== window.location.origin) {
                return;
            }

            if (link.hasAttribute('data-no-transition')) {
                return;
            }

            if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) {
                return;
            }

            if (url.href === window.location.href) {
                return;
            }

            event.preventDefault();
            document.body.classList.remove('page-enter');
            document.body.classList.add('page-leaving');

            window.setTimeout(() => {
                window.location.assign(link.href);
            }, 280);
        },
        { capture: true }
    );
}

function initScrollspy() {
    const links = Array.from(document.querySelectorAll('[data-scrollspy-link]'));

    if (!links.length) {
        return;
    }

    const sections = links
        .map((link) => {
            const href = link.getAttribute('href') ?? '';
            const hash = href.startsWith('#') ? href : `#${href.split('#')[1] ?? ''}`;

            if (!hash || hash === '#') {
                return null;
            }

            const section = document.querySelector(hash);

            return section
                ? {
                      hash,
                      section,
                  }
                : null;
        })
        .filter(Boolean);

    if (!sections.length) {
        return;
    }

    const activate = (hash) => {
        links.forEach((link) => {
            const linkHash = link.getAttribute('href');
            const normalized = linkHash?.startsWith('#') ? linkHash : `#${linkHash?.split('#')[1] ?? ''}`;

            if (normalized === hash) {
                link.classList.add('is-active');
            } else {
                link.classList.remove('is-active');
            }
        });
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activate(`#${entry.target.id}`);
                }
            });
        },
        {
            threshold: 0.35,
            rootMargin: '-40% 0px -45% 0px',
        }
    );

    sections.forEach(({ section }) => observer.observe(section));

    links.forEach((link) => {
        link.addEventListener('click', () => {
            const hash = link.getAttribute('href');
            if (hash?.startsWith('#')) {
                activate(hash);
            }
        });
    });
}

function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');

    if (!button) {
        return;
    }

    const syncVisibility = () => {
        const isVisible = window.scrollY > 280;

        button.classList.toggle('is-visible', isVisible);
        button.setAttribute('aria-hidden', String(!isVisible));
    };

    syncVisibility();

    window.addEventListener('scroll', syncVisibility, { passive: true });

    button.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}
