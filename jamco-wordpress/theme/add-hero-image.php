<?php
/**
 * Add hero image to hero block
 */

$page_id = 5;
$page = get_post($page_id);

$blocks = parse_blocks($page->post_content);

// Find the hero block and add floatingImage attribute
foreach ($blocks as &$block) {
    if ($block['blockName'] === 'jamco/hero') {
        // Add placeholder image ID for now (we'll replace with correct image later)
        // Using one of the existing uploaded images
        $block['attrs']['floatingImage'] = 123; // Using existing image ID

        echo "✅ Added floatingImage to hero block\n";
        echo "   Image ID: 123 (placeholder)\n";
        echo "   Note: This is a placeholder image. Correct image will be added later.\n";
        break;
    }
}

// Update page content
$new_content = serialize_blocks($blocks);
wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

echo "\n✅ Hero block updated!\n";
echo "   View at: http://localhost:8888/\n";
