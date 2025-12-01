<?php
/**
 * Fix the product carousel block with the correct attributes
 */

require_once('/var/www/html/wp-load.php');

// Get the Premium Seating page
$page_id = 5;

// Get current content
$content = get_post_field('post_content', $page_id);

// Find and replace the product-carousel block
$old_block = '<!-- wp:jamco/product-carousel {"title":"Complete your travel ecosystem"} /-->';

$new_block = '<!-- wp:jamco/product-carousel {' .
    '"heading":"Complete your travel ecosystem",' .
    '"description":"Elevate every aspect of your journey.",' .
    '"label":"Related Products",' .
    '"productRefs":["product-flight-deck-doors","product-dividers-partitions","product-closets-stowage","product-lavatories"]' .
    '} /-->';

$updated_content = str_replace($old_block, $new_block, $content);

if ($content !== $updated_content) {
    // Update the post
    wp_update_post([
        'ID' => $page_id,
        'post_content' => $updated_content
    ]);

    echo "✅ Product carousel block updated successfully!\n";
    echo "Attributes added:\n";
    echo "  - heading: Complete your travel ecosystem\n";
    echo "  - description: Elevate every aspect of your journey.\n";
    echo "  - label: Related Products\n";
    echo "  - productRefs: 4 products\n";
} else {
    echo "❌ Block not found or already updated\n";
}
