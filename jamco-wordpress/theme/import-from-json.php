<?php
/**
 * Import Premium Seating page from Sanity JSON to WordPress
 *
 * Run with: npm run wp-env run cli wp eval-file /var/www/html/wp-content/themes/jamco/import-from-json.php
 */

// Read the JSON file
$json_path = __DIR__ . '/sanity-page-data.json';
$json_content = file_get_contents($json_path);
$page_data = json_decode($json_content, true);

if (!$page_data) {
    echo "Error: Could not read or parse JSON file\n";
    exit(1);
}

function get_image_id_by_sanity_ref($sanity_ref) {
    static $image_map = null;

    // Load the WordPress image mapping on first call
    if ($image_map === null) {
        $mapping_file = __DIR__ . '/wordpress-image-mapping.json';
        if (file_exists($mapping_file)) {
            $mapping_json = file_get_contents($mapping_file);
            $image_map = json_decode($mapping_json, true);
        } else {
            $image_map = [];
        }
    }

    return $image_map[$sanity_ref] ?? 0;
}

function sanity_to_wp_blocks($page_data) {
    $blocks = [];

    // Convert hero
    if (isset($page_data['hero'])) {
        $hero = $page_data['hero'];

        $hero_image_id = 0;
        if (isset($hero['floatingImage']['asset']['_id'])) {
            $hero_image_id = get_image_id_by_sanity_ref($hero['floatingImage']['asset']['_id']);
        }

        $blocks[] = [
            'blockName' => 'jamco/hero',
            'attrs' => [
                'heading' => $hero['heading'] ?? '',
                'subheading' => $hero['subheading'] ?? '',
                'floatingImage' => $hero_image_id,
                'featureCallout' => $hero['featureCallout'] ?? null,
                'primaryCta' => $hero['cta'] ?? null,
                'secondaryCta' => $hero['secondaryCta'] ?? null,
                'hotspots' => $hero['slides'][0]['hotspots'] ?? []
            ],
            'innerContent' => [''],
            'innerHTML' => ''
        ];
    }

    // Convert content blocks
    foreach ($page_data['content'] as $block) {
        $block_type = $block['_type'] ?? '';

        switch ($block_type) {
            case 'productShowcaseBlock':
                $showcase_image_id = 0;
                if (isset($block['productImage']['asset']['_id'])) {
                    $showcase_image_id = get_image_id_by_sanity_ref($block['productImage']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/product-showcase',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'subheading' => $block['subheading'] ?? '',
                        'brandName' => $block['brandName'] ?? '',
                        'brandDescription' => $block['brandDescription'] ?? '',
                        'showcaseImage' => $showcase_image_id
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'seatingDiagramBlock':
                $diagram_image_id = 0;
                if (isset($block['diagramImage']['asset']['_id'])) {
                    $diagram_image_id = get_image_id_by_sanity_ref($block['diagramImage']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/seating-diagram',
                    'attrs' => [
                        'diagramImage' => $diagram_image_id,
                        'brandLogos' => $block['brandLogos'] ?? [],
                        'backgroundColor' => $block['backgroundColor'] ?? 'white'
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'sectionIntroBlock':
                $blocks[] = [
                    'blockName' => 'jamco/section-intro',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'description' => $block['description'] ?? ''
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'featureGridBlock':
                $features = [];
                foreach ($block['features'] ?? [] as $feature) {
                    $feature_image_id = 0;
                    if (isset($feature['image']['asset']['_id'])) {
                        $feature_image_id = get_image_id_by_sanity_ref($feature['image']['asset']['_id']);
                    }

                    $features[] = [
                        'heading' => $feature['heading'] ?? '',
                        'description' => $feature['description'] ?? '',
                        'image' => $feature_image_id
                    ];
                }

                $blocks[] = [
                    'blockName' => 'jamco/feature-grid',
                    'attrs' => [
                        'columns' => $block['columns'] ?? '3-col',
                        'features' => $features
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'fullWidthImageBlock':
                $image_id = 0;
                if (isset($block['image']['asset']['_id'])) {
                    $image_id = get_image_id_by_sanity_ref($block['image']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/full-width-image',
                    'attrs' => [
                        'image' => $image_id,
                        'height' => $block['height'] ?? 'medium',
                        'watermark' => $block['watermark'] ?? '',
                        'showNavArrows' => $block['showNavArrows'] ?? false
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'splitFeatureBlock':
                $feature_image_id = 0;
                if (isset($block['featureImage']['asset']['_id'])) {
                    $feature_image_id = get_image_id_by_sanity_ref($block['featureImage']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/split-feature',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'description' => $block['description'] ?? '',
                        'bulletPoints' => $block['bulletPoints'] ?? [],
                        'featureImage' => $feature_image_id,
                        'imagePosition' => $block['imagePosition'] ?? 'right',
                        'backgroundColor' => $block['backgroundColor'] ?? 'white',
                        'ctaButton' => $block['ctaButton'] ?? null
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'testimonialBlock':
                $bg_image_id = 0;
                if (isset($block['backgroundImage']['asset']['_id'])) {
                    $bg_image_id = get_image_id_by_sanity_ref($block['backgroundImage']['asset']['_id']);
                }

                // Get first testimonial and flatten it
                $first_testimonial = $block['testimonials'][0] ?? [];
                $author_image_id = 0;
                if (isset($first_testimonial['image']['asset']['_id'])) {
                    $author_image_id = get_image_id_by_sanity_ref($first_testimonial['image']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/testimonial',
                    'attrs' => [
                        'layout' => $block['layout'] ?? 'centered',
                        'quoteSize' => $block['quoteSize'] ?? 'large',
                        'backgroundImage' => $bg_image_id,
                        'quote' => $first_testimonial['quote'] ?? '',
                        'authorName' => $first_testimonial['author'] ?? '',
                        'authorTitle' => ($first_testimonial['title'] ?? '') . (isset($first_testimonial['company']) ? ', ' . $first_testimonial['company'] : ''),
                        'authorImage' => $author_image_id
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'productCarouselBlock':
                $product_refs = [];
                foreach ($block['products'] ?? [] as $product) {
                    if (isset($product['_id'])) {
                        $product_refs[] = $product['_id'];
                    }
                }

                $blocks[] = [
                    'blockName' => 'jamco/product-carousel',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'description' => $block['description'] ?? '',
                        'label' => $block['label'] ?? '',
                        'productRefs' => $product_refs,
                        'showPagination' => $block['showPagination'] ?? true
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'ctaBlock':
                $bg_image_id = 0;
                if (isset($block['backgroundImage']['asset']['_id'])) {
                    $bg_image_id = get_image_id_by_sanity_ref($block['backgroundImage']['asset']['_id']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/cta',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'subheading' => $block['subheading'] ?? '',
                        'backgroundImage' => $bg_image_id,
                        'backgroundColor' => $block['backgroundColor'] ?? 'dark-blue',
                        'ctaButton' => $block['ctaButton'] ?? null
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;
        }
    }

    return $blocks;
}

// Main execution
echo "Converting Sanity content to WordPress blocks...\n";

$all_blocks = sanity_to_wp_blocks($page_data);

echo "Total blocks to create: " . count($all_blocks) . "\n\n";

// Generate WordPress block content
$post_content = serialize_blocks($all_blocks);

// Fix character encoding issues (u0026 -> &)
$post_content = preg_replace('/u0026/', '&', $post_content);

// Create or update the page
$page_title = 'Premium Seating';

// Check if page already exists
$existing_page = get_page_by_title($page_title, OBJECT, 'page');

if ($existing_page) {
    echo "Updating existing page (ID: {$existing_page->ID})...\n";
    $page_id = wp_update_post([
        'ID' => $existing_page->ID,
        'post_content' => $post_content
    ]);
} else {
    echo "Creating new page...\n";
    $page_id = wp_insert_post([
        'post_title' => $page_title,
        'post_content' => $post_content,
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);
}

if (is_wp_error($page_id)) {
    echo "Error creating/updating page: " . $page_id->get_error_message() . "\n";
    exit(1);
}

echo "\n✅ Success!\n";
echo "Page ID: {$page_id}\n";
echo "View at: " . get_permalink($page_id) . "\n";
echo "\nBlock summary:\n";

$block_types = array_count_values(array_column($all_blocks, 'blockName'));
foreach ($block_types as $type => $count) {
    echo "  - {$type}: {$count}\n";
}
