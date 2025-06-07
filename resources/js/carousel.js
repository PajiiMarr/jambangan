document.addEventListener('DOMContentLoaded', () => {
    let currentSlide = 0;
    const slides = window.coverMedias || [];
    const captions = slides.map(slide => `${slide.title ?? ''} - ${slide.subtitle ?? ''}`);
    const slideElements = document.querySelectorAll('.bg-cover');
    const progressBar = document.getElementById('progress-bar');
    let progressInterval;
    let progress = 0;
    const SLIDE_DURATION = 12000;
    const PROGRESS_STEPS = 200;
    const PROGRESS_INTERVAL = SLIDE_DURATION / PROGRESS_STEPS;

    if (!slideElements.length || !progressBar || !slides.length) return;

    function updateSlide() {
        slideElements[currentSlide].style.opacity = '0';

        setTimeout(() => {
            slideElements.forEach((slide, index) => {
                slide.style.display = index === currentSlide ? 'block' : 'none';
            });
            document.getElementById('slide-caption').textContent = captions[currentSlide];
            slideElements[currentSlide].style.opacity = '1';
        }, 300);
    }

    function resetProgress() {
        progress = 0;
        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        progressBar.offsetHeight; // force reflow
        progressBar.style.transition = 'width 100ms linear';
        clearInterval(progressInterval);
        startProgress();
    }

    function startProgress() {
        progressInterval = setInterval(() => {
            progress += 0.5;
            progressBar.style.width = `${progress}%`;
            if (progress >= 100) {
                clearInterval(progressInterval);
                nextSlide();
            }
        }, PROGRESS_INTERVAL);
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlide();
        setTimeout(resetProgress, 50);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlide();
        setTimeout(resetProgress, 50);
    }

    // Init
    updateSlide();
    startProgress();

    // AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            once: false,
            duration: 800,
            easing: 'ease-in-out',
            offset: 100,
            delay: 100,
        });
    }

    // Export scroll function globally
    window.scrollPerformances = function (direction) {
        const container = document.querySelector('.flex.overflow-x-auto');
        const scrollAmount = 400;
        if (!container) return;

        container.scrollBy({
            left: direction === 'left' ? -scrollAmount : scrollAmount,
            behavior: 'smooth'
        });
    };
});
