<?php
/**
 * Upload carousel product images
 */

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

$images = [
	'Placeholder Image-2 copy.jpg',
	'Placeholder Image-1 copy.jpg',
	'Placeholder Image copy.jpg',
	'Placeholder Image-3 copy.jpg'
];

$theme_dir = get_template_directory();

foreach ($images as $image_name) {
	$file_path = $theme_dir . '/' . $image_name;

	if (!file_exists($file_path)) {
		echo "File not found: {$file_path}\n";
		continue;
	}

	// Check if already uploaded
	$existing = get_posts([
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
		'meta_query' => [
			[
				'key' => '_wp_attached_file',
				'value' => basename($image_name),
				'compare' => 'LIKE'
			]
		]
	]);

	if (!empty($existing)) {
		echo "Image already uploaded: {$image_name} (ID: {$existing[0]->ID})\n";
		continue;
	}

	// Upload the file
	$upload = wp_upload_bits($image_name, null, file_get_contents($file_path));

	if ($upload['error']) {
		echo "Error uploading {$image_name}: {$upload['error']}\n";
		continue;
	}

	// Create attachment
	$attachment = [
		'post_mime_type' => $upload['type'],
		'post_title' => pathinfo($image_name, PATHINFO_FILENAME),
		'post_content' => '',
		'post_status' => 'inherit'
	];

	$attachment_id = wp_insert_attachment($attachment, $upload['file']);

	if (is_wp_error($attachment_id)) {
		echo "Error creating attachment: " . $attachment_id->get_error_message() . "\n";
		continue;
	}

	// Generate metadata
	$metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
	wp_update_attachment_metadata($attachment_id, $metadata);

	echo "✓ Uploaded {$image_name} (ID: {$attachment_id})\n";
}

echo "\nDone!\n";
