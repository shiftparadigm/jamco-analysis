<?php
/**
 * Auto-assign images to ACF blocks on Premium Seating page
 *
 * Run this file by visiting: http://localhost:8888/wp-content/themes/jamco/assign-block-images.php
 * Or via WP-CLI: wp eval-file assign-block-images.php
 */

// Load WordPress
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Helper function to find attachment ID by filename
function find_attachment_by_filename($filename) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_name LIKE %s LIMIT 1",
        '%' . sanitize_title($filename) . '%'
    ));
    return !empty($attachment) ? $attachment[0] : null;
}

// Helper function to find existing image
function find_image($filename) {
    $attachment_id = find_attachment_by_filename($filename);

    if ($attachment_id) {
        echo "✓ Found: $filename (ID: $attachment_id)\n";
        return $attachment_id;
    }

    echo "✗ Not found in media library: $filename\n";
    return null;
}

echo "=== JAMCO Image Assignment Script ===\n\n";

// Define image sources
$image_source_dir = '/home/tony/projects/jamco-analysis/exported-images/';

// Get the Premium Seating page
$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("✗ Error: Premium Seating page not found!\n");
}
echo "✓ Found page: {$page->post_title} (ID: {$page->ID})\n\n";

// Find images in media library
echo "Step 1: Finding images in WordPress media library...\n";
$images = array(
    'hero_floating' => find_image('Placeholder Image-1'),
    'spatial_freedom' => find_image('Placeholder Image-2'),
    'designed_comfort' => find_image('Placeholder Image-5'),
    'work_entertain' => find_image('Placeholder Image-6'),
    'product_1' => find_image('Placeholder Image'),
    'product_2' => find_image('Placeholder Image copy'),
    'product_3' => find_image('Placeholder Image-3'),
    'product_4' => find_image('Placeholder Image-4'),
    'lavatory' => find_image('Placeholder Image-3 copy'),
    'testimonial_author' => find_image('maria'),
    'cta_background' => find_image('Placeholder Image-7'),
    'seating_diagram' => find_image('seat-view'),
);

echo "\n";

// Get current blocks content
$content = get_post_field('post_content', $page->ID);
$blocks = parse_blocks($content);

echo "Step 2: Updating blocks with images...\n";
$updated_blocks = array();
$block_index = 0;

foreach ($blocks as $block) {
    $block_name = $block['blockName'];
    $attrs = $block['attrs'];

    // Skip empty blocks
    if (empty($block_name)) {
        $updated_blocks[] = $block;
        continue;
    }

    echo "\nProcessing: $block_name (index: $block_index)\n";

    switch ($block_name) {
        case 'jamco/hero':
            if ($images['hero_floating']) {
                $attrs['floatingImage'] = $images['hero_floating'];
                echo "  → Assigned hero floating image\n";
            }
            break;

        case 'jamco/split-feature':
            // Determine which split feature this is by heading
            $heading = isset($attrs['heading']) ? $attrs['heading'] : '';

            if (stripos($heading, 'Spatial Freedom') !== false && $images['spatial_freedom']) {
                $attrs['featureImage'] = $images['spatial_freedom'];
                $attrs['backgroundColor'] = 'white';
                $attrs['imagePosition'] = 'right';
                echo "  → Assigned Spatial Freedom image\n";
            } elseif (stripos($heading, 'Designed for Comfort') !== false && $images['designed_comfort']) {
                $attrs['featureImage'] = $images['designed_comfort'];
                $attrs['backgroundColor'] = 'light-blue';
                $attrs['imagePosition'] = 'left';
                echo "  → Assigned Designed for Comfort image\n";
            } elseif (stripos($heading, 'Work and Entertain') !== false && $images['work_entertain']) {
                $attrs['featureImage'] = $images['work_entertain'];
                $attrs['backgroundColor'] = 'light-blue';
                $attrs['imagePosition'] = 'left';
                echo "  → Assigned Work and Entertain image\n";
            } elseif (stripos($heading, 'Sleek') !== false && $images['designed_comfort']) {
                $attrs['featureImage'] = $images['designed_comfort'];
                // Keep existing backgroundColor = 'blue'
                $attrs['imagePosition'] = 'right';
                echo "  → Assigned Sleek Modern Design image\n";
            }
            break;

        case 'jamco/testimonial':
            if ($images['testimonial_author']) {
                $attrs['authorImage'] = $images['testimonial_author'];
                echo "  → Assigned testimonial author image\n";
            }
            break;

        case 'jamco/cta':
            if ($images['cta_background']) {
                $attrs['backgroundImage'] = $images['cta_background'];
                echo "  → Assigned CTA background image\n";
            }
            break;

        case 'jamco/seating-diagram':
            if ($images['seating_diagram']) {
                $attrs['diagramImage'] = $images['seating_diagram'];
                echo "  → Assigned seating diagram image\n";
            }
            break;
    }

    $block['attrs'] = $attrs;
    $updated_blocks[] = $block;
    $block_index++;
}

// Save updated blocks
$new_content = serialize_blocks($updated_blocks);
$result = wp_update_post(array(
    'ID' => $page->ID,
    'post_content' => $new_content
));

if ($result) {
    echo "\n✓ SUCCESS! Page updated with all images.\n";
    echo "\nView at: http://localhost:8888/premium-seating/\n";
} else {
    echo "\n✗ ERROR: Failed to update page.\n";
}

echo "\n=== Done ===\n";
