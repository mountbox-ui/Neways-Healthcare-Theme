<?php
/**
 * Neways Theme functions and definitions - Minimal Version
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Theme version
define('NEWAYS_THEME_VERSION', '1.0.0');

/**
 * Theme setup
 */
function neways_theme_setup() {
    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'neways-theme'),
        'footer'  => esc_html__('Footer Menu', 'neways-theme'),
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'neways_theme_setup');
/**
 * Enqueue scripts and styles
 */
function neways_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'neways-theme-style',
        get_template_directory_uri() . '/assets/css/neways.css',
        array(),
        NEWAYS_THEME_VERSION
    );

    // Main JavaScript file
    wp_enqueue_script(
        'neways-theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        NEWAYS_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'neways_theme_scripts');

/**
 * Add custom classes to navigation menu
 */
function neways_theme_nav_menu_css_class($classes, $item, $args) {
    if ($args->theme_location == 'primary') {
        $classes[] = 'text-white hover:text-navy-200 px-3 py-2 text-sm font-medium transition-colors duration-200';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'neways_theme_nav_menu_css_class', 10, 3);


/**
 * Load Shortcodes
 */
require_once get_template_directory() . '/shortcodes/loader.php';

/**
 * Load Custom Post Types
 */
require_once get_template_directory() . '/inc/post-types/events.php';

/**
 * Add templates folder to WordPress template hierarchy
 */
function neways_add_template_directory($template) {
    // Check if it's a page template request
    if (is_page_template()) {
        $templates_dir = get_template_directory() . '/templates/';
        
        // Look for page templates in the templates folder
        if (is_page()) {
            $page_template = get_page_template_slug();
            
            // Handle templates from templates/ folder
            if ($page_template && strpos($page_template, 'templates/') === 0) {
                $template_file = $page_template;
                if (file_exists(get_template_directory() . '/' . $template_file)) {
                    return get_template_directory() . '/' . $template_file;
                }
            }
            
            // Also check direct filename in templates folder
            if ($page_template && file_exists($templates_dir . $page_template)) {
                return $templates_dir . $page_template;
            }
        }
    }
    
    return $template;
}
add_filter('page_template', 'neways_add_template_directory');

/**
 * Register page templates from templates folder
 */
function neways_get_page_templates() {
    $templates = array();
    $templates_dir = get_template_directory() . '/templates/';
    
    if (is_dir($templates_dir)) {
        $files = glob($templates_dir . '*.php');
        foreach ($files as $file) {
            $filename = basename($file);
            if ($filename !== 'page.php') {
                $template_data = get_file_data($file, array('Template Name' => 'Template Name'));
                if (!empty($template_data['Template Name'])) {
                    $templates['templates/' . $filename] = $template_data['Template Name'];
                }
            }
        }
    }
    
    return $templates;
}

/**
 * Add page templates to the template dropdown
 */
function neways_add_page_templates($templates) {
    $custom_templates = neways_get_page_templates();
    return array_merge($templates, $custom_templates);
}
add_filter('theme_page_templates', 'neways_add_page_templates');

/**
 * Debug function to check if templates are being registered
 */
function neways_debug_templates() {
    if (current_user_can('manage_options') && isset($_GET['debug_templates'])) {
        $templates = neways_get_page_templates();
        echo '<pre>';
        echo "Registered Templates:\n";
        print_r($templates);
        echo '</pre>';
    }
}
add_action('admin_init', 'neways_debug_templates');

/**
 * AJAX handler for loading more events
 */
function neways_load_more_events() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'neways_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $page = intval($_POST['page']);
    $today = date('Y-m-d');
    
    // Query past events for the specific page
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => 6,
        'paged' => $page,
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => $today,
                'compare' => '<',
                'type' => 'DATE'
            )
        )
    );
    
    $events_query = new WP_Query($args);
    
    if ($events_query->have_posts()) {
        ob_start();
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            neways_render_event_card(get_the_ID(), $event_date, $event_end_date, $event_location);
        }
        wp_reset_postdata();
        
        $html = ob_get_clean();
        wp_send_json_success(array('html' => $html));
    } else {
        wp_send_json_error('No more events found');
    }
}
add_action('wp_ajax_load_more_events', 'neways_load_more_events');
add_action('wp_ajax_nopriv_load_more_events', 'neways_load_more_events');

/**
 * Enqueue AJAX script with nonce
 */
function neways_enqueue_ajax_script() {
    wp_localize_script('neways-theme-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('neways_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'neways_enqueue_ajax_script');


