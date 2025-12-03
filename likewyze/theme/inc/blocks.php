<?php
/**
 * Register Custom Gutenberg Blocks
 *
 * @package Likewize
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all custom blocks
 */
function likewize_register_blocks() {
    // Get list of block directories
    $blocks = array(
        'hero',
        'feature-grid',
        'process-steps',
        'pricing-table',
        'faq-accordion',
    );

    // Register each block
    foreach ($blocks as $block) {
        $block_path = get_template_directory() . '/blocks/' . $block;

        if (file_exists($block_path . '/block.json')) {
            register_block_type($block_path);
        }
    }
}
add_action('init', 'likewize_register_blocks');

/**
 * Enqueue block editor assets
 */
function likewize_enqueue_block_editor_assets() {
    // Enqueue fonts in editor
    wp_enqueue_style(
        'likewize-google-fonts',
        'https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&display=swap',
        array(),
        null
    );

    // Enqueue Lucide icons in editor
    wp_enqueue_script(
        'lucide-icons',
        'https://unpkg.com/lucide@latest',
        array(),
        null,
        false
    );

    // Common block editor styles
    wp_enqueue_style(
        'likewize-editor-styles',
        get_template_directory_uri() . '/blocks/editor-common.css',
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('enqueue_block_editor_assets', 'likewize_enqueue_block_editor_assets');

/**
 * Add custom block categories
 */
function likewize_block_categories($categories) {
    return array_merge(
        array(
            array(
                'slug'  => 'likewize',
                'title' => __('Likewize Blocks', 'likewize'),
                'icon'  => 'shield-alt',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'likewize_block_categories', 10, 1);
