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

// Register Jamco Blocks (using WordPress core block API)
function jamco_register_blocks() {
    // Helper function to render block templates
    $render_block = function($block_name) {
        return function($attributes, $content, $block) use ($block_name) {
            $template_path = get_template_directory() . "/blocks/{$block_name}.php";
            if (file_exists($template_path)) {
                ob_start();
                // Make block attributes available
                $block_attributes = $attributes;
                $block_id = $block->context['blockId'] ?? uniqid('block_');
                include $template_path;
                return ob_get_clean();
            }
            return '';
        };
    };

    // Hero Block
    register_block_type('jamco/hero', array(
        'title'           => __('Hero Section', 'jamco'),
        'description'     => __('Hero section with heading, image, and CTAs', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'cover-image',
        'keywords'        => array('hero', 'banner', 'header'),
        'supports'        => array('align' => false),
        'attributes'      => array(
            'data' => array('type' => 'object'),
        ),
        'render_callback' => $render_block('hero'),
    ));

    // Section Intro Block
    register_block_type('jamco/section-intro', array(
        'title'           => __('Section Intro', 'jamco'),
        'description'     => __('Introduction section with eyebrow, heading, and description', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'editor-textcolor',
        'keywords'        => array('section', 'intro', 'heading'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('section-intro'),
    ));

    // Feature Grid Block
    register_block_type('jamco/feature-grid', array(
        'title'           => __('Feature Grid', 'jamco'),
        'description'     => __('3-column feature grid with images', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'grid-view',
        'keywords'        => array('features', 'grid', 'columns'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('feature-grid'),
    ));

    // Split Feature Block
    register_block_type('jamco/split-feature', array(
        'title'           => __('Split Feature', 'jamco'),
        'description'     => __('Feature section with image and content split', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'columns',
        'keywords'        => array('split', 'feature', 'image'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('split-feature'),
    ));

    // Product Carousel Block
    register_block_type('jamco/product-carousel', array(
        'title'           => __('Product Carousel', 'jamco'),
        'description'     => __('Carousel of related products', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'images-alt2',
        'keywords'        => array('products', 'carousel', 'slider'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('product-carousel'),
    ));

    // Testimonial Block
    register_block_type('jamco/testimonial', array(
        'title'           => __('Testimonial', 'jamco'),
        'description'     => __('Customer testimonial with quote and author', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'format-quote',
        'keywords'        => array('testimonial', 'quote', 'review'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('testimonial'),
    ));

    // CTA Block
    register_block_type('jamco/cta', array(
        'title'           => __('Call to Action', 'jamco'),
        'description'     => __('Call to action section with background image', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'megaphone',
        'keywords'        => array('cta', 'call to action', 'button'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('cta'),
    ));

    // Product Showcase Block
    register_block_type('jamco/product-showcase', array(
        'title'           => __('Product Showcase', 'jamco'),
        'description'     => __('Full-width product showcase with branding', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'star-filled',
        'keywords'        => array('product', 'showcase', 'hero'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('product-showcase'),
    ));

    // Seating Diagram Block
    register_block_type('jamco/seating-diagram', array(
        'title'           => __('Seating Diagram', 'jamco'),
        'description'     => __('Cabin seating layout diagram', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'grid-view',
        'keywords'        => array('diagram', 'seating', 'layout'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('seating-diagram'),
    ));

    // Full Width Image Block
    register_block_type('jamco/full-width-image', array(
        'title'           => __('Full Width Image', 'jamco'),
        'description'     => __('Full-width image section', 'jamco'),
        'category'        => 'jamco',
        'icon'            => 'format-image',
        'keywords'        => array('image', 'full-width', 'photo'),
        'attributes'      => array('data' => array('type' => 'object')),
        'render_callback' => $render_block('full-width-image'),
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
