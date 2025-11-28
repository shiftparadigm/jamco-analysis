<?php
/**
 * Populate Premium Seating Page with ACF Blocks
 * Uses ACF's update_field() to properly populate block data
 *
 * Run with: cd jamco-wordpress && npm run wp-env -- run cli wp eval-file theme/populate-acf-blocks.php
 */

echo "Starting content population with ACF blocks...\n\n";

// Step 1: Upload images to WordPress media library
echo "Step 1: Uploading images to media library...\n";

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
    'product-showcase' => $theme_dir . '/exported-images/Rectangle 5.jpg',
    'seating-diagram' => $theme_dir . '/exported-images/Screenshot 2025-11-05 at 9.52 1.jpg',
    'full-width-image' => $theme_dir . '/exported-images/Rectangle 5.jpg',
];

$uploaded_images = [];

foreach ($images_to_upload as $key => $full_path) {
    if (!file_exists($full_path)) {
        echo "  Warning: $key - File not found: $full_path\n";
        continue;
    }

    // Check if already uploaded
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
        echo "  ✓ $key - Already exists (ID: {$existing[0]->ID})\n";
        continue;
    }

    // Upload new image
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $file_array = [
        'name' => $filename,
        'tmp_name' => $full_path
    ];

    $attachment_id = media_handle_sideload($file_array, 0);

    if (is_wp_error($attachment_id)) {
        echo "  ✗ $key - Upload failed: " . $attachment_id->get_error_message() . "\n";
        continue;
    }

    $uploaded_images[$key] = $attachment_id;
    echo "  ✓ $key - Uploaded successfully (ID: $attachment_id)\n";
}

echo "\n";

// Step 2: Create/get Premium Seating page
echo "Step 2: Creating/updating Premium Seating page...\n";

$page = get_page_by_path('premium-seating', OBJECT, 'page');
$page_id = $page ? $page->ID : 5;

echo "  Page ID: $page_id\n\n";

// Step 3: Build ACF blocks
echo "Step 3: Building page content with ACF blocks...\n";

$blocks_content = '';
$block_ids = [];

// Helper function to generate block ID
function generate_block_id() {
    return 'block_' . wp_generate_password(13, false);
}

// Hero Block
echo "  Creating Hero block...\n";
$hero_block_id = generate_block_id();
$block_ids['hero'] = $hero_block_id;
$blocks_content .= '<!-- wp:acf/hero {"id":"' . $hero_block_id . '","name":"acf/hero","data":{},"mode":"preview"} /-->' . "\n\n";

// Product Showcase Block
echo "  Creating Product Showcase block...\n";
$product_showcase_block_id = generate_block_id();
$block_ids['product_showcase'] = $product_showcase_block_id;
$blocks_content .= '<!-- wp:acf/product-showcase {"id":"' . $product_showcase_block_id . '","name":"acf/product-showcase","data":{},"mode":"preview"} /-->' . "\n\n";

// Seating Diagram Block
echo "  Creating Seating Diagram block...\n";
$seating_diagram_block_id = generate_block_id();
$block_ids['seating_diagram'] = $seating_diagram_block_id;
$blocks_content .= '<!-- wp:acf/seating-diagram {"id":"' . $seating_diagram_block_id . '","name":"acf/seating-diagram","data":{},"mode":"preview"} /-->' . "\n\n";

// Section Intro Block
echo "  Creating Section Intro block...\n";
$section_intro_block_id = generate_block_id();
$block_ids['section_intro'] = $section_intro_block_id;
$blocks_content .= '<!-- wp:acf/section-intro {"id":"' . $section_intro_block_id . '","name":"acf/section-intro","data":{},"mode":"preview"} /-->' . "\n\n";

// Feature Grid Block
echo "  Creating Feature Grid block...\n";
$feature_grid_block_id = generate_block_id();
$block_ids['feature_grid'] = $feature_grid_block_id;
$blocks_content .= '<!-- wp:acf/feature-grid {"id":"' . $feature_grid_block_id . '","name":"acf/feature-grid","data":{},"mode":"preview"} /-->' . "\n\n";

// Full Width Image Block
echo "  Creating Full Width Image block...\n";
$full_width_image_block_id = generate_block_id();
$block_ids['full_width_image'] = $full_width_image_block_id;
$blocks_content .= '<!-- wp:acf/full-width-image {"id":"' . $full_width_image_block_id . '","name":"acf/full-width-image","data":{},"mode":"preview"} /-->' . "\n\n";

