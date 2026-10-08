/**
 * SIPAROKI Frontend Utilities
 * Counters, Mobile Nav, Back to top, Lightbox
 */
(function () {
    var html = document.documentElement;

    function setThemeIcon() {
        var darkToggle = document.getElementById('darkToggle');
        if (!darkToggle) return;
        var icon = darkToggle.querySelector('i');
        if (!icon) return;
        icon.className = html.getAttribute('data-theme') === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }

    function initCounters() {
        var counters = document.querySelectorAll('.counter[data-target], [data-counter-target]');
        if (!counters.length) return;

        function animate(counter) {
            var raw = counter.getAttribute('data-target') || counter.getAttribute('data-counter-target') || '0';
            var target = parseInt(raw.replace(/[^0-9]/g, ''), 10);
            if (!Number.isFinite(target) || target === 0) return;
            var duration = 1500;
            var startTime = null;

            function tick(now) {
                if (!startTime) startTime = now;
                var progress = Math.min((now - startTime) / duration, 1);
                var current = Math.floor(target * progress);
                counter.textContent = current.toLocaleString('id-ID');
                if (progress < 1) window.requestAnimationFrame(tick);
            }

            window.requestAnimationFrame(tick);
        }

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    animate(entry.target);
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.2 });

            counters.forEach(function (counter) {
                observer.observe(counter);
            });
        } else {
            counters.forEach(animate);
        }
    }

    function initLightbox() {
        if (typeof lightbox !== 'undefined') {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': 'Foto %1 dari %2',
                'fadeDuration': 200,
                'imageFadeDuration': 200
            });
        }
    }

    function initBackToTop() {
        var button = document.getElementById('backToTop');
        if (!button) return;

        function update() {
            var scrolled = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            button.classList.toggle('show', scrolled > 280);
        }

        button.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        window.addEventListener('scroll', update, { passive: true });
        update();
    }

    function init() {
        setThemeIcon();
        initCounters();
        initLightbox();
        initBackToTop();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    document.addEventListener('livewire:navigated', init);
})();
