<?php
/**
 * Upload Rectangle 5.jpg and update full-width-image block
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

echo "=== Uploading Rectangle 5.jpg ===\n\n";

$source_file = get_template_directory() . '/Rectangle 5.jpg';

if (!file_exists($source_file)) {
    die("✗ File not found: Rectangle 5.jpg\n");
}

// Check if already uploaded
global $wpdb;
$existing_id = $wpdb->get_var($wpdb->prepare(
    "SELECT post_id FROM $wpdb->postmeta
    WHERE meta_key = '_wp_attached_file'
    AND meta_value LIKE %s
    LIMIT 1",
    '%' . $wpdb->esc_like('Rectangle-5')
));

if ($existing_id) {
    echo "✓ Image already uploaded (ID: $existing_id)\n";
    $attachment_id = $existing_id;
} else {
    // Upload to media library
    $tmp_file = wp_tempnam('Rectangle 5.jpg');
    copy($source_file, $tmp_file);

    $file_array = [
        'name' => 'Rectangle 5.jpg',
        'tmp_name' => $tmp_file
    ];

    $attachment_id = media_handle_sideload($file_array, 0);

    if (is_wp_error($attachment_id)) {
        echo "✗ Error uploading: " . $attachment_id->get_error_message() . "\n";
        @unlink($tmp_file);
        die();
    }

    echo "✓ Uploaded Rectangle 5.jpg (ID: $attachment_id)\n";
}

// Update full-width-image block
$page = get_page_by_path('premium-seating', OBJECT, 'page');
if (!$page) {
    die("✗ Page not found\n");
}

$blocks = parse_blocks($page->post_content);
$updated = false;

foreach ($blocks as &$block) {
    if ($block['blockName'] === 'jamco/full-width-image') {
        $block['attrs']['image'] = $attachment_id;

        // Rebuild block comment
        $attrs_json = json_encode($block['attrs']);
        $block['innerHTML'] = "<!-- wp:jamco/full-width-image $attrs_json /-->";

        $updated = true;
        echo "✓ Updated full-width-image block with image ID\n";
        break;
    }
}

if ($updated) {
    $content = serialize_blocks($blocks);

    $result = wp_update_post([
        'ID' => $page->ID,
        'post_content' => $content,
    ]);

    if (is_wp_error($result)) {
        echo "✗ Error updating page: " . $result->get_error_message() . "\n";
    } else {
        echo "\n✅ Successfully updated full-width-image block!\n";
    }
} else {
    echo "✗ full-width-image block not found\n";
}
