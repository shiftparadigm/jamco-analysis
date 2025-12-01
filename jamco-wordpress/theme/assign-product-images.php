<?php
/**
 * Assign images to product posts
 */

$products_images = [
	'flight-deck-doors-linings' => 'Placeholder Image-2 copy',
	'dividers-partitions' => 'Placeholder Image-1 copy',
	'closets-stowage' => 'Placeholder Image copy',
	'lavatories' => 'Placeholder Image-3 copy'
];

foreach ($products_images as $slug => $image_title) {
	// Get product
	$product = get_page_by_path($slug, OBJECT, 'product');
	if (!$product) {
		echo "Product not found: {$slug}\n";
		continue;
	}

	// Find image by title
	$image_args = [
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
		'post_mime_type' => 'image',
		'title' => $image_title
	];

	$images = get_posts($image_args);

	if (empty($images)) {
		echo "Image not found: {$image_title}\n";
		continue;
	}

	$image_id = $images[0]->ID;
	set_post_thumbnail($product->ID, $image_id);
	echo "✓ Set image for {$slug} (Product ID: {$product->ID}, Image ID: {$image_id})\n";
}

echo "\nDone!\n";
