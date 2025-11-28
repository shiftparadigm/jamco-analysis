<?php
/**
 * Jamco Theme Functions
 *
 * Registers ACF blocks, enqueues styles, sets up custom post types
 */

if (!defined('ABSPATH')) exit;

// Include ACF field groups
require_once get_template_directory() . '/inc/acf-field-groups.php';

// Theme setup
function jamco_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'jamco'),
    ));
}
add_action('after_setup_theme', 'jamco_theme_setup');

// Enqueue styles and scripts
function jamco_enqueue_assets() {
    // Fonts
    wp_enqueue_style('jamco-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap', array(), null);

    // Design tokens
    wp_enqueue_style('jamco-design-tokens', get_template_directory_uri() . '/assets/css/design-tokens.css', array(), '1.0.0');

    // Global styles
    wp_enqueue_style('jamco-global', get_template_directory_uri() . '/assets/css/global.css', array('jamco-design-tokens'), '1.0.0');

    // Main theme stylesheet
    wp_enqueue_style('jamco-style', get_stylesheet_uri(), array('jamco-global'), '1.0.0');

    // Block styles
    wp_enqueue_style('jamco-blocks', get_template_directory_uri() . '/assets/css/blocks.css', array('jamco-global'), '1.0.0');
}
add_action('wp_enqueue_scripts', 'jamco_enqueue_assets');

// Enqueue block editor assets
function jamco_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'jamco-blocks-editor',
        get_template_directory_uri() . '/assets/js/blocks.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'),
        '1.0.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'jamco_enqueue_block_editor_assets');

// Register Jamco Blocks (using ACF block API)
function jamco_register_blocks() {
    // Check if ACF function exists
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Hero Block
    acf_register_block_type(array(
        'name'              => 'hero',
        'title'             => __('Hero Section', 'jamco'),
        'description'       => __('Hero section with heading, image, and CTAs', 'jamco'),
        'render_template'   => 'blocks/hero.php',
        'category'          => 'jamco',
        'icon'              => 'cover-image',
        'keywords'          => array('hero', 'banner', 'header'),
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        ),
    ));

    // Section Intro Block
    acf_register_block_type(array(
        'name'              => 'section-intro',
        'title'             => __('Section Intro', 'jamco'),
        'description'       => __('Introduction section with eyebrow, heading, and description', 'jamco'),
        'render_template'   => 'blocks/section-intro.php',
        'category'          => 'jamco',
        'icon'              => 'editor-textcolor',
        'keywords'          => array('section', 'intro', 'heading'),
    ));

    // Feature Grid Block
    acf_register_block_type(array(
        'name'              => 'feature-grid',
        'title'             => __('Feature Grid', 'jamco'),
        'description'       => __('3-column feature grid with images', 'jamco'),
        'render_template'   => 'blocks/feature-grid.php',
        'category'          => 'jamco',
        'icon'              => 'grid-view',
        'keywords'          => array('features', 'grid', 'columns'),
    ));

    // Split Feature Block
    acf_register_block_type(array(
        'name'              => 'split-feature',
        'title'             => __('Split Feature', 'jamco'),
        'description'       => __('Feature section with image and content split', 'jamco'),
        'render_template'   => 'blocks/split-feature.php',
        'category'          => 'jamco',
        'icon'              => 'columns',
        'keywords'          => array('split', 'feature', 'image'),
    ));

    // Product Carousel Block
    acf_register_block_type(array(
        'name'              => 'product-carousel',
        'title'             => __('Product Carousel', 'jamco'),
        'description'       => __('Carousel of related products', 'jamco'),
        'render_template'   => 'blocks/product-carousel.php',
        'category'          => 'jamco',
        'icon'              => 'images-alt2',
        'keywords'          => array('products', 'carousel', 'slider'),
    ));

    // Testimonial Block
    acf_register_block_type(array(
        'name'              => 'testimonial',
        'title'             => __('Testimonial', 'jamco'),
        'description'       => __('Customer testimonial with quote and author', 'jamco'),
        'render_template'   => 'blocks/testimonial.php',
        'category'          => 'jamco',
        'icon'              => 'format-quote',
        'keywords'          => array('testimonial', 'quote', 'review'),
    ));

    // CTA Block
    acf_register_block_type(array(
        'name'              => 'cta',
        'title'             => __('Call to Action', 'jamco'),
        'description'       => __('Call to action section with background image', 'jamco'),
        'render_template'   => 'blocks/cta.php',
        'category'          => 'jamco',
        'icon'              => 'megaphone',
        'keywords'          => array('cta', 'call to action', 'button'),
    ));

    // Product Showcase Block
    acf_register_block_type(array(
        'name'              => 'product-showcase',
        'title'             => __('Product Showcase', 'jamco'),
        'description'       => __('Full-width product showcase with branding', 'jamco'),
        'render_template'   => 'blocks/product-showcase.php',
        'category'          => 'jamco',
        'icon'              => 'star-filled',
        'keywords'          => array('product', 'showcase', 'hero'),
    ));

    // Seating Diagram Block
    acf_register_block_type(array(
        'name'              => 'seating-diagram',
        'title'             => __('Seating Diagram', 'jamco'),
        'description'       => __('Cabin seating layout diagram', 'jamco'),
        'render_template'   => 'blocks/seating-diagram.php',
        'category'          => 'jamco',
        'icon'              => 'grid-view',
        'keywords'          => array('diagram', 'seating', 'layout'),
    ));

    // Full Width Image Block
    acf_register_block_type(array(
        'name'              => 'full-width-image',
        'title'             => __('Full Width Image', 'jamco'),
        'description'       => __('Full-width image section', 'jamco'),
        'render_template'   => 'blocks/full-width-image.php',
        'category'          => 'jamco',
        'icon'              => 'format-image',
        'keywords'          => array('image', 'full-width', 'photo'),
    ));
}
add_action('init', 'jamco_register_blocks');

