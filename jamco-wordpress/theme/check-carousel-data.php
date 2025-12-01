<?php
/**
 * Check product carousel data
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

$blocks = parse_blocks($page->post_content);

foreach ($blocks as $block) {
    if ($block['blockName'] === 'jamco/product-carousel') {
        echo "=== Product Carousel Block ===\n\n";
        echo "Block attributes:\n";
        print_r($block['attrs']);
        echo "\n\nBlock innerHTML:\n";
        echo $block['innerHTML'];
        echo "\n\n";

        // Try to render the block
        echo "=== Rendered Output ===\n";
        echo render_block($block);
        break;
    }
}
