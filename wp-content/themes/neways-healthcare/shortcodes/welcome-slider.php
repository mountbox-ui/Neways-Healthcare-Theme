<?php
/**
 * Welcome Slider Shortcode
 * Creates a responsive image slider with navigation and autoplay functionality.
 * 
 * Usage: [welcome_slider slides='[...]' height="600px" autoplay="true" duration="5000"]
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function tov_welcome_slider_shortcode($atts) {
    $atts = shortcode_atts(array(
        'slides' => '', // JSON string of slides
        'height' => '500px',
        'autoplay' => 'true',
        'duration' => '5000'
    ), $atts);
    
    if (empty($atts['slides'])) {
        return '<div class="slider-placeholder bg-navy-800 text-white p-8 text-center rounded-lg">Please add slides to your welcome slider shortcode.</div>';
    }
    
    $slides = json_decode($atts['slides'], true);
    if (!$slides) {
        return '<div class="slider-error bg-red-100 text-red-800 p-4 rounded">Invalid slides data. Please check your JSON format.</div>';
    }
    
    $slider_id = 'welcome-slider-' . uniqid();
    
    ob_start();
    ?>
    <div class="welcome-slider relative overflow-hidden rounded-lg shadow-lg mb-12" style="height: <?php echo esc_attr($atts['height']); ?>">
        <div id="<?php echo $slider_id; ?>" class="slider-container h-full relative">
            <?php foreach ($slides as $index => $slide) : ?>
                <div class="slide absolute inset-0 transition-opacity duration-1000 <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>" 
                     style="background-image: url('<?php echo esc_url($slide['image']); ?>'); background-size: cover; background-position: center;">
                    <div class="slide-overlay absolute inset-0 bg-black bg-opacity-40"></div>
                    <div class="slide-content absolute inset-0 flex items-center justify-center text-center text-white p-8">
                        <div class="container-custom">
                            <?php if (!empty($slide['title'])) : ?>
                                <h1 class="text-4xl md:text-6xl font-bold mb-4 text-shadow"><?php echo esc_html($slide['title']); ?></h1>
                            <?php endif; ?>
                            <?php if (!empty($slide['subtitle'])) : ?>
                                <p class="text-xl md:text-2xl mb-6 text-shadow"><?php echo esc_html($slide['subtitle']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($slide['button_text']) && !empty($slide['button_url'])) : ?>
                                <a href="<?php echo esc_url($slide['button_url']); ?>" 
                                   class="btn btn-primary text-lg px-8 py-4 inline-block">
                                    <?php echo esc_html($slide['button_text']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (count($slides) > 1) : ?>
                <!-- Navigation arrows -->
                <button class="slider-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="slider-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Dots indicator -->
                <div class="slider-dots absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <button class="dot w-3 h-3 rounded-full bg-white <?php echo $index === 0 ? 'bg-opacity-100' : 'bg-opacity-50'; ?> transition-all duration-200" 
                                data-slide="<?php echo $index; ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('<?php echo $slider_id; ?>');
        const slides = slider.querySelectorAll('.slide');
        const dots = slider.querySelectorAll('.dot');
        const prevBtn = slider.querySelector('.slider-prev');
        const nextBtn = slider.querySelector('.slider-next');
        let currentSlide = 0;
        let autoplayInterval;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = i === index ? '1' : '0';
            });
            dots.forEach((dot, i) => {
                dot.className = i === index ? 
                    'dot w-3 h-3 rounded-full bg-white bg-opacity-100 transition-all duration-200' : 
                    'dot w-3 h-3 rounded-full bg-white bg-opacity-50 transition-all duration-200';
            });
            currentSlide = index;
        }
        
        function nextSlide() {
            const next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }
        
        function prevSlide() {
            const prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }
        
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });
        
        <?php if ($atts['autoplay'] === 'true' && count($slides) > 1) : ?>
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, <?php echo intval($atts['duration']); ?>);
        }
        
        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }
        
        startAutoplay();
        
        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);
        <?php endif; ?>
    });
    </script>
    
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('welcome_slider', 'tov_welcome_slider_shortcode');
