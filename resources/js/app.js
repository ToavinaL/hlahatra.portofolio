const revealElements = document.querySelectorAll('[data-reveal]');

if (revealElements.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            entry.target.classList.add('fc-reveal');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.14 });

    revealElements.forEach((element) => revealObserver.observe(element));
}
