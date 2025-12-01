<?php
/**
 * Sync Premium Seating page from Sanity to WordPress
 *
 * Run with: npm run wp-env run cli wp eval-file /var/www/html/wp-content/themes/jamco-theme/sync-from-sanity.php
 */

// Sanity configuration
$sanity_project_id = 'c94x8u55';
$sanity_dataset = 'production';
$sanity_api_version = '2024-01-01';

function fetch_from_sanity($query) {
    global $sanity_project_id, $sanity_dataset, $sanity_api_version;

    $url = "https://" . $sanity_project_id . ".api.sanity.io/v" . $sanity_api_version . "/data/query/" . $sanity_dataset . "?" . http_build_query(['query' => $query]);

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        echo "Error fetching from Sanity: " . $response->get_error_message() . "\n";
        return null;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data['result'] ?? null;
}

function get_image_id_by_sanity_ref($sanity_ref) {
    // Map of known Sanity image refs to WordPress image IDs
    // This should match the images we already uploaded
    $image_map = [
        'image-94dee5be4f3beebda76aa0da5c33a2a3c37f0ae8-707x507-jpg' => 9,  // Placeholder Image.jpg
        'image-e7af2956eb1f5e5512f98124b4884eac43c0904f-666x590-jpg' => 14, // Placeholder Image-1.jpg
        'image-1e0bf9c93bc7b44c72d0d0b13b3f8c8aeb566b5a-666x590-jpg' => 15, // Placeholder Image-2.jpg
        'image-faf90e7b7a7f65bb806ee0a5dc09fc3f32a84a30-666x590-jpg' => 20, // Placeholder Image-3.jpg
        'image-4f76f1430e90531c4e5ca879f269b1f2dcbbf577-666x590-jpg' => 12, // Placeholder Image-5.jpg
        'image-d349e4151f38ce7f24d31fab42463c4450413f3d-1440x658-jpg' => 10, // seat-view.jpg
        'image-693bed54af13363d7338602a343c37ac394acb4a-1323x771-jpg' => 106, // Screenshot
    ];

    return $image_map[$sanity_ref] ?? 0;
}

