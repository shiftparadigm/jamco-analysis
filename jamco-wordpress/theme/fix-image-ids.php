<?php
/**
 * Fix Image IDs in Premium Seating Page
 *
 * Run with: npm run wp-env -- run cli wp eval-file fix-image-ids.php
 */

$page_id = 5;
$page = get_post($page_id);

if (!$page) {
    echo "Page not found!\n";
    exit(1);
}

// Parse blocks
$blocks = parse_blocks($page->post_content);

echo "Fixing image IDs in blocks...\n\n";

foreach ($blocks as &$block) {
    $changed = false;

    // Fix Hero block
    if ($block['blockName'] === 'jamco/hero' && isset($block['attrs']['data'])) {
        if (empty($block['attrs']['data']['floating_image'])) {
            $block['attrs']['data']['floating_image'] = 73;
            echo "✓ Fixed hero floating_image: 73\n";
            $changed = true;
        }
    }

    // Fix Feature Grid
    if ($block['blockName'] === 'jamco/feature-grid' && isset($block['attrs']['data']['features'])) {
        $image_ids = [74, 75, 76];
        foreach ($block['attrs']['data']['features'] as $idx => &$feature) {
            if (empty($feature['image']) && isset($image_ids[$idx])) {
                $feature['image'] = $image_ids[$idx];
                echo "✓ Fixed feature-grid image[$idx]: {$image_ids[$idx]}\n";
                $changed = true;
            }
        }
    }

    // Fix Split Features
    if ($block['blockName'] === 'jamco/split-feature' && isset($block['attrs']['data'])) {
        $heading = $block['attrs']['data']['heading'] ?? '';

        if (empty($block['attrs']['data']['feature_image'])) {
            $image_id = null;

            // Map by heading
            if (strpos($heading, 'Control') !== false) {
                $image_id = 77; // split-1
            } elseif (strpos($heading, 'Private') !== false) {
                $image_id = 78; // split-2
            } elseif (strpos($heading, 'Work and Entertain') !== false) {
                $image_id = 79; // split-3
            } elseif (strpos($heading, 'Spatial') !== false) {
                $image_id = 80; // split-4
            }

            if ($image_id) {
                $block['attrs']['data']['feature_image'] = $image_id;
                echo "✓ Fixed split-feature '$heading': $image_id\n";
                $changed = true;
            }
        }
    }

    // Fix CTA Background
    if ($block['blockName'] === 'jamco/cta' && isset($block['attrs']['data'])) {
        if (empty($block['attrs']['data']['background_image'])) {
            $block['attrs']['data']['background_image'] = 84;
            echo "✓ Fixed CTA background_image: 84\n";
            $changed = true;
        }
    }
}

// Rebuild content
$new_content = serialize_blocks($blocks);

// Update page
wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

echo "\n✅ Page updated successfully!\n";
echo "View at: http://localhost:8888/premium-seating/\n";
