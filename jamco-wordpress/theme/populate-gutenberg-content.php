<?php
/**
 * Populate Premium Seating page with Gutenberg blocks
 * Run with: wp-env run cli wp eval-file wp-content/themes/jamco/populate-gutenberg-content.php
 */

// Find the Premium Seating page
$page = get_page_by_path('premium-seating');

if (!$page) {
	echo "Premium Seating page not found. Creating...\n";
	$page_id = wp_insert_post([
		'post_title' => 'Premium Seating',
		'post_name' => 'premium-seating',
		'post_status' => 'publish',
		'post_type' => 'page',
	]);
} else {
	$page_id = $page->ID;
	echo "Found Premium Seating page (ID: $page_id)\n";
}

// Build the block content
$blocks = [];

// 1. Hero Section
$blocks[] = '<!-- wp:jamco/hero {"heading":"Premium Seating Solutions","subheading":"Experience unparalleled comfort and luxury with our award-winning premium seating systems designed for modern aircraft.","featureCallout":{"label":"Industry Leading","description":"Trusted by airlines worldwide"},"primaryCta":{"text":"Explore Products","url":"#products"},"secondaryCta":{"text":"Contact Us","url":"#contact"},"carouselIndicator":"1 / 3"} /-->';

// 2. Section Intro
$blocks[] = '<!-- wp:jamco/section-intro {"heading":"Redefining Passenger Experience","description":"Our premium seating solutions combine cutting-edge design with exceptional comfort, setting new standards in aircraft interior excellence.","backgroundColor":"light-blue"} /-->';

// 3. Feature Grid
$features = [
	[
		'heading' => 'Superior Comfort',
		'description' => 'Ergonomically designed seats with premium materials for ultimate passenger comfort on long-haul flights.'
	],
	[
		'heading' => 'Space Optimization',
		'description' => 'Intelligent design maximizes passenger space while maintaining optimal cabin density.'
	],
	[
		'heading' => 'Premium Materials',
		'description' => 'High-quality, durable materials selected for both aesthetics and longevity.'
	],
	[
		'heading' => 'Customization',
		'description' => 'Flexible configurations to match your airline\'s brand and passenger needs.'
	]
];

$features_json = json_encode($features);
$blocks[] = "<!-- wp:jamco/feature-grid {\"heading\":\"Why Choose Our Seating\",\"features\":$features_json,\"backgroundColor\":\"white\"} /-->";

// 4. Split Feature - Spatial Freedom
$blocks[] = '<!-- wp:jamco/split-feature {"heading":"Spatial Freedom","description":"Our innovative design provides passengers with unprecedented personal space and freedom of movement.","bulletPoints":["Generous legroom and recline","Adjustable headrests and lumbar support","Easy aisle access","Personal storage solutions"],"imagePosition":"right","backgroundColor":"white","ctaButton":{"text":"Learn More","url":"#spatial","style":"secondary"}} /-->';

// 5. Split Feature - Work and Entertain
$blocks[] = '<!-- wp:jamco/split-feature {"heading":"Work and Entertain On-Demand","description":"Integrated technology and thoughtful design enable passengers to work or relax seamlessly.","bulletPoints":["Built-in power outlets and USB ports","Spacious tray tables","Reading lights with adjustable intensity","Device holders and storage"],"imagePosition":"left","backgroundColor":"light-blue","ctaButton":{"text":"View Features","url":"#features","style":"secondary"}} /-->';

// 6. Product Carousel
$blocks[] = '<!-- wp:jamco/product-carousel {"heading":"Our Premium Seating Products"} /-->';

// 7. Testimonial
$blocks[] = '<!-- wp:jamco/testimonial {"quote":"The premium seating from JAMCO has transformed our passenger experience. The comfort and quality are exceptional, and our customers consistently rate their flights higher.","authorName":"Maria Chen","authorTitle":"VP of Customer Experience, Global Airlines"} /-->';

// 8. Split Feature - Sleek Design
$blocks[] = '<!-- wp:jamco/split-feature {"heading":"Sleek, Modern Design","description":"Award-winning aesthetics that complement any cabin interior while maintaining timeless appeal.","bulletPoints":["Contemporary styling","Premium fabric options","Customizable color schemes","Seamless integration with cabin design"],"imagePosition":"right","backgroundColor":"blue","ctaButton":{"text":"Design Options","url":"#design","style":"outline"}} /-->';

// 9. CTA Block
$blocks[] = '<!-- wp:jamco/cta {"heading":"Ready to Elevate Your Cabin?","description":"Contact our team to discuss how our premium seating solutions can enhance your aircraft.","ctaButton":{"text":"Get in Touch","url":"#contact","style":"primary"}} /-->';

// Combine all blocks
$content = implode("\n\n", $blocks);

// Update the page
$result = wp_update_post([
	'ID' => $page_id,
	'post_content' => $content,
]);

if (is_wp_error($result)) {
	echo "Error updating page: " . $result->get_error_message() . "\n";
} else {
	echo "Successfully populated Premium Seating page with " . count($blocks) . " blocks!\n";
	echo "View at: " . get_permalink($page_id) . "\n";
}
