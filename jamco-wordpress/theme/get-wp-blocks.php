<?php
// Get the homepage blocks
$page = get_post(get_option('page_on_front'));
if (!$page) {
    // Try to find Premium Seating page
    $pages = get_posts([
        'post_type' => 'page',
        'posts_per_page' => -1
    ]);
    foreach ($pages as $p) {
        echo "Page: {$p->post_title} (ID: {$p->ID})\n";
    }
    exit;
}

$blocks = parse_blocks($page->post_content);
echo "Total blocks: " . count($blocks) . "\n\n";

foreach ($blocks as $i => $block) {
    if (empty($block['blockName'])) continue;

    echo "Block $i: {$block['blockName']}\n";

    // Show key attributes
    if (!empty($block['attrs'])) {
        $attrs = $block['attrs'];
        if (isset($attrs['heading'])) echo "  Heading: {$attrs['heading']}\n";
        if (isset($attrs['backgroundColor'])) echo "  Background: {$attrs['backgroundColor']}\n";
    }
    echo "\n";
}
