/**
 * Creator Base - Main JavaScript
 *
 * @package Creator_Base
 */

(function() {
    'use strict';

    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navArea = document.querySelector('.nav-area');

    if (menuToggle && navArea) {
        menuToggle.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            navArea.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navArea.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.setAttribute('aria-expanded', 'false');
                navArea.classList.remove('active');
            }
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Promo bar navigation
    document.querySelectorAll('.promo-bar--horizontal').forEach(promoBar => {
        const inner = promoBar.querySelector('.promo-bar-inner');
        const prevBtn = promoBar.querySelector('.promo-bar-nav--prev');
        const nextBtn = promoBar.querySelector('.promo-bar-nav--next');
        
        if (!inner || !prevBtn || !nextBtn) return;
        
        const scrollAmount = 220; // Approximate width of one promo image + gap
        
        // Update button visibility based on scroll position
        function updateNavVisibility() {
            const scrollLeft = inner.scrollLeft;
            const maxScroll = inner.scrollWidth - inner.clientWidth;
            
            // Hide prev button if at start
            if (scrollLeft <= 0) {
                prevBtn.classList.add('hidden');
            } else {
                prevBtn.classList.remove('hidden');
            }
            
            // Hide next button if at end
            if (scrollLeft >= maxScroll - 1) {
                nextBtn.classList.add('hidden');
            } else {
                nextBtn.classList.remove('hidden');
            }
        }
        
        // Initial visibility check
        updateNavVisibility();
        
        // Update on scroll
        inner.addEventListener('scroll', updateNavVisibility);
        
        // Update on resize
        window.addEventListener('resize', updateNavVisibility);
        
        // Previous button click
        prevBtn.addEventListener('click', function() {
            inner.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });
        
        // Next button click
        nextBtn.addEventListener('click', function() {
            inner.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    });

    // Lazy load embeds in cards (only load iframe when visible)
    if ('IntersectionObserver' in window) {
        const embedObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const iframe = container.querySelector('iframe[data-src]');
                    
                    if (iframe) {
                        iframe.src = iframe.dataset.src;
                        iframe.removeAttribute('data-src');
                    }
                    
                    observer.unobserve(container);
                }
            });
        }, {
            rootMargin: '100px'
        });

        document.querySelectorAll('.card-media .embed-container').forEach(container => {
            embedObserver.observe(container);
        });
    }

    // Hero Carousel
    const carousel = document.querySelector('.hero-section--carousel');
    if (carousel) {
        const slides = carousel.querySelectorAll('.carousel-slide');
        const dots = carousel.querySelectorAll('.carousel-dot');
        let currentSlide = 0;
        let autoAdvanceInterval;
        const autoAdvanceDelay = 6000; // 6 seconds

        function goToSlide(index) {
            // Remove active from all slides and dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Add active to target slide and dot
            slides[index].classList.add('active');
            if (dots[index]) {
                dots[index].classList.add('active');
            }
            
            currentSlide = index;
        }

        function nextSlide() {
            const next = (currentSlide + 1) % slides.length;
            goToSlide(next);
        }

        function startAutoAdvance() {
            autoAdvanceInterval = setInterval(nextSlide, autoAdvanceDelay);
        }

        function stopAutoAdvance() {
            clearInterval(autoAdvanceInterval);
        }

        // Dot click handlers
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goToSlide(index);
                // Reset auto-advance timer
                stopAutoAdvance();
                startAutoAdvance();
            });
        });

        // Pause on hover
        carousel.addEventListener('mouseenter', stopAutoAdvance);
        carousel.addEventListener('mouseleave', startAutoAdvance);

        // Start auto-advance if more than one slide
        if (slides.length > 1) {
            startAutoAdvance();
        }
    }

    // Portfolio Lightbox
    const lightbox = document.getElementById('portfolio-lightbox');
    if (lightbox) {
        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const prevBtn = lightbox.querySelector('.lightbox-prev');
        const nextBtn = lightbox.querySelector('.lightbox-next');
        
        let currentGallery = [];
        let currentIndex = 0;
        
        function openLightbox(imageSrc, gallery, index) {
            currentGallery = gallery || [imageSrc];
            currentIndex = index || 0;
            
            lightboxImage.src = currentGallery[currentIndex];
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            
            // Toggle single-image class for nav button visibility
            if (currentGallery.length <= 1) {
                lightbox.classList.add('single-image');
            } else {
                lightbox.classList.remove('single-image');
            }
        }
        
        function closeLightbox() {
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            lightboxImage.src = '';
        }
        
        function showPrev() {
            if (currentGallery.length <= 1) return;
            currentIndex = (currentIndex - 1 + currentGallery.length) % currentGallery.length;
            lightboxImage.src = currentGallery[currentIndex];
        }
        
        function showNext() {
            if (currentGallery.length <= 1) return;
            currentIndex = (currentIndex + 1) % currentGallery.length;
            lightboxImage.src = currentGallery[currentIndex];
        }
        
        // Event listeners for lightbox controls
        closeBtn.addEventListener('click', closeLightbox);
        prevBtn.addEventListener('click', showPrev);
        nextBtn.addEventListener('click', showNext);
        
        // Close on background click
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightbox.getAttribute('aria-hidden') === 'false') {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') showPrev();
                if (e.key === 'ArrowRight') showNext();
            }
        });
        
        // Attach click handlers to lightbox triggers
        document.querySelectorAll('[data-lightbox]').forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                
                const imageSrc = this.getAttribute('href');
                
                // Check if this trigger is part of a gallery
                const galleryContainer = this.closest('[data-lightbox-gallery]');
                
                if (galleryContainer) {
                    // Get all images in this gallery
                    const galleryTriggers = galleryContainer.querySelectorAll('[data-lightbox]');
                    const gallery = Array.from(galleryTriggers).map(t => t.getAttribute('href'));
                    const index = gallery.indexOf(imageSrc);
                    
                    openLightbox(imageSrc, gallery, index);
                } else {
                    // Single image
                    openLightbox(imageSrc);
                }
            });
        });
    }

})();
