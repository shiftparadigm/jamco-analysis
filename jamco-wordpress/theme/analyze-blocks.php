<?php
/**
 * Analyze blocks on page 5 (homepage)
 * Run via: npm run wp-env run cli -- --env-cwd=wp-content/themes/jamco php analyze-blocks.php
 */

// Get page 5 (homepage)
$page = get_post(5);

if (!$page) {
    echo "Page 5 not found!\n";
    exit(1);
}

echo "=== Page: {$page->post_title} (ID: {$page->ID}) ===\n\n";

$blocks = parse_blocks($page->post_content);

echo "Current Block Order:\n";
echo "==================\n\n";

$position = 1;
foreach ($blocks as $block) {
    if (!empty($block['blockName'])) {
        echo "{$position}. {$block['blockName']}\n";

        // Show key attributes
        if (!empty($block['attrs'])) {
            foreach ($block['attrs'] as $key => $value) {
                if ($key === 'heading' || $key === 'title') {
                    $val = is_string($value) ? $value : json_encode($value);
                    echo "   {$key}: " . substr($val, 0, 50) . "\n";
                }
            }
        }
        echo "\n";
        $position++;
    }
}

echo "Total blocks: " . ($position - 1) . "\n";
