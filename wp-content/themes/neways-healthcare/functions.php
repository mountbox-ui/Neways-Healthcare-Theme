<?php
/**
 * Tov Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Theme version
define('TOV_THEME_VERSION', '1.0.0');

/**
 * Theme setup
 */
function tov_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'tov-theme'),
        'footer'  => esc_html__('Footer Menu', 'tov-theme'),
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'tov_theme_setup');
/**
 * Enqueue scripts and styles
 */
function tov_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'tov-theme-style',
        get_template_directory_uri() . '/assets/css/tov.css',
        array(),
        TOV_THEME_VERSION
    );

    // Main JavaScript file
    wp_enqueue_script(
        'tov-theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        TOV_THEME_VERSION,
        true
    );

}
add_action('wp_enqueue_scripts', 'tov_theme_scripts');



/**
 * Add custom classes to navigation menu
 */
function tov_theme_nav_menu_css_class($classes, $item, $args) {
    if ($args->theme_location == 'primary') {
        $classes[] = 'text-white hover:text-navy-200 px-3 py-2 text-sm font-medium transition-colors duration-200';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'tov_theme_nav_menu_css_class', 10, 3);


/**
 * Load Shortcodes
 */
require_once get_template_directory() . '/shortcodes/loader.php';

