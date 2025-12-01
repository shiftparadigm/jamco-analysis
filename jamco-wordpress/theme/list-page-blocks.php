<?php
/**
 * List all blocks on the Premium Seating page
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

echo "=== Blocks on Premium Seating Page ===\n\n";

$blocks = parse_blocks($page->post_content);
$block_num = 0;

foreach ($blocks as $block) {
    if (empty($block['blockName'])) {
        continue;
    }

    $block_num++;
    echo "$block_num. {$block['blockName']}\n";

    // Show key attributes
    if (!empty($block['attrs'])) {
        if (isset($block['attrs']['data']['heading'])) {
            echo "   Heading: {$block['attrs']['data']['heading']}\n";
        } elseif (isset($block['attrs']['heading'])) {
            echo "   Heading: {$block['attrs']['heading']}\n";
        }

        if (isset($block['attrs']['data']['title'])) {
            echo "   Title: {$block['attrs']['data']['title']}\n";
        } elseif (isset($block['attrs']['title'])) {
            echo "   Title: {$block['attrs']['title']}\n";
        }
    }

    echo "\n";
}

echo "\nTotal blocks: $block_num\n";