// Split Feature 1 - Control & Comfort
echo "  Creating Split Feature 1 block...\n";
$split_1_block_id = generate_block_id();
$block_ids['split_1'] = $split_1_block_id;
$blocks_content .= '<!-- wp:acf/split-feature {"id":"' . $split_1_block_id . '","name":"acf/split-feature","data":{},"mode":"preview"} /-->' . "\n\n";

// Split Feature 2 - Private by Design
echo "  Creating Split Feature 2 block...\n";
$split_2_block_id = generate_block_id();
$block_ids['split_2'] = $split_2_block_id;
$blocks_content .= '<!-- wp:acf/split-feature {"id":"' . $split_2_block_id . '","name":"acf/split-feature","data":{},"mode":"preview"} /-->' . "\n\n";

// Split Feature 3 - Work and Entertain
echo "  Creating Split Feature 3 block...\n";
$split_3_block_id = generate_block_id();
$block_ids['split_3'] = $split_3_block_id;
$blocks_content .= '<!-- wp:acf/split-feature {"id":"' . $split_3_block_id . '","name":"acf/split-feature","data":{},"mode":"preview"} /-->' . "\n\n";

// Split Feature 4 - Spatial Freedom
echo "  Creating Split Feature 4 block...\n";
$split_4_block_id = generate_block_id();
$block_ids['split_4'] = $split_4_block_id;
$blocks_content .= '<!-- wp:acf/split-feature {"id":"' . $split_4_block_id . '","name":"acf/split-feature","data":{},"mode":"preview"} /-->' . "\n\n";

// Product Carousel Block
echo "  Creating Product Carousel block...\n";
$product_carousel_block_id = generate_block_id();
$block_ids['product_carousel'] = $product_carousel_block_id;
$blocks_content .= '<!-- wp:acf/product-carousel {"id":"' . $product_carousel_block_id . '","name":"acf/product-carousel","data":{},"mode":"preview"} /-->' . "\n\n";

// Testimonial Block
echo "  Creating Testimonial block...\n";
$testimonial_block_id = generate_block_id();
$block_ids['testimonial'] = $testimonial_block_id;
$blocks_content .= '<!-- wp:acf/testimonial {"id":"' . $testimonial_block_id . '","name":"acf/testimonial","data":{},"mode":"preview"} /-->' . "\n\n";

// CTA Block
echo "  Creating CTA block...\n";
$cta_block_id = generate_block_id();
$block_ids['cta'] = $cta_block_id;
$blocks_content .= '<!-- wp:acf/cta {"id":"' . $cta_block_id . '","name":"acf/cta","data":{},"mode":"preview"} /-->' . "\n\n";

// Step 4: Update page content
echo "\nStep 4: Updating page content...\n";
wp_update_post([
    'ID' => $page_id,
    'post_content' => $blocks_content
]);
echo "  ✓ Page content updated\n\n";

// Step 5: Populate block fields using update_field()
echo "Step 5: Populating block fields with update_field()...\n";

