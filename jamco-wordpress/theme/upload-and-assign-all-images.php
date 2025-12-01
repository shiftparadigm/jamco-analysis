<?php
/**
 * Upload all images from exported-images and assign them to blocks
 */

// Image directory
$image_dir = '/home/tony/projects/jamco-analysis/exported-images';

// Image mapping based on Sanity/Figma reference
$image_assignments = [
    // Hero block
    'hero_floating' => 'Placeholder Image-1.jpg',  // Seat with tray table

    // Product Showcase
    'showcase_image' => 'Placeholder Image.jpg',  // Product image

    // Seating Diagram
    'seating_diagram' => 'seat-view.jpg',

    // Full Width Image
    'full_width' => 'Screenshot 2025-11-05 at 9.52 1.jpg',

    // Split Features
    'split_spatial_freedom' => 'Placeholder Image-2.jpg',
    'split_work_entertain' => 'Placeholder Image-6.jpg',  // Coffee/tablet tray
    'split_enhanced_comfort' => 'Placeholder Image-5.jpg',
    'split_sleek_design' => 'Placeholder Image-3.jpg',

    // Product Carousel
    'product_business_class' => 'Placeholder Image-4.jpg',
    'product_premium_economy' => 'Placeholder Image copy.jpg',
    'product_venturer' => 'Placeholder Image-1 copy.jpg',
    'product_lavatories' => 'Placeholder Image-3 copy.jpg',

    // Testimonial
    'testimonial_author' => 'maria.png',

    // CTA Background
    'cta_background' => 'Placeholder Image-7.jpg',  // Seat from above

    // Feature Grid Icons (SVG, skip for now)
];

echo "=== Uploading Images to WordPress ===\n\n";

$uploaded_images = [];

foreach ($image_assignments as $key => $filename) {
    $filepath = $image_dir . '/' . $filename;

    if (!file_exists($filepath)) {
        echo "❌ File not found: $filename\n";
        continue;
    }

    // Check if already uploaded
    $existing = get_posts([
        'post_type' => 'attachment',
        'meta_query' => [
            [
                'key' => '_wp_attached_file',
                'value' => $filename,
                'compare' => 'LIKE'
            ]
        ]
    ]);

    if (!empty($existing)) {
        $uploaded_images[$key] = $existing[0]->ID;
        echo "✓ Already exists: $filename (ID: {$existing[0]->ID})\n";
        continue;
    }

    // Upload new image
    $upload = wp_upload_bits($filename, null, file_get_contents($filepath));

    if ($upload['error']) {
        echo "❌ Error uploading $filename: {$upload['error']}\n";
        continue;
    }

    // Create attachment
    $attachment = [
        'post_mime_type' => $upload['type'],
        'post_title' => pathinfo($filename, PATHINFO_FILENAME),
        'post_content' => '',
        'post_status' => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $upload['file']);

    // Generate metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);

    $uploaded_images[$key] = $attach_id;
    echo "✅ Uploaded: $filename (ID: $attach_id)\n";
}

echo "\n=== Assigning Images to Blocks ===\n\n";

// Get page blocks
$page_id = 5;
$page = get_post($page_id);
$blocks = parse_blocks($page->post_content);

// Update blocks with correct images
foreach ($blocks as &$block) {
    $block_name = str_replace('jamco/', '', $block['blockName']);

    switch ($block_name) {
        case 'hero':
            if (isset($uploaded_images['hero_floating'])) {
                $block['attrs']['floatingImage'] = $uploaded_images['hero_floating'];
                echo "✅ Hero: Set floating image\n";
            }
            break;

        case 'product-showcase':
            if (isset($uploaded_images['showcase_image'])) {
                $block['attrs']['showcaseImage'] = $uploaded_images['showcase_image'];
                echo "✅ Product Showcase: Set image\n";
            }
            break;

        case 'seating-diagram':
            if (isset($uploaded_images['seating_diagram'])) {
                $block['attrs']['diagramImage'] = $uploaded_images['seating_diagram'];
                echo "✅ Seating Diagram: Set image\n";
            }
            break;

        case 'full-width-image':
            if (isset($uploaded_images['full_width'])) {
                $block['attrs']['image'] = $uploaded_images['full_width'];
                echo "✅ Full Width Image: Set image\n";
            }
            break;

        case 'split-feature':
            $heading = $block['attrs']['heading'] ?? '';
            $image_key = null;

            if (strpos($heading, 'Spatial Freedom') !== false) {
                $image_key = 'split_spatial_freedom';
            } elseif (strpos($heading, 'Work and Entertain') !== false) {
                $image_key = 'split_work_entertain';
            } elseif (strpos($heading, 'Enhanced Comfort') !== false) {
                $image_key = 'split_enhanced_comfort';
            } elseif (strpos($heading, 'Sleek') !== false || strpos($heading, 'Modern Design') !== false) {
                $image_key = 'split_sleek_design';
            }

            if ($image_key && isset($uploaded_images[$image_key])) {
                $block['attrs']['featureImage'] = $uploaded_images[$image_key];
                echo "✅ Split Feature ($heading): Set image\n";
            }
            break;

        case 'testimonial':
            if (isset($uploaded_images['testimonial_author'])) {
                $block['attrs']['authorImage'] = $uploaded_images['testimonial_author'];
                echo "✅ Testimonial: Set author image\n";
            }
            break;

        case 'cta':
            if (isset($uploaded_images['cta_background'])) {
                $block['attrs']['backgroundImage'] = $uploaded_images['cta_background'];
                echo "✅ CTA: Set background image\n";
            }
            break;
    }
}

// Update page with new block data
$new_content = serialize_blocks($blocks);
wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

echo "\n✅ All images uploaded and assigned!\n";
echo "   Total images: " . count($uploaded_images) . "\n";
echo "   View at: http://localhost:8888/\n";
