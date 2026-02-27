/**
 * Hero frases rotativas: ciclo de frases con transición y puntos indicadores
 */
export function initHeroPhrases() {
    const container = document.getElementById('hero-phrases');
    const dotsContainer = document.getElementById('hero-phrases-dots');
    if (!container || !dotsContainer) return;

    const phrases = container.querySelectorAll('.hero-phrase');
    if (phrases.length <= 1) return;

    let current = 0;
    let nextTimeout;

    function updateDots() {
        const dots = dotsContainer.querySelectorAll('.hero-phrases-dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === current);
        });
    }

    for (let i = 0; i < phrases.length; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'hero-phrases-dot' + (i === 0 ? ' is-active' : '');
        dot.setAttribute('aria-label', `Frase ${i + 1}`);
        dot.addEventListener('click', () => {
            clearTimeout(nextTimeout);
            phrases[current].classList.remove('is-visible', 'is-exiting');
            current = i;
            phrases[current].classList.add('is-visible');
            updateDots();
            nextTimeout = setTimeout(goNext, 5200);
        });
        dotsContainer.appendChild(dot);
    }

    function goNext() {
        phrases[current].classList.add('is-exiting');
        setTimeout(() => {
            phrases[current].classList.remove('is-visible', 'is-exiting');
            current = (current + 1) % phrases.length;
            phrases[current].classList.add('is-visible');
            updateDots();
            nextTimeout = setTimeout(goNext, 5200);
        }, 620);
    }

    nextTimeout = setTimeout(goNext, 5200);
}
