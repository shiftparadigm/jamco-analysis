<?php
/**
 * Assign correct image IDs to all blocks
 */

// Image ID mapping (from list-uploaded-images.php output)
$image_ids = [
    'hero_floating' => 14,          // Placeholder-Image-1.jpg
    'showcase_image' => 9,          // Placeholder-Image.jpg
    'seating_diagram' => 10,        // seat-view.jpg
    'full_width' => 106,            // Screenshot-2025-11-05-at-9.52-1.jpg
    'split_spatial_freedom' => 15,  // Placeholder-Image-2.jpg
    'split_work_entertain' => 16,   // Placeholder-Image-6.jpg
    'split_enhanced_comfort' => 12, // Placeholder-Image-5.jpg
    'split_sleek_design' => 20,     // Placeholder-Image-3.jpg
    'product_business_class' => 11, // Placeholder-Image-4.jpg
    'product_premium_economy' => 18, // Placeholder-Image-copy.jpg
    'product_venturer' => 19,       // Placeholder-Image-1-copy.jpg
    'product_lavatories' => 126,    // Placeholder-Image-3-copy.jpg
    'testimonial_author' => 21,     // maria.png
    'cta_background' => 22,         // Placeholder-Image-7.jpg
];

echo "=== Assigning Images to Blocks ===\n\n";

// Get page blocks
$page_id = 5;
$page = get_post($page_id);
$blocks = parse_blocks($page->post_content);

$updates = 0;

// Update blocks with correct images
foreach ($blocks as &$block) {
    if (empty($block['blockName'])) continue;

    $block_name = str_replace('jamco/', '', $block['blockName']);

    switch ($block_name) {
        case 'hero':
            $block['attrs']['floatingImage'] = $image_ids['hero_floating'];
            echo "✅ Hero: Set floating image (ID: {$image_ids['hero_floating']})\n";
            $updates++;
            break;

        case 'product-showcase':
            $block['attrs']['showcaseImage'] = $image_ids['showcase_image'];
            echo "✅ Product Showcase: Set image (ID: {$image_ids['showcase_image']})\n";
            $updates++;
            break;

        case 'seating-diagram':
            $block['attrs']['diagramImage'] = $image_ids['seating_diagram'];
            echo "✅ Seating Diagram: Set image (ID: {$image_ids['seating_diagram']})\n";
            $updates++;
            break;

        case 'full-width-image':
            $block['attrs']['image'] = $image_ids['full_width'];
            echo "✅ Full Width Image: Set image (ID: {$image_ids['full_width']})\n";
            $updates++;
            break;

        case 'split-feature':
            $heading = $block['attrs']['heading'] ?? '';
            $image_id = null;

            if (strpos($heading, 'Spatial Freedom') !== false) {
                $image_id = $image_ids['split_spatial_freedom'];
                $label = 'Spatial Freedom';
            } elseif (strpos($heading, 'Work and Entertain') !== false) {
                $image_id = $image_ids['split_work_entertain'];
                $label = 'Work and Entertain';
            } elseif (strpos($heading, 'Enhanced Comfort') !== false) {
                $image_id = $image_ids['split_enhanced_comfort'];
                $label = 'Enhanced Comfort';
            } elseif (strpos($heading, 'Sleek') !== false || strpos($heading, 'Modern Design') !== false) {
                $image_id = $image_ids['split_sleek_design'];
                $label = 'Sleek Design';
            }

            if ($image_id) {
                $block['attrs']['featureImage'] = $image_id;
                echo "✅ Split Feature ($label): Set image (ID: $image_id)\n";
                $updates++;
            }
            break;

        case 'testimonial':
            $block['attrs']['authorImage'] = $image_ids['testimonial_author'];
            echo "✅ Testimonial: Set author image (ID: {$image_ids['testimonial_author']})\n";
            $updates++;
            break;

        case 'cta':
            $block['attrs']['backgroundImage'] = $image_ids['cta_background'];
            echo "✅ CTA: Set background image (ID: {$image_ids['cta_background']})\n";
            $updates++;
            break;
    }
}

// Update page with new block data
$new_content = serialize_blocks($blocks);
wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

echo "\n✅ All images assigned to blocks!\n";
echo "   Total updates: $updates\n";
echo "   View at: http://localhost:8888/\n";
