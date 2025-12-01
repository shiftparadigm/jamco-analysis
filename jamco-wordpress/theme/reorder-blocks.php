<?php
/**
 * Reorder blocks to match Astro reference site
 * Run via WP-CLI: npm run wp-env run cli -- --env-cwd=wp-content/themes/jamco php reorder-blocks.php
 */

$page_id = 5; // Homepage ID
$page = get_post($page_id);

if (!$page) {
    echo "❌ Page {$page_id} not found!\n";
    exit(1);
}

echo "=== Reordering Blocks for: {$page->post_title} ===\n\n";

// Parse existing blocks
$blocks = parse_blocks($page->post_content);

// Extract blocks by type (keeping non-empty blocks only)
$block_map = [];
foreach ($blocks as $block) {
    if (!empty($block['blockName'])) {
        $type = str_replace('jamco/', '', $block['blockName']);
        if (!isset($block_map[$type])) {
            $block_map[$type] = [];
        }
        $block_map[$type][] = $block;
    }
}

echo "Current blocks found:\n";
foreach ($block_map as $type => $blocks_of_type) {
    echo "  {$type}: " . count($blocks_of_type) . "\n";
}
echo "\n";

// Create second section-intro block (missing)
$second_section_intro = [
    'blockName' => 'jamco/section-intro',
    'attrs' => [
        'heading' => 'Our Premium Seating features',
        'description' => 'Deliver the passenger experience your brand promises, without sacrificing density or service efficiency.'
    ],
    'innerBlocks' => [],
    'innerHTML' => '',
    'innerContent' => []
];

// Get additional split features from Astro (we need 2 more)
$additional_split_1 = [
    'blockName' => 'jamco/split-feature',
    'attrs' => [
        'heading' => 'Enhanced Comfort & Ergonomics',
        'description' => 'Every detail carefully considered for maximum passenger comfort and support.',
        'bulletPoints' => [
            'Contoured seat cushioning',
            'Multi-position recline',
            'Adjustable armrests',
            'Optimized seat pitch'
        ],
        'imagePosition' => 'right',
        'backgroundColor' => 'white',
        'ctaButton' => [
            'text' => 'Comfort Features',
            'url' => '#comfort',
            'style' => 'secondary'
        ]
    ],
    'innerBlocks' => [],
    'innerHTML' => '',
    'innerContent' => []
];

$additional_split_2 = [
    'blockName' => 'jamco/split-feature',
    'attrs' => [
        'heading' => 'Sustainable & Durable',
        'description' => 'Built to last with environmentally conscious materials and processes.',
        'bulletPoints' => [
            'Eco-friendly materials',
            'Long service life',
            'Easy maintenance',
            'Reduced weight for fuel efficiency'
        ],
        'imagePosition' => 'left',
        'backgroundColor' => 'white',
        'ctaButton' => [
            'text' => 'Sustainability',
            'url' => '#sustainability',
            'style' => 'secondary'
        ]
    ],
    'innerBlocks' => [],
    'innerHTML' => '',
    'innerContent' => []
];

// Build new block order matching Astro
$new_blocks = [
    // 1. Hero
    $block_map['hero'][0],

    // 2. Product Showcase
    $block_map['product-showcase'][0],

    // 3. Seating Diagram
    $block_map['seating-diagram'][0],

    // 4. Section Intro #1 (Redefining Passenger Experience)
    $block_map['section-intro'][0],

    // 5. Feature Grid
    $block_map['feature-grid'][0],

    // 6. Full Width Image
    $block_map['full-width-image'][0],

    // 7. Section Intro #2 (NEW - Our Premium Seating features)
    $second_section_intro,

    // 8. Split Feature #1 (Spatial Freedom)
    $block_map['split-feature'][0],

    // 9. Split Feature #2 (Work and Entertain)
    $block_map['split-feature'][1],

    // 10. Testimonial
    $block_map['testimonial'][0],

    // 11. Split Feature #3 (Enhanced Comfort - NEW)
    $additional_split_1,

    // 12. Split Feature #4 (Sleek Modern Design)
    $block_map['split-feature'][2],

    // 13. Product Carousel
    $block_map['product-carousel'][0],

    // 14. CTA
    $block_map['cta'][0]
];

echo "New block order:\n";
for ($i = 0; $i < count($new_blocks); $i++) {
    $block = $new_blocks[$i];
    $num = $i + 1;
    $name = str_replace('jamco/', '', $block['blockName']);
    $heading = $block['attrs']['heading'] ?? $block['attrs']['title'] ?? '';
    echo "  {$num}. {$name}" . ($heading ? " ({$heading})" : "") . "\n";
}
echo "\n";

// Serialize blocks back to content
$new_content = serialize_blocks($new_blocks);

// Update page
$result = wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

if (is_wp_error($result)) {
    echo "❌ Error updating page: " . $result->get_error_message() . "\n";
    exit(1);
}

echo "✅ Successfully reordered blocks!\n";
echo "   Total blocks: " . count($new_blocks) . "\n";
echo "   Added: 2 new blocks (section-intro #2, split-feature #3)\n";
echo "   View at: http://localhost:8888/\n";
