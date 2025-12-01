<?php
/**
 * Debug block structure
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("Page not found\n");
}

$content = get_post_field('post_content', $page->ID);
$blocks = parse_blocks($content);

foreach ($blocks as $index => $block) {
    if (empty($block['blockName'])) continue;

    echo "\n=== Block $index: {$block['blockName']} ===\n";
    echo "Attrs:\n";
    print_r($block['attrs']);
    echo "\nInner Content:\n";
    print_r($block['innerHTML']);
    echo "\n";
}
