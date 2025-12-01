<?php
/**
 * Update product-showcase block with correct content
 */

$page_id = 5;
$page = get_post($page_id);
$blocks = parse_blocks($page->post_content);

// Update the product-showcase block
foreach ($blocks as &$block) {
    if ($block['blockName'] === 'jamco/product-showcase') {
        $block['attrs'] = [
            'heading' => 'Jamco Premium Seating',
            'description' => 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control.',
            'ctaButton' => [
                'text' => 'View Premium Seating Suite',
                'url' => '#premium-seating',
                'style' => 'primary'
            ],
            'secondaryCtaButton' => [
                'text' => 'Download the Brochure',
                'url' => '#brochure',
                'style' => 'outline'
            ]
        ];

        echo "✅ Updated product-showcase block:\n";
        echo "   Heading: Jamco Premium Seating\n";
        echo "   Description: Premium-density seats...\n";
        echo "   Primary CTA: View Premium Seating Suite\n";
        echo "   Secondary CTA: Download the Brochure\n";
        break;
    }
}

// Update page content
$new_content = serialize_blocks($blocks);
wp_update_post([
    'ID' => $page_id,
    'post_content' => $new_content
]);

echo "\n✅ Product-showcase block updated!\n";
echo "   View at: http://localhost:8888/\n";
