<?php
/**
 * Upload product carousel images to WordPress media library
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

echo "=== Uploading Product Carousel Images ===\n\n";

$source_dir = get_template_directory() . '/';
$images_to_upload = [
    'Placeholder Image copy.jpg',
    'Placeholder Image-1 copy.jpg',
    'Placeholder Image-2 copy.jpg',
    'Placeholder Image-3 copy.jpg',
];

$uploaded_ids = [];

foreach ($images_to_upload as $filename) {
    $source_file = $source_dir . $filename;

    if (!file_exists($source_file)) {
        echo "✗ File not found: $filename\n";
        continue;
    }

    // Check if already uploaded
    $existing = get_posts([
        'post_type' => 'attachment',
        'meta_query' => [[
            'key' => '_wp_attached_file',
            'value' => $filename,
            'compare' => 'LIKE'
        ]],
        'posts_per_page' => 1
    ]);

    if ($existing) {
        echo "  Already uploaded: $filename (ID: {$existing[0]->ID})\n";
        $uploaded_ids[$filename] = $existing[0]->ID;
        continue;
    }

    // Copy to temp location
    $tmp_file = wp_tempnam($filename);
    copy($source_file, $tmp_file);

    // Upload to media library
    $file_array = [
        'name' => $filename,
        'tmp_name' => $tmp_file
    ];

    $attachment_id = media_handle_sideload($file_array, 0);

    if (is_wp_error($attachment_id)) {
        echo "✗ Error uploading $filename: " . $attachment_id->get_error_message() . "\n";
        @unlink($tmp_file);
    } else {
        echo "✓ Uploaded: $filename (ID: $attachment_id)\n";
        $uploaded_ids[$filename] = $attachment_id;
    }
}

echo "\n✅ Uploaded " . count($uploaded_ids) . " images\n";
print_r($uploaded_ids);
