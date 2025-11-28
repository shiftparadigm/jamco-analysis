<?php
/**
 * Populate Premium Seating Page with Content - V2
 * Properly stores ACF block data in post meta
 */

// Image mapping
$theme_dir = get_template_directory();
$images_to_upload = [
    'hero' => $theme_dir . '/exported-images/Placeholder Image.jpg',
    'hero-2' => $theme_dir . '/exported-images/seat-view.jpg',
    'feature-1' => $theme_dir . '/exported-images/Placeholder Image-4.jpg',
    'feature-2' => $theme_dir . '/exported-images/Placeholder Image-5.jpg',
    'feature-3' => $theme_dir . '/exported-images/Rectangle 6.jpg',
    'split-1' => $theme_dir . '/exported-images/Placeholder Image-1.jpg',
    'split-2' => $theme_dir . '/exported-images/Placeholder Image-2.jpg',
    'split-3' => $theme_dir . '/exported-images/Placeholder Image-6.jpg',
    'split-4' => $theme_dir . '/exported-images/Placeholder Image-2 copy.jpg',
    'product-1' => $theme_dir . '/exported-images/Placeholder Image copy.jpg',
    'product-2' => $theme_dir . '/exported-images/Placeholder Image-1 copy.jpg',
    'product-3' => $theme_dir . '/exported-images/Placeholder Image-3.jpg',
    'testimonial-author' => $theme_dir . '/exported-images/maria.png',
    'cta-bg' => $theme_dir . '/exported-images/Placeholder Image-7.jpg',
];

echo "Starting content population (V2 - with post meta)...\n\n";

// Step 1: Upload images (reuse existing if already uploaded)
echo "Step 1: Checking/uploading images...\n";
$uploaded_images = [];

foreach ($images_to_upload as $key => $full_path) {
    if (!file_exists($full_path)) {
        echo "  ⚠ Warning: $key - File not found\n";
        continue;
    }

    $filename = basename($full_path);
    $existing = get_posts([
        'post_type' => 'attachment',
        'meta_key' => '_wp_attached_file',
        'meta_compare' => 'LIKE',
        'meta_value' => $filename,
        'posts_per_page' => 1
    ]);

    if ($existing) {
        $uploaded_images[$key] = $existing[0]->ID;
        echo "  ✓ $key - Using existing (ID: {$existing[0]->ID})\n";
    } else {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_sideload(['name' => $filename, 'tmp_name' => $full_path], 0);

        if (!is_wp_error($attachment_id)) {
            $uploaded_images[$key] = $attachment_id;
            echo "  ✓ $key - Uploaded (ID: $attachment_id)\n";
        }
    }
}

// Step 2: Build page content with simple block markers and store data in post meta
echo "\nStep 2: Building page content...\n";

$page_id = 5;
$content = '';
$meta_data = [];

// Helper function to add ACF block
function add_acf_block($block_name, $fields) {
    global $content, $meta_data;

    $block_id = 'block_' . uniqid();

    // Add block marker to content
    $content .= "<!-- wp:acf/{$block_name} {\"id\":\"{$block_id}\",\"name\":\"acf/{$block_name}\",\"mode\":\"preview\"} /-->\n\n";

    // Store field data in meta
    foreach ($fields as $field_key => $field_value) {
        $meta_key = "_{$block_id}_{$field_key}";
        $meta_data[$meta_key] = $field_value;
        // Also store without underscore for ACF
        $meta_data["{$block_id}_{$field_key}"] = $field_value;
    }
}

// Hero Block
add_acf_block('hero', [
    'heading' => 'Premium Seating',
    'subheading' => 'Experience unparalleled comfort and luxury in our premium seating solutions designed for the modern traveler.',
    'floating_image' => $uploaded_images['hero'] ?? '',
    'primary_cta_text' => 'Explore Products',
    'primary_cta_url' => '#products',
    'secondary_cta_text' => 'Contact Us',
    'secondary_cta_url' => '/contact',
]);

// Section Intro
add_acf_block('section-intro', [
    'eyebrow' => 'PREMIUM FEATURES',
    'heading' => 'Our Premium Seating features',
    'description' => 'Designed with passenger comfort and airline efficiency in mind, our premium seating solutions combine innovative technology with timeless design.',
]);