// Register custom block category
function jamco_block_categories($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'jamco',
                'title' => __('Jamco Blocks', 'jamco'),
                'icon'  => 'airplane',
            ),
        )
    );
}
add_filter('block_categories_all', 'jamco_block_categories', 10, 2);

// Register Product Custom Post Type
function jamco_register_product_cpt() {
    $labels = array(
        'name'               => __('Products', 'jamco'),
        'singular_name'      => __('Product', 'jamco'),
        'menu_name'          => __('Products', 'jamco'),
        'add_new'            => __('Add New', 'jamco'),
        'add_new_item'       => __('Add New Product', 'jamco'),
        'edit_item'          => __('Edit Product', 'jamco'),
        'new_item'           => __('New Product', 'jamco'),
        'view_item'          => __('View Product', 'jamco'),
        'search_items'       => __('Search Products', 'jamco'),
        'not_found'          => __('No products found', 'jamco'),
        'not_found_in_trash' => __('No products found in trash', 'jamco'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-products',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'rewrite'             => array('slug' => 'products'),
    );

    register_post_type('product', $args);

    // Register product category taxonomy
    register_taxonomy('product_category', 'product', array(
        'labels' => array(
            'name' => __('Product Categories', 'jamco'),
            'singular_name' => __('Product Category', 'jamco'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'product-category'),
    ));
}
add_action('init', 'jamco_register_product_cpt');

// Breadcrumb function
function jamco_breadcrumbs() {
    $breadcrumbs = array();

    // Check if this is the Premium Seating page (even if it's the homepage)
    if (is_page('premium-seating') || (is_front_page() && get_the_title() === 'Premium Seating')) {
        $breadcrumbs[] = array('label' => 'Products', 'href' => get_post_type_archive_link('product'));
        $breadcrumbs[] = array('label' => 'Premium Seating', 'href' => '');
        return $breadcrumbs;
    }

    // Don't show breadcrumb on regular homepage
    if (is_front_page()) {
        return;
    }

    $breadcrumbs[] = array('label' => 'Home', 'href' => home_url('/'));

    if (is_singular('product')) {
        $breadcrumbs[] = array('label' => 'Products', 'href' => get_post_type_archive_link('product'));
        $breadcrumbs[] = array('label' => get_the_title(), 'href' => '');
    } elseif (is_post_type_archive('product')) {
        $breadcrumbs[] = array('label' => 'Products', 'href' => '');
    } elseif (is_page()) {
        $breadcrumbs[] = array('label' => get_the_title(), 'href' => '');
    }

    return $breadcrumbs;
}
