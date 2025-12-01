<?php
/**
 * Get current page blocks and their order
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Find the page (it might be the homepage or a page called "Premium Seating")
$pages = get_posts([
    'post_type' => 'page',
    'posts_per_page' => -1
]);

echo "=== Available Pages ===\n";
foreach ($pages as $page) {
    echo "ID: {$page->ID} - {$page->post_title} (slug: {$page->post_name})\n";
}

echo "\n=== Checking Homepage ===\n";
$homepage_id = get_option('page_on_front');
if ($homepage_id) {
    echo "Homepage ID: $homepage_id\n";
    $page = get_post($homepage_id);
} else {
    // Get first page or look for "Premium Seating"
    $page = get_page_by_title('Premium Seating');
    if (!$page && !empty($pages)) {
        $page = $pages[0];
    }
}

if (!$page) {
    die("No page found!\n");
}

echo "\nAnalyzing Page: {$page->post_title} (ID: {$page->ID})\n\n";

$blocks = parse_blocks($page->post_content);

echo "=== Current Block Order ===\n";
$position = 1;
foreach ($blocks as $block) {
    if (!empty($block['blockName'])) {
        $blockName = $block['blockName'];
        $attrs = !empty($block['attrs']) ? json_encode($block['attrs'], JSON_PRETTY_PRINT) : '{}';

        echo "\n{$position}. {$blockName}\n";
        echo "   Attributes: " . (strlen($attrs) > 100 ? substr($attrs, 0, 100) . '...' : $attrs) . "\n";

        $position++;
    }
}

echo "\n=== Total Blocks: " . ($position - 1) . " ===\n";