// Feature Grid
add_acf_block('feature-grid', [
    'features' => 3,
    'features_0_image' => $uploaded_images['feature-1'] ?? '',
    'features_0_heading' => 'Ergonomic Design',
    'features_0_description' => 'Carefully crafted to provide maximum comfort during long flights with adjustable components.',
    'features_1_image' => $uploaded_images['feature-2'] ?? '',
    'features_1_heading' => 'Premium Materials',
    'features_1_description' => 'High-quality materials selected for durability, comfort, and aesthetic appeal.',
    'features_2_image' => $uploaded_images['feature-3'] ?? '',
    'features_2_heading' => 'Smart Integration',
    'features_2_description' => 'Seamlessly integrated entertainment and connectivity features for the modern traveler.',
]);

// Split Features
add_acf_block('split-feature', [
    'heading' => 'Control & Comfort',
    'description' => '<p>Our premium seating puts passengers in complete control of their comfort. Adjust recline, lumbar support, and headrest position with intuitive controls designed for ease of use.</p>',
    'feature_image' => $uploaded_images['split-1'] ?? '',
    'image_position' => 'left',
    'background_color' => 'white',
    'cta_button_text' => 'Learn More',
    'cta_button_url' => '#',
    'cta_button_style' => 'secondary',
]);

add_acf_block('split-feature', [
    'heading' => 'Private by Design',
    'description' => '<p>Create your own sanctuary at 35,000 feet with privacy features that let you work, rest, or relax without distraction.</p>',
    'feature_image' => $uploaded_images['split-2'] ?? '',
    'image_position' => 'right',
    'background_color' => 'blue',
    'cta_button_text' => 'View Details',
    'cta_button_url' => '#',
    'cta_button_style' => 'outline',
]);

add_acf_block('split-feature', [
    'heading' => 'Work and Entertain On-Demand',
    'description' => '<p>Stay productive or entertained with integrated workspace and entertainment features.</p>',
    'feature_image' => $uploaded_images['split-3'] ?? '',
    'image_position' => 'left',
    'background_color' => 'light-blue',
    'cta_button_text' => 'Explore Features',
    'cta_button_url' => '#',
    'cta_button_style' => 'secondary',
]);

add_acf_block('split-feature', [
    'heading' => 'Spatial Freedom',
    'description' => '<p>Generous legroom and clever storage solutions provide the space you need to truly relax.</p>',
    'feature_image' => $uploaded_images['split-4'] ?? '',
    'image_position' => 'right',
    'background_color' => 'white',
    'cta_button_text' => 'See Specifications',
    'cta_button_url' => '#',
    'cta_button_style' => 'secondary',
]);

// Product Carousel
$products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'ID', 'order' => 'ASC']);
$product_ids = array_map(function($p) { return $p->ID; }, $products);

// Set product thumbnails
foreach ($products as $index => $product) {
    $image_key = 'product-' . ($index + 1);
    if (isset($uploaded_images[$image_key])) {
        set_post_thumbnail($product->ID, $uploaded_images[$image_key]);
        echo "  ✓ Set thumbnail for {$product->post_title}\n";
    }
}

add_acf_block('product-carousel', [
    'heading' => 'Related Products',
    'description' => 'Explore our full range of premium seating solutions',
    'label' => 'PRODUCT SHOWCASE',
    'products' => $product_ids,
    'show_pagination' => 1,
]);

// Testimonial
add_acf_block('testimonial', [
    'quote' => 'The premium seating has transformed our passenger experience. Comfort, style, and functionality come together perfectly in these seats.',
    'author_name' => 'Maria Santos',
    'author_title' => 'Head of Cabin Design',
    'author_company' => 'Global Airways',
    'author_image' => $uploaded_images['testimonial-author'] ?? '',
    'background_color' => '#3767AD',
]);

// CTA
add_acf_block('cta', [
    'heading' => 'Ready to elevate your cabin?',
    'subheading' => 'Contact our team to discuss how our premium seating solutions can transform your passenger experience.',
    'background_image' => $uploaded_images['cta-bg'] ?? '',
    'cta_button_text' => 'Get in Touch',
    'cta_button_url' => '/contact',
    'cta_button_style' => 'outline',
]);

// Step 3: Update page
echo "\nStep 3: Updating page content and meta...\n";

wp_update_post([
    'ID' => $page_id,
    'post_content' => $content
]);

// Update all meta fields
foreach ($meta_data as $meta_key => $meta_value) {
    update_post_meta($page_id, $meta_key, $meta_value);
}

echo "✓ Updated page content\n";
echo "✓ Stored " . count($meta_data) . " meta fields\n";
echo "\nDone! View at: http://localhost:8888/\n";
