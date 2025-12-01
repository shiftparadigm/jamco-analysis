<?php
/**
 * Add missing blocks to Premium Seating page
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

echo "=== Adding Missing Blocks ===\n\n";

$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

// Find image IDs
global $wpdb;

$seat_view_id = $wpdb->get_var($wpdb->prepare(
    "SELECT post_id FROM $wpdb->postmeta
    WHERE meta_key = '_wp_attached_file'
    AND meta_value LIKE %s
    LIMIT 1",
    '%' . $wpdb->esc_like('seat-view.jpg')
));

$rectangle_5_id = $wpdb->get_var($wpdb->prepare(
    "SELECT post_id FROM $wpdb->postmeta
    WHERE meta_key = '_wp_attached_file'
    AND meta_value LIKE %s
    LIMIT 1",
    '%' . $wpdb->esc_like('Rectangle 5.jpg')
));

echo "Images:\n";
echo "  seat-view.jpg: " . ($seat_view_id ?: 'NOT FOUND') . "\n";
echo "  Rectangle 5.jpg: " . ($rectangle_5_id ?: 'NOT FOUND') . "\n\n";

// Create the 3 missing block comments
$blocks_to_add = [
    '<!-- wp:jamco/product-showcase {"heading":"Premium Seating","subheading":"Showcase every aspect of your journey."} /-->',

    '<!-- wp:jamco/seating-diagram {"diagramImage":' . ($seat_view_id ?: 'null') . '} /-->',

    '<!-- wp:jamco/full-width-image {"image":' . ($rectangle_5_id ?: 'null') . '} /-->'
];

// Parse existing blocks
$blocks = parse_blocks($page->post_content);

// Insert blocks in correct positions
// 1. product-showcase at position 0 (before hero)
// 2. seating-diagram at position 1 (after product-showcase, before hero)
// 3. full-width-image at position 5 (after feature-grid)

$new_blocks = [];

// Add product-showcase
$new_blocks[] = $blocks_to_add[0];

// Add seating-diagram
$new_blocks[] = $blocks_to_add[1];

// Add all existing blocks
foreach ($blocks as $block) {
    if (!empty($block['blockName'])) {
        $new_blocks[] = serialize_block($block);
    }
}

// Now insert full-width-image at position 5 (after feature-grid, which should be at index 4)
// Find the feature-grid block position
$feature_grid_pos = null;
$parsed_new = [];
foreach ($new_blocks as $i => $block_str) {
    $parsed = parse_blocks($block_str);
    if (!empty($parsed[0]['blockName']) && $parsed[0]['blockName'] === 'jamco/feature-grid') {
        $feature_grid_pos = $i;
    }
    $parsed_new[] = $block_str;
}

if ($feature_grid_pos !== null) {
    // Insert full-width-image after feature-grid
    array_splice($parsed_new, $feature_grid_pos + 1, 0, [$blocks_to_add[2]]);
    $new_blocks = $parsed_new;
}

// Combine all blocks
$content = implode("\n\n", $new_blocks);

echo "Adding blocks...\n";
echo "  1. product-showcase (position 0)\n";
echo "  2. seating-diagram (position 1)\n";
echo "  3. full-width-image (after feature-grid)\n\n";

// Update page
$result = wp_update_post([
    'ID' => $page->ID,
    'post_content' => $content,
]);

if (is_wp_error($result)) {
    echo "✗ Error: " . $result->get_error_message() . "\n";
} else {
    echo "✅ Successfully added 3 missing blocks!\n";
    echo "View at: " . get_permalink($page->ID) . "\n";
}
