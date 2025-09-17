<?php
/**
 * Image Section Shortcode
 * [image_section position="left"]
 *    [image_section_image src="image.jpg" alt="Alt text"]
 *    [image_section_content title="Title" button_text="Click" button_url="#"]Content[/image_section_content]
 * [/image_section]
 */

if (!defined('ABSPATH')) exit;

function neways_image_section_shortcode($atts, $content = null) {
    $atts = shortcode_atts(['position' => 'left'], $atts);

    if (empty($content)) {
        return ''; // nothing to render
    }

    // Find nested shortcodes reliably
    $pattern = get_shortcode_regex(['image_section_content', 'image_section_image']);
    $image_content = '';
    $text_content = '';

    if (preg_match_all('/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $shortcode_name = isset($m[2]) ? $m[2] : '';
            $attr_string = isset($m[3]) ? $m[3] : '';
            $inner = isset($m[5]) ? $m[5] : '';

            $child_atts = [];
            if (!empty($attr_string)) {
                $parsed = shortcode_parse_atts($attr_string);
                if (is_array($parsed)) $child_atts = $parsed;
            }

            if ($shortcode_name === 'image_section_image') {
                $image_content = neways_image_section_image_shortcode($child_atts, $inner);
            } elseif ($shortcode_name === 'image_section_content') {
                $text_content = neways_image_section_content_shortcode($child_atts, $inner);
            }
        }
    } else {
        // Fallback: if no recognized nested shortcodes, render content as-is
        $text_content = do_shortcode($content);
    }

    ob_start();
    ?>
    <section class="bg-navy-900 py-8 sm:py-12 md:py-16">
        <div class="container-custom mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 sm:gap-12 lg:gap-16 <?php echo $atts['position'] === 'right' ? 'lg:flex-row-reverse' : 'lg:flex-row'; ?> items-center justify-between">
                <!-- Text Content -->
                <div class="w-full md:w-4/5 lg:w-1/2 text-center lg:text-left">
                    <?php echo $text_content; ?>
                </div>
                <!-- Image Content -->
                <div class="w-full md:w-4/5 lg:w-1/2">
                    <div class="rounded-lg">
                        <?php echo $image_content; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

function neways_image_section_image_shortcode($atts, $content = null) {
    $atts = shortcode_atts(['src' => '', 'alt' => ''], $atts);
    $src = empty($atts['src']) ? trim($content) : $atts['src'];
    if (empty($src)) return '';
    
    return sprintf(
        '<img src="%s" alt="%s" class="w-full h-auto rounded-lg">',
        esc_url($src),
        esc_attr($atts['alt'])
    );
}

function neways_image_section_content_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'title' => '',
        'button_text' => '',
        'button_url' => ''
    ], $atts);
    
    ob_start();
    ?>
    <div class="content-container">
        <?php if (!empty($atts['title'])) : ?>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 sm:mb-6 md:mb-8">
                <?php echo esc_html($atts['title']); ?>
            </h2>
        <?php endif; ?>
        
        <div class="text-base sm:text-lg text-navy-200 leading-relaxed mb-6 sm:mb-8 max-w-xl mx-auto lg:mx-0">
            <?php echo wp_kses_post($content); ?>
        </div>
        
        <?php if (!empty($atts['button_text']) && !empty($atts['button_url'])) : ?>
            <a href="<?php echo esc_url($atts['button_url']); ?>" 
               class="inline-block bg-blue-600 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-md text-base sm:text-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                <?php echo esc_html($atts['button_text']); ?>
            </a>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('image_section', 'neways_image_section_shortcode');
add_shortcode('image_section_image', 'neways_image_section_image_shortcode');
add_shortcode('image_section_content', 'neways_image_section_content_shortcode');
