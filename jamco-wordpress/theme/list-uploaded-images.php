<?php
/**
 * List all uploaded images in WordPress
 */

$images = get_posts([
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
]);

echo "=== Uploaded Images in WordPress ===\n\n";

foreach ($images as $image) {
    $filename = basename(get_attached_file($image->ID));
    echo "ID: {$image->ID} | {$filename} | {$image->post_title}\n";
}

echo "\nTotal: " . count($images) . " images\n";
