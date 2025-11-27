<?php
/**
 * Populate Premium Seating Page with Content
 *
 * Run with: cd jamco-wordpress && npm run wp-env -- run cli wp eval-file scripts/populate-content.php
 */

// Image mapping from exported-images directory (now in theme dir)
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

echo "Starting content population...\n\n";

// Step 1: Upload images
echo "Step 1: Uploading images to media library...\n";
$uploaded_images = [];

foreach ($images_to_upload as $key => $full_path) {
    if (!file_exists($full_path)) {
        echo "  ⚠ Warning: $key - File not found: $full_path\n";
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

echo "\nStep 2: Creating/updating Premium Seating page...\n";

// Get or create the page
$page = get_page_by_path('premium-seating', OBJECT, 'page');
$page_id = $page ? $page->ID : 5; // Should be ID 5 from earlier creation

echo "  Page ID: $page_id\n";

// Step 3: Build Gutenberg block content
echo "\nStep 3: Building page content with ACF blocks...\n";

$blocks = [];

// Hero Block
$hero_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/hero',
    'attrs' => [
        'id' => $hero_block_id,
        'name' => 'acf/hero',
        'data' => [
            'heading' => 'Premium Seating',
            'subheading' => 'Experience unparalleled comfort and luxury in our premium seating solutions designed for the modern traveler.',
            'floating_image' => $uploaded_images['hero'] ?? '',
            'primary_cta' => [
                'text' => 'Explore Products',
                'url' => '#products'
            ],
            'secondary_cta' => [
                'text' => 'Contact Us',
                'url' => '/contact'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Section Intro Block
$section_intro_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/section-intro',
    'attrs' => [
        'id' => $section_intro_block_id,
        'name' => 'acf/section-intro',
        'data' => [
            'eyebrow' => 'PREMIUM FEATURES',
            'heading' => 'Our Premium Seating features',
            'description' => 'Designed with passenger comfort and airline efficiency in mind, our premium seating solutions combine innovative technology with timeless design.'
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Feature Grid Block
$feature_grid_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/feature-grid',
    'attrs' => [
        'id' => $feature_grid_block_id,
        'name' => 'acf/feature-grid',
        'data' => [
            'features' => [
                [
                    'image' => $uploaded_images['feature-1'] ?? '',
                    'heading' => 'Ergonomic Design',
                    'description' => 'Carefully crafted to provide maximum comfort during long flights with adjustable components.'
                ],
                [
                    'image' => $uploaded_images['feature-2'] ?? '',
                    'heading' => 'Premium Materials',
                    'description' => 'High-quality materials selected for durability, comfort, and aesthetic appeal.'
                ],
                [
                    'image' => $uploaded_images['feature-3'] ?? '',
                    'heading' => 'Smart Integration',
                    'description' => 'Seamlessly integrated entertainment and connectivity features for the modern traveler.'
                ]
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Split Feature 1 - Control & Comfort
$split_1_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/split-feature',
    'attrs' => [
        'id' => $split_1_block_id,
        'name' => 'acf/split-feature',
        'data' => [
            'heading' => 'Control & Comfort',
            'description' => '<p>Our premium seating puts passengers in complete control of their comfort. Adjust recline, lumbar support, and headrest position with intuitive controls designed for ease of use.</p><p>Every detail is engineered to provide a personalized experience that adapts to individual preferences.</p>',
            'feature_image' => $uploaded_images['split-1'] ?? '',
            'image_position' => 'left',
            'background_color' => 'white',
            'cta_button' => [
                'text' => 'Learn More',
                'url' => '#',
                'style' => 'secondary'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Split Feature 2 - Private by Design
$split_2_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/split-feature',
    'attrs' => [
        'id' => $split_2_block_id,
        'name' => 'acf/split-feature',
        'data' => [
            'heading' => 'Private by Design',
            'description' => '<p>Create your own sanctuary at 35,000 feet with privacy features that let you work, rest, or relax without distraction.</p><p>Adjustable privacy screens and thoughtful spatial design ensure a personal haven in the sky.</p>',
            'feature_image' => $uploaded_images['split-2'] ?? '',
            'image_position' => 'right',
            'background_color' => 'blue',
            'cta_button' => [
                'text' => 'View Details',
                'url' => '#',
                'style' => 'outline'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Split Feature 3 - Work and Entertain
$split_3_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/split-feature',
    'attrs' => [
        'id' => $split_3_block_id,
        'name' => 'acf/split-feature',
        'data' => [
            'heading' => 'Work and Entertain On-Demand',
            'description' => '<p>Stay productive or entertained with integrated workspace and entertainment features. Multiple device charging ports, spacious tray tables, and high-definition displays keep you connected.</p>',
            'feature_image' => $uploaded_images['split-3'] ?? '',
            'image_position' => 'left',
            'background_color' => 'light-blue',
            'cta_button' => [
                'text' => 'Explore Features',
                'url' => '#',
                'style' => 'secondary'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Split Feature 4 - Spatial Freedom
$split_4_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/split-feature',
    'attrs' => [
        'id' => $split_4_block_id,
        'name' => 'acf/split-feature',
        'data' => [
            'heading' => 'Spatial Freedom',
            'description' => '<p>Generous legroom and clever storage solutions provide the space you need to truly relax. Our innovative design maximizes personal space without compromising cabin efficiency.</p>',
            'feature_image' => $uploaded_images['split-4'] ?? '',
            'image_position' => 'right',
            'background_color' => 'white',
            'cta_button' => [
                'text' => 'See Specifications',
                'url' => '#',
                'style' => 'secondary'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Update products with images
echo "\nStep 4: Updating product images...\n";
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
        echo "  ✓ Set thumbnail for {$product->post_title}\n";
    }
}

// Product Carousel Block
$product_carousel_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/product-carousel',
    'attrs' => [
        'id' => $product_carousel_block_id,
        'name' => 'acf/product-carousel',
        'data' => [
            'heading' => 'Related Products',
            'description' => 'Explore our full range of premium seating solutions',
            'label' => 'PRODUCT SHOWCASE',
            'products' => $product_ids,
            'show_pagination' => true
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Testimonial Block
$testimonial_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/testimonial',
    'attrs' => [
        'id' => $testimonial_block_id,
        'name' => 'acf/testimonial',
        'data' => [
            'quote' => 'The premium seating has transformed our passenger experience. Comfort, style, and functionality come together perfectly in these seats.',
            'author_name' => 'Maria Santos',
            'author_title' => 'Head of Cabin Design',
            'author_company' => 'Global Airways',
            'author_image' => $uploaded_images['testimonial-author'] ?? '',
            'background_color' => '#3767AD'
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// CTA Block
$cta_block_id = 'block_' . uniqid();
$blocks[] = [
    'blockName' => 'acf/cta',
    'attrs' => [
        'id' => $cta_block_id,
        'name' => 'acf/cta',
        'data' => [
            'heading' => 'Ready to elevate your cabin?',
            'subheading' => 'Contact our team to discuss how our premium seating solutions can transform your passenger experience.',
            'background_image' => $uploaded_images['cta-bg'] ?? '',
            'cta_button' => [
                'text' => 'Get in Touch',
                'url' => '/contact',
                'style' => 'outline'
            ]
        ],
        'mode' => 'preview'
    ],
    'innerContent' => ['']
];

// Convert blocks to Gutenberg format
$content = serialize_blocks($blocks);

// Update the page
wp_update_post([
    'ID' => $page_id,
    'post_content' => $content
]);

echo "\nStep 5: Content population complete!\n";
echo "✓ Uploaded " . count($uploaded_images) . " images\n";
echo "✓ Created " . count($blocks) . " content blocks\n";
echo "✓ Updated Premium Seating page (ID: $page_id)\n";
echo "\nView at: http://localhost:8888/premium-seating/\n";