function sanity_to_wp_blocks($sanity_content) {
    $blocks = [];

    foreach ($sanity_content as $block) {
        $block_type = $block['_type'] ?? '';

        switch ($block_type) {
            case 'heroCarousel':
                // Hero carousel block
                $slides = $block['slides'] ?? [];
                if (!empty($slides)) {
                    $slide = $slides[0]; // Use first slide

                    $hero_image_id = 0;
                    if (isset($slide['image']['asset']['_ref'])) {
                        $hero_image_id = get_image_id_by_sanity_ref($slide['image']['asset']['_ref']);
                    }

                    $blocks[] = [
                        'blockName' => 'jamco/hero',
                        'attrs' => [
                            'heading' => $slide['heading'] ?? '',
                            'subheading' => $slide['subheading'] ?? '',
                            'floatingImage' => $hero_image_id,
                            'primaryCta' => [
                                'text' => $slide['primaryCta']['text'] ?? '',
                                'url' => $slide['primaryCta']['url'] ?? '',
                                'style' => 'primary'
                            ],
                            'secondaryCta' => [
                                'text' => $slide['secondaryCta']['text'] ?? '',
                                'url' => $slide['secondaryCta']['url'] ?? '',
                                'style' => 'secondary'
                            ]
                        ],
                        'innerContent' => [''],
                        'innerHTML' => ''
                    ];
                }
                break;

            case 'productShowcaseBlock':
                $showcase_image_id = 0;
                if (isset($block['showcaseImage']['asset']['_ref'])) {
                    $showcase_image_id = get_image_id_by_sanity_ref($block['showcaseImage']['asset']['_ref']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/product-showcase',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'subheading' => $block['subheading'] ?? '',
                        'description' => $block['description'] ?? '',
                        'showcaseImage' => $showcase_image_id,
                        'ctaButton' => $block['ctaButton'] ?? [],
                        'secondaryCtaButton' => $block['secondaryCtaButton'] ?? []
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'seatingDiagramBlock':
                $diagram_image_id = 0;
                if (isset($block['diagramImage']['asset']['_ref'])) {
                    $diagram_image_id = get_image_id_by_sanity_ref($block['diagramImage']['asset']['_ref']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/seating-diagram',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'description' => $block['description'] ?? '',
                        'diagramImage' => $diagram_image_id,
                        'annotations' => $block['annotations'] ?? []
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'sectionIntro':
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
                $blocks[] = [
                    'blockName' => 'jamco/feature-grid',
                    'attrs' => [
                        'features' => $block['features'] ?? []
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'fullWidthImageBlock':
                $image_id = 0;
                if (isset($block['image']['asset']['_ref'])) {
                    $image_id = get_image_id_by_sanity_ref($block['image']['asset']['_ref']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/full-width-image',
                    'attrs' => [
                        'image' => $image_id,
                        'caption' => $block['caption'] ?? ''
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'splitFeatureBlock':
                $feature_image_id = 0;
                if (isset($block['featureImage']['asset']['_ref'])) {
                    $feature_image_id = get_image_id_by_sanity_ref($block['featureImage']['asset']['_ref']);
                }

                // Determine background color
                $bg_color = 'white';
                if (isset($block['backgroundColor'])) {
                    if ($block['backgroundColor'] === 'blue') $bg_color = 'light-blue';
                    else if ($block['backgroundColor'] === 'darkBlue') $bg_color = 'dark-blue';
                    else $bg_color = $block['backgroundColor'];
                }

                $blocks[] = [
                    'blockName' => 'jamco/split-feature',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'description' => $block['description'] ?? '',
                        'bulletPoints' => $block['bulletPoints'] ?? [],
                        'featureImage' => $feature_image_id,
                        'imagePosition' => $block['imagePosition'] ?? 'right',
                        'backgroundColor' => $bg_color,
                        'ctaButton' => $block['ctaButton'] ?? null
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'testimonialBlock':
                $author_image_id = 0;
                if (isset($block['authorImage']['asset']['_ref'])) {
                    $author_image_id = get_image_id_by_sanity_ref($block['authorImage']['asset']['_ref']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/testimonial',
                    'attrs' => [
                        'quote' => $block['quote'] ?? '',
                        'authorName' => $block['authorName'] ?? '',
                        'authorTitle' => $block['authorTitle'] ?? '',
                        'authorImage' => $author_image_id
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'productCarouselBlock':
                $product_refs = [];
                foreach ($block['products'] ?? [] as $product_ref) {
                    if (isset($product_ref['_ref'])) {
                        $product_refs[] = $product_ref['_ref'];
                    }
                }

                $blocks[] = [
                    'blockName' => 'jamco/product-carousel',
                    'attrs' => [
                        'title' => $block['title'] ?? '',
                        'productRefs' => $product_refs
                    ],
                    'innerContent' => [''],
                    'innerHTML' => ''
                ];
                break;

            case 'ctaBlock':
                $bg_image_id = 0;
                if (isset($block['backgroundImage']['asset']['_ref'])) {
                    $bg_image_id = get_image_id_by_sanity_ref($block['backgroundImage']['asset']['_ref']);
                }

                $blocks[] = [
                    'blockName' => 'jamco/cta',
                    'attrs' => [
                        'heading' => $block['heading'] ?? '',
                        'subheading' => $block['subheading'] ?? '',
                        'backgroundImage' => $bg_image_id,
                        'backgroundColor' => 'dark-blue',
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
echo "Fetching Premium Seating page from Sanity...\n";

$query = '*[_id == "page-premium-seating"][0]{
  title,
  heroSection {
    _type,
    slides[] {
      heading,
      subheading,
      image { asset->{ _id } },
      primaryCta,
      secondaryCta,
      hotspots[]
    }
  },
  content[] {
    _type,
    _type == "productShowcaseBlock" => {
      heading,
      subheading,
      description,
      showcaseImage { asset->{ _id } },
      ctaButton,
      secondaryCtaButton
    },
    _type == "seatingDiagramBlock" => {
      heading,
      description,
      diagramImage { asset->{ _id } },
      annotations[]
    },
    _type == "sectionIntro" => {
      heading,
      description
    },
    _type == "featureGridBlock" => {
      features[] {
        heading,
        description,
        icon { asset->{ _id } }
      }
    },
    _type == "fullWidthImageBlock" => {
      image { asset->{ _id } },
      caption
    },
    _type == "splitFeatureBlock" => {
      heading,
      description,
      bulletPoints,
      featureImage { asset->{ _id } },
      imagePosition,
      backgroundColor,
      ctaButton
    },
    _type == "testimonialBlock" => {
      quote,
      authorName,
      authorTitle,
      authorImage { asset->{ _id } }
    },
    _type == "productCarouselBlock" => {
      title,
      products[]->{ _id }
    },
    _type == "ctaBlock" => {
      heading,
      subheading,
      backgroundImage { asset->{ _id } },
      ctaButton
    }
  }
}';

$page_data = fetch_from_sanity($query);

if (!$page_data) {
    echo "Error: Could not fetch page from Sanity\n";
    exit(1);
}

echo "Converting Sanity content to WordPress blocks...\n";

// Start with hero
$all_blocks = [];

if (isset($page_data['heroSection'])) {
    $hero_blocks = sanity_to_wp_blocks([$page_data['heroSection']]);
    $all_blocks = array_merge($all_blocks, $hero_blocks);
}

// Add content blocks
if (isset($page_data['content'])) {
    $content_blocks = sanity_to_wp_blocks($page_data['content']);
    $all_blocks = array_merge($all_blocks, $content_blocks);
}

echo "Total blocks to create: " . count($all_blocks) . "\n\n";

// Generate WordPress block content
$post_content = serialize_blocks($all_blocks);

// Create or update the page
$page_title = 'Premium Seating (Synced from Sanity)';

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
