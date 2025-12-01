<?php
/**
 * Upload Sanity images to WordPress media library
 *
 * Run with: npm run wp-env run cli wp eval-file /var/www/html/wp-content/themes/jamco/upload-sanity-images.php
 */

// Read the mapping file
$mapping_json = file_get_contents(__DIR__ . '/sanity-image-mapping.json');
$mapping = json_decode($mapping_json, true);

if (!$mapping) {
    echo "Error: Could not read mapping file\n";
    exit(1);
}

$wordpress_mapping = [];

foreach ($mapping as $sanity_id => $image_data) {
    $filename = $image_data['filename'];
    $filepath = __DIR__ . '/sanity-images/' . $filename;

    if (!file_exists($filepath)) {
        echo "Warning: File not found: $filepath\n";
        continue;
    }

    echo "Uploading $filename...\n";

    // Check if image already exists by filename
    $existing = get_posts([
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'title' => pathinfo($filename, PATHINFO_FILENAME),
        'posts_per_page' => 1
    ]);

    if (!empty($existing)) {
        $attachment_id = $existing[0]->ID;
        echo "  -> Already exists (ID: $attachment_id)\n";
    } else {
        // Upload to WordPress
        $file_array = [
            'name' => $filename,
            'tmp_name' => $filepath
        ];

        // Don't use require_once, these files are already loaded
        $attachment_id = media_handle_sideload($file_array, 0);

        if (is_wp_error($attachment_id)) {
            echo "  -> Error uploading: " . $attachment_id->get_error_message() . "\n";
            continue;
        }

        echo "  -> Uploaded (ID: $attachment_id)\n";
    }

    $wordpress_mapping[$sanity_id] = $attachment_id;
}

// Save the WordPress mapping
file_put_contents(__DIR__ . '/wordpress-image-mapping.json', json_encode($wordpress_mapping, JSON_PRETTY_PRINT));

echo "\n✅ Upload complete!\n";
echo "WordPress mapping saved to wordpress-image-mapping.json\n\n";
echo "Mappings:\n";
foreach ($wordpress_mapping as $sanity_id => $wp_id) {
    echo "  $sanity_id => $wp_id\n";
}
