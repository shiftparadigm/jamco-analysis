<?php
/**
 * Jamco Premium Seating Theme Functions
 */

// Theme setup
function jamco_theme_setup() {
	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'jamco_theme_setup' );

// Enqueue theme assets
function jamco_enqueue_assets() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'jamco-style', get_stylesheet_uri(), array(), '1.0.0' );

	// Enqueue block styles
	wp_enqueue_style( 'jamco-blocks', get_template_directory_uri() . '/assets/css/blocks.css', array(), '1.0.0' );

	// Enqueue main JavaScript
	if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
		wp_enqueue_script( 'jamco-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'jamco_enqueue_assets' );

// Register custom block category
function jamco_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'jamco',
				'title' => 'Jamco Blocks',
				'icon'  => 'airplane',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'jamco_block_category', 10, 1 );

// Enqueue block editor assets
function jamco_enqueue_block_editor_assets() {
	// Ensure WordPress block dependencies are loaded
	wp_enqueue_script( 'wp-blocks' );
	wp_enqueue_script( 'wp-element' );
	wp_enqueue_script( 'wp-block-editor' );
	wp_enqueue_script( 'wp-components' );
	wp_enqueue_script( 'wp-data' );
	wp_enqueue_script( 'wp-i18n' );
	wp_enqueue_script( 'wp-server-side-render' );
	wp_enqueue_script( 'react-jsx-runtime' );

	// Manually enqueue block scripts to ensure they load
	$blocks = array(
		'hero', 'section-intro', 'feature-grid', 'split-feature',
		'product-carousel', 'testimonial', 'cta', 'product-showcase',
		'seating-diagram', 'full-width-image',
	);

	foreach ( $blocks as $block ) {
		$script_handle = 'jamco-' . $block . '-editor-script';
		if ( wp_script_is( $script_handle, 'registered' ) ) {
			wp_enqueue_script( $script_handle );
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'jamco_enqueue_block_editor_assets', 5 );

// Register all Jamco blocks
function jamco_register_blocks() {
	$blocks = array(
		'hero',
		'section-intro',
		'feature-grid',
		'split-feature',
		'product-carousel',
		'testimonial',
		'cta',
		'product-showcase',
		'seating-diagram',
		'full-width-image',
	);

	foreach ( $blocks as $block ) {
		$block_path = get_template_directory() . '/blocks/' . $block;

		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}
add_action( 'init', 'jamco_register_blocks' );

// Register Product custom post type
function jamco_register_product_cpt() {
	$labels = array(
		'name'                  => 'Products',
		'singular_name'         => 'Product',
		'menu_name'             => 'Products',
		'add_new'               => 'Add New',
		'add_new_item'          => 'Add New Product',
		'edit_item'             => 'Edit Product',
		'new_item'              => 'New Product',
		'view_item'             => 'View Product',
		'search_items'          => 'Search Products',
		'not_found'             => 'No products found',
		'not_found_in_trash'    => 'No products found in trash',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'product' ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-products',
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
	);

	register_post_type( 'product', $args );
}
add_action( 'init', 'jamco_register_product_cpt' );

// Add custom image sizes
function jamco_custom_image_sizes() {
	add_image_size( 'hero-image', 800, 600, false );
	add_image_size( 'feature-image', 600, 450, false );
	add_image_size( 'product-thumbnail', 400, 300, true );
}
add_action( 'after_setup_theme', 'jamco_custom_image_sizes' );

// Include test block
require_once get_template_directory() . '/test-block.php';

// Register all blocks with inline scripts
function jamco_register_blocks_inline() {
	// Create ReactJSXRuntime polyfill
	$jsx_polyfill = "
	var createJSXElement = function(type, props, key) {
		var propsToUse = {};
		var children = [];

		for (var k in props) {
			if (k === 'children') {
				var c = props[k];
				if (Array.isArray(c)) {
					children = c;
				} else if (c !== undefined) {
					children = [c];
				}
			} else {
				propsToUse[k] = props[k];
			}
		}

		if (key !== undefined) {
			propsToUse.key = key;
		}

		return window.wp.element.createElement.apply(
			window.wp.element,
			[type, propsToUse].concat(children)
		);
	};

	window.ReactJSXRuntime = {
		jsx: createJSXElement,
		jsxs: createJSXElement,
		Fragment: window.wp.element.Fragment
	};
	";

	wp_add_inline_script( 'wp-element', $jsx_polyfill, 'after' );

	// Load all block scripts inline
	$blocks = array(
		'hero', 'section-intro', 'feature-grid', 'split-feature',
		'product-carousel', 'testimonial', 'cta', 'product-showcase',
		'seating-diagram', 'full-width-image',
	);

	foreach ( $blocks as $block ) {
		$block_js_path = get_template_directory() . '/blocks/' . $block . '/index.js';

		if ( file_exists( $block_js_path ) ) {
			$block_js = file_get_contents( $block_js_path );

			wp_register_script(
				'jamco-' . $block . '-inline',
				false,
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
				'1.0.0'
			);

			wp_add_inline_script( 'jamco-' . $block . '-inline', $block_js );
			wp_enqueue_script( 'jamco-' . $block . '-inline' );
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'jamco_register_blocks_inline', 20 );
