<?php
/**
 * Image Section Shortcode
 * Creates a two-column section with image and text content.
 * 
 * Usage: [image_section image="..." alt="..." position="left" title="..." content="..." button_text="..." button_url="..." background="transparent"]
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function tov_image_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'image' => '',
        'alt' => '',
        'position' => 'left', // left or right
        'title' => '',
        'content' => '',
        'button_text' => '',
        'button_url' => '',
        'background' => 'transparent' // transparent, navy, white
    ), $atts);
    
    $section_classes = 'image-section py-16';
    if ($atts['background'] === 'navy') {
        $section_classes .= ' bg-navy-800';
    } elseif ($atts['background'] === 'white') {
        $section_classes .= ' bg-white text-gray-900';
    }
    
    $text_color = $atts['background'] === 'white' ? 'text-gray-900' : 'text-white';
    $subtitle_color = $atts['background'] === 'white' ? 'text-gray-600' : 'text-navy-200';
    
    ob_start();
    ?>
    <section class="<?php echo esc_attr($section_classes); ?>">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <?php if ($atts['position'] === 'right') : ?>
                    <!-- Text Content First -->
                    <div class="content-area">
                        <?php if (!empty($atts['title'])) : ?>
                            <h2 class="text-3xl md:text-4xl font-bold mb-6 <?php echo $text_color; ?>">
                                <?php echo esc_html($atts['title']); ?>
                            </h2>
                        <?php endif; ?>
                        <?php if (!empty($atts['content'])) : ?>
                            <p class="text-lg mb-6 <?php echo $subtitle_color; ?> leading-relaxed">
                                <?php echo esc_html($atts['content']); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($atts['button_text']) && !empty($atts['button_url'])) : ?>
                            <a href="<?php echo esc_url($atts['button_url']); ?>" class="btn btn-primary">
                                <?php echo esc_html($atts['button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Image Second -->
                    <?php if (!empty($atts['image'])) : ?>
                        <div class="image-area">
                            <img src="<?php echo esc_url($atts['image']); ?>" 
                                 alt="<?php echo esc_attr($atts['alt']); ?>" 
                                 class="w-full h-auto rounded-lg shadow-lg">
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- Image First -->
                    <?php if (!empty($atts['image'])) : ?>
                        <div class="image-area">
                            <img src="<?php echo esc_url($atts['image']); ?>" 
                                 alt="<?php echo esc_attr($atts['alt']); ?>" 
                                 class="w-full h-auto rounded-lg shadow-lg">
                        </div>
                    <?php endif; ?>
                    
                    <!-- Text Content Second -->
                    <div class="content-area">
                        <?php if (!empty($atts['title'])) : ?>
                            <h2 class="text-3xl md:text-4xl font-bold mb-6 <?php echo $text_color; ?>">
                                <?php echo esc_html($atts['title']); ?>
                            </h2>
                        <?php endif; ?>
                        <?php if (!empty($atts['content'])) : ?>
                            <p class="text-lg mb-6 <?php echo $subtitle_color; ?> leading-relaxed">
                                <?php echo esc_html($atts['content']); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($atts['button_text']) && !empty($atts['button_url'])) : ?>
                            <a href="<?php echo esc_url($atts['button_url']); ?>" class="btn btn-primary">
                                <?php echo esc_html($atts['button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('image_section', 'tov_image_section_shortcode');