// Hero Block Fields
echo "  Populating Hero block fields...\n";
update_field('heading', 'Jamco Premium Seating', 'block_' . $block_ids['hero']);
update_field('subheading', 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control', 'block_' . $block_ids['hero']);
if (isset($uploaded_images['hero'])) {
    update_field('floating_image', $uploaded_images['hero'], 'block_' . $block_ids['hero']);
}
update_field('primary_cta', [
    'text' => 'Explore Products',
    'url' => '#products'
], 'block_' . $block_ids['hero']);
update_field('secondary_cta', [
    'text' => 'Contact Us',
    'url' => '/contact'
], 'block_' . $block_ids['hero']);

// Product Showcase Block Fields
echo "  Populating Product Showcase block fields...\n";
update_field('heading', 'Premium Seating', 'block_' . $block_ids['product_showcase']);
update_field('subheading', 'Showcase every aspect of your journey.', 'block_' . $block_ids['product_showcase']);
update_field('brand_name', 'Venture', 'block_' . $block_ids['product_showcase']);
update_field('brand_description', 'Direct aisle access, premium density, and curated surfaces for a calm, private environment—ready to scale across your fleet.', 'block_' . $block_ids['product_showcase']);
if (isset($uploaded_images['product-showcase'])) {
    update_field('product_image', $uploaded_images['product-showcase'], 'block_' . $block_ids['product_showcase']);
}

// Seating Diagram Block Fields
echo "  Populating Seating Diagram block fields...\n";
if (isset($uploaded_images['seating-diagram'])) {
    update_field('diagram_image', $uploaded_images['seating-diagram'], 'block_' . $block_ids['seating_diagram']);
}
update_field('background_color', 'white', 'block_' . $block_ids['seating_diagram']);
update_field('brand_logos', [
    [
        'name' => 'Venture',
        'tagline' => ''
    ],
    [
        'name' => 'Quest for Elegance',
        'tagline' => 'Produced by Jamco'
    ]
], 'block_' . $block_ids['seating_diagram']);

// Section Intro Block Fields
echo "  Populating Section Intro block fields...\n";
update_field('eyebrow', 'PREMIUM FEATURES', 'block_' . $block_ids['section_intro']);
update_field('heading', 'Our Premium Seating features', 'block_' . $block_ids['section_intro']);
update_field('description', 'Designed with passenger comfort and airline efficiency in mind, our premium seating solutions combine innovative technology with timeless design.', 'block_' . $block_ids['section_intro']);

// Feature Grid Block Fields
echo "  Populating Feature Grid block fields...\n";
$features = [];
if (isset($uploaded_images['feature-1'])) {
    $features[] = [
        'image' => $uploaded_images['feature-1'],
        'heading' => 'Ergonomic Design',
        'description' => 'Carefully crafted to provide maximum comfort during long flights with adjustable components.'
    ];
}
if (isset($uploaded_images['feature-2'])) {
    $features[] = [
        'image' => $uploaded_images['feature-2'],
        'heading' => 'Premium Materials',
        'description' => 'High-quality materials selected for durability, comfort, and aesthetic appeal.'
    ];
}
if (isset($uploaded_images['feature-3'])) {
    $features[] = [
        'image' => $uploaded_images['feature-3'],
        'heading' => 'Smart Integration',
        'description' => 'Seamlessly integrated entertainment and connectivity features for the modern traveler.'
    ];
}
update_field('features', $features, 'block_' . $block_ids['feature_grid']);

// Full Width Image Block Fields
echo "  Populating Full Width Image block fields...\n";
if (isset($uploaded_images['full-width-image'])) {
    update_field('image', $uploaded_images['full-width-image'], 'block_' . $block_ids['full_width_image']);
}
update_field('height', 'large', 'block_' . $block_ids['full_width_image']);
update_field('watermark', 'Venture', 'block_' . $block_ids['full_width_image']);

// Split Feature 1 - Control & Comfort
echo "  Populating Split Feature 1 block fields...\n";
update_field('heading', 'Control & Comfort', 'block_' . $block_ids['split_1']);
update_field('description', 'A unified control center uses capacitive touch input with LED lighting for clear, intuitive operation. Lighting, power, and entertainment are positioned where they are easy to use.', 'block_' . $block_ids['split_1']);
if (isset($uploaded_images['split-1'])) {
    update_field('feature_image', $uploaded_images['split-1'], 'block_' . $block_ids['split_1']);
}
update_field('image_position', 'right', 'block_' . $block_ids['split_1']);
update_field('background_color', 'white', 'block_' . $block_ids['split_1']);
update_field('cta_button', [
    'text' => 'Contact Us',
    'url' => '#contact',
    'style' => 'secondary'
], 'block_' . $block_ids['split_1']);

// Split Feature 2 - Private by Design
echo "  Populating Split Feature 2 block fields...\n";
update_field('heading', 'Private by Design', 'block_' . $block_ids['split_2']);
update_field('description', 'Sliding dividers provide privacy from zero to full as needed. Shielding and geometry help reduce distractions while maintaining a calm, spacious feel.', 'block_' . $block_ids['split_2']);
if (isset($uploaded_images['split-2'])) {
    update_field('feature_image', $uploaded_images['split-2'], 'block_' . $block_ids['split_2']);
}
update_field('image_position', 'left', 'block_' . $block_ids['split_2']);
update_field('background_color', 'light-blue', 'block_' . $block_ids['split_2']);
update_field('cta_button', [
    'text' => 'Contact Us',
    'url' => '#contact',
    'style' => 'secondary'
], 'block_' . $block_ids['split_2']);

// Split Feature 3 - Work and Entertain On-Demand
echo "  Populating Split Feature 3 block fields...\n";
update_field('heading', 'Work and Entertain On-Demand', 'block_' . $block_ids['split_3']);
update_field('description', 'An immersive HD display and spacious tray surface supports both work and relaxation. Content is accessible quickly without disrupting the passenger\'s setup.', 'block_' . $block_ids['split_3']);
if (isset($uploaded_images['split-3'])) {
    update_field('feature_image', $uploaded_images['split-3'], 'block_' . $block_ids['split_3']);
}
update_field('image_position', 'right', 'block_' . $block_ids['split_3']);
update_field('background_color', 'light-blue', 'block_' . $block_ids['split_3']);
update_field('cta_button', [
    'text' => 'Contact Us',
    'url' => '#contact',
    'style' => 'secondary'
], 'block_' . $block_ids['split_3']);

// Split Feature 4 - Spatial Freedom
echo "  Populating Split Feature 4 block fields...\n";
update_field('heading', 'Spatial Freedom', 'block_' . $block_ids['split_4']);
update_field('description', 'Ample space for passenger comfort and curated storage locations keep personal items tidy from taxi to touchdown.', 'block_' . $block_ids['split_4']);
if (isset($uploaded_images['split-4'])) {
    update_field('feature_image', $uploaded_images['split-4'], 'block_' . $block_ids['split_4']);
}
update_field('image_position', 'left', 'block_' . $block_ids['split_4']);
update_field('background_color', 'white', 'block_' . $block_ids['split_4']);
update_field('cta_button', [
    'text' => 'Contact Us',
    'url' => '#contact',
    'style' => 'secondary'
], 'block_' . $block_ids['split_4']);

// Update product thumbnails and get product IDs
echo "  Updating product images...\n";
$products = get_posts([
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'ID',
    'order' => 'ASC'
]);

$product_ids = [];
foreach ($products as $index => $product) {
    $product_ids[] = $product->ID;
    $image_key = 'product-' . ($index + 1);
    if (isset($uploaded_images[$image_key])) {
        set_post_thumbnail($product->ID, $uploaded_images[$image_key]);
        echo "    ✓ Set thumbnail for {$product->post_title}\n";
    }
}

// Product Carousel Block Fields
echo "  Populating Product Carousel block fields...\n";
update_field('heading', 'Complete your travel ecosystem', 'block_' . $block_ids['product_carousel']);
update_field('description', 'Elevate every aspect of your journey.', 'block_' . $block_ids['product_carousel']);
update_field('label', 'Related Products', 'block_' . $block_ids['product_carousel']);
update_field('products', $product_ids, 'block_' . $block_ids['product_carousel']);
update_field('show_pagination', true, 'block_' . $block_ids['product_carousel']);

// Testimonial Block Fields
echo "  Populating Testimonial block fields...\n";
update_field('quote', 'The premium seating has transformed our passenger experience. Comfort, style, and functionality come together perfectly in these seats.', 'block_' . $block_ids['testimonial']);
update_field('author_name', 'Maria Santos', 'block_' . $block_ids['testimonial']);
update_field('author_title', 'Head of Cabin Design', 'block_' . $block_ids['testimonial']);
update_field('author_company', 'Global Airways', 'block_' . $block_ids['testimonial']);
if (isset($uploaded_images['testimonial-author'])) {
    update_field('author_image', $uploaded_images['testimonial-author'], 'block_' . $block_ids['testimonial']);
}
update_field('background_color', '#3767AD', 'block_' . $block_ids['testimonial']);

// CTA Block Fields
echo "  Populating CTA block fields...\n";
update_field('heading', 'Ready to talk?', 'block_' . $block_ids['cta']);
update_field('subheading', 'Our team is ready to meet your needs.', 'block_' . $block_ids['cta']);
if (isset($uploaded_images['cta-bg'])) {
    update_field('background_image', $uploaded_images['cta-bg'], 'block_' . $block_ids['cta']);
}
update_field('cta_button', [
    'text' => 'Contact Us',
    'url' => '#contact',
    'style' => 'primary'
], 'block_' . $block_ids['cta']);

// Step 6: Set homepage
echo "\nStep 6: Setting homepage...\n";
update_option('show_on_front', 'page');
update_option('page_on_front', $page_id);
echo "  ✓ Homepage set to Premium Seating page (ID: $page_id)\n";

// Final summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "Content population complete!\n";
echo str_repeat("=", 60) . "\n";
echo "✓ Uploaded " . count($uploaded_images) . " images\n";
echo "✓ Created 12 ACF blocks\n";
echo "✓ Populated all block fields using update_field()\n";
echo "✓ Updated Premium Seating page (ID: $page_id)\n";
echo "✓ Set homepage to Premium Seating page\n";
echo "\nView at: http://localhost:8888/\n";
echo str_repeat("=", 60) . "\n";
