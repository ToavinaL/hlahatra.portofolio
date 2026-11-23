const revealElements = document.querySelectorAll('[data-reveal]');

if (revealElements.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            entry.target.classList.toggle('fc-visible', entry.isIntersecting);
        });
    }, { threshold: 0.14 });

    revealElements.forEach((element) => revealObserver.observe(element));
}
