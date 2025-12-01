<?php
/**
 * Check feature grid data
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

$blocks = parse_blocks($page->post_content);

foreach ($blocks as $block) {
    if ($block['blockName'] === 'jamco/feature-grid') {
        echo "=== Feature Grid Block ===\n\n";
        echo "Attributes:\n";
        print_r($block['attrs']);
        echo "\n\n";

        echo "Rendered:\n";
        echo render_block($block);
        break;
    }
}
