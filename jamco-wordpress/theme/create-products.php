<?php
/**
 * Create Product Posts for Carousel
 *
 * Run with: npm run wp-env run cli wp eval-file /var/www/html/wp-content/themes/jamco/create-products.php
 */

// Products to create
$products = [
	[
		'slug' => 'flight-deck-doors-linings',
		'title' => 'Flight Deck Doors and Linings',
		'image' => 'Placeholder Image-2 copy.jpg'
	],
	[
		'slug' => 'dividers-partitions',
		'title' => 'Dividers & Partitions',
		'image' => 'Placeholder Image-1 copy.jpg'
	],
	[
		'slug' => 'closets-stowage',
		'title' => 'Closets & Stowage',
		'image' => 'Placeholder Image copy.jpg'
	],
	[
		'slug' => 'lavatories',
		'title' => 'Lavatories',
		'image' => 'Placeholder Image-3 copy.jpg'
	]
];

foreach ($products as $product) {
	// Check if product already exists
	$existing = get_page_by_path($product['slug'], OBJECT, 'product');

	if ($existing) {
		echo "Product '{$product['title']}' already exists (ID: {$existing->ID})\n";
		continue;
	}

	// Create product post
	$post_id = wp_insert_post([
		'post_title' => $product['title'],
		'post_name' => $product['slug'],
		'post_type' => 'product',
		'post_status' => 'publish',
		'post_content' => ''
	]);

	if (is_wp_error($post_id)) {
		echo "Error creating product '{$product['title']}': " . $post_id->get_error_message() . "\n";
		continue;
	}

	// Find and set featured image
	$image_args = [
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
		'meta_query' => [
			[
				'key' => '_wp_attached_file',
				'value' => $product['image'],
				'compare' => 'LIKE'
			]
		]
	];

	$image_query = new WP_Query($image_args);

	if ($image_query->have_posts()) {
		$attachment_id = $image_query->posts[0]->ID;
		set_post_thumbnail($post_id, $attachment_id);
		echo "✓ Created product '{$product['title']}' (ID: {$post_id}) with featured image\n";
	} else {
		echo "✓ Created product '{$product['title']}' (ID: {$post_id}) - no image found: {$product['image']}\n";
	}

	wp_reset_postdata();
}

echo "\nDone!\n";
