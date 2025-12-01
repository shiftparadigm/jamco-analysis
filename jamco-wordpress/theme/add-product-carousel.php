<?php
/**
 * Add products to the product carousel block
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

echo "=== Adding Products to Carousel ===\n\n";

// Get the Premium Seating page
$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

// Use hardcoded image IDs from recent upload
$image_ids = [
    'flight_deck' => 123,
    'dividers' => 124,
    'closets' => 125,
    'lavatories' => 126,
];

echo "Using image IDs:\n";
foreach ($image_ids as $key => $id) {
    $title = get_the_title($id);
    echo "  $key: $title (ID: $id)\n";
}

// Define products
$products = [
    [
        'name' => 'Flight Deck Doors and Linings',
        'image' => $image_ids['flight_deck'] ?? null,
        'link' => '#flight-deck-doors'
    ],
    [
        'name' => 'Dividers & Partitions',
        'image' => $image_ids['dividers'] ?? null,
        'link' => '#dividers-partitions'
    ],
    [
        'name' => 'Closets & Stowage',
        'image' => $image_ids['closets'] ?? null,
        'link' => '#closets-stowage'
    ],
    [
        'name' => 'Lavatories',
        'image' => $image_ids['lavatories'] ?? null,
        'link' => '#lavatories'
    ],
];

// Parse blocks
$blocks = parse_blocks($page->post_content);
$updated = false;

foreach ($blocks as &$block) {
    if ($block['blockName'] === 'jamco/product-carousel') {
        echo "\n✓ Found product carousel block\n";

        // Update attributes
        $block['attrs']['products'] = $products;
        $block['attrs']['heading'] = 'Related Products';

        // Rebuild the block comment
        $attrs_json = json_encode($block['attrs']);
        $block['innerHTML'] = "<!-- wp:jamco/product-carousel $attrs_json /-->";

        $updated = true;
        echo "✓ Added " . count($products) . " products to carousel\n";
        break;
    }
}

if ($updated) {
    // Serialize blocks back to content
    $content = serialize_blocks($blocks);

    // Update page
    $result = wp_update_post([
        'ID' => $page->ID,
        'post_content' => $content,
    ]);

    if (is_wp_error($result)) {
        echo "\n✗ Error updating page: " . $result->get_error_message() . "\n";
    } else {
        echo "\n✅ Successfully updated product carousel!\n";
        echo "View at: " . get_permalink($page->ID) . "\n";
    }
} else {
    echo "\n✗ Product carousel block not found\n";
}
