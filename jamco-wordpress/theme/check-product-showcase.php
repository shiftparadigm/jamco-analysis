<?php
/**
 * Check product showcase block content
 */

$page = get_post(5);
$blocks = parse_blocks($page->post_content);

foreach ($blocks as $block) {
    if ($block['blockName'] === 'jamco/product-showcase') {
        echo "=== Product Showcase Block ===\n\n";
        echo "Attributes:\n";
        print_r($block['attrs']);
        echo "\n";
        break;
    }
}
