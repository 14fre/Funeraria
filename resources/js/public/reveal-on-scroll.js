/**
 * Reveal on scroll: anima elementos con clase .reveal-on-scroll al entrar en viewport
 */
export function initRevealOnScroll() {
    const els = document.querySelectorAll('.reveal-on-scroll');
    if (!els.length) return;
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        },
        { rootMargin: '0px 0px -40px 0px', threshold: 0.1 }
    );
    els.forEach((el) => io.observe(el));
}
