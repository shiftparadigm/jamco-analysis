<?php
/**
 * Likewize Device Protection Theme
 *
 * @package Likewize
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function likewize_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    // Add support for block styles
    add_theme_support('wp-block-styles');
}
add_action('after_setup_theme', 'likewize_theme_setup');

/**
 * Enqueue Google Fonts
 */
function likewize_enqueue_fonts() {
    wp_enqueue_style(
        'likewize-google-fonts',
        'https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'likewize_enqueue_fonts');
add_action('admin_enqueue_scripts', 'likewize_enqueue_fonts');

/**
 * Enqueue Theme Styles and Scripts
 */
function likewize_enqueue_assets() {
    // Theme stylesheet
    wp_enqueue_style(
        'likewize-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Lucide Icons (for SVG icons)
    wp_enqueue_script(
        'lucide-icons',
        'https://unpkg.com/lucide@latest',
        array(),
        null,
        true
    );

    // Theme JavaScript
    wp_enqueue_script(
        'likewize-scripts',
        get_template_directory_uri() . '/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Accordion functionality
    wp_enqueue_script(
        'likewize-accordion',
        get_template_directory_uri() . '/js/accordion.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'likewize_enqueue_assets');

/**
 * Initialize Lucide Icons on frontend
 */
function likewize_init_icons() {
    ?>
    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
    <?php
}
add_action('wp_footer', 'likewize_init_icons');

/**
 * Register Custom Blocks
 */
require_once get_template_directory() . '/inc/blocks.php';

/**
 * SVG Icon Helper Function
 */
require_once get_template_directory() . '/inc/icons.php';

/**
 * Custom Nav Menu (if needed)
 */
function likewize_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'likewize'),
        'footer' => __('Footer Menu', 'likewize'),
    ));
}
add_action('init', 'likewize_register_menus');

/**
 * Disable WordPress block directory (optional - keeps block inserter clean)
 */
remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');

/**
 * Customize admin footer text (optional)
 */
function likewize_admin_footer_text() {
    echo 'Likewize Device Protection | Powered by WordPress';
}
add_filter('admin_footer_text', 'likewize_admin_footer_text');


// Disable HTTPS redirects for local development
add_filter('force_ssl_admin', '__return_false', 999);
add_filter('force_ssl_login', '__return_false', 999);
add_filter('https_ssl_verify', '__return_false', 999);
add_filter('https_local_ssl_verify', '__return_false', 999);


// Add Tailwind CSS

// Add Tailwind config
