<?php
/**
 * Debug attachment filenames
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

global $wpdb;

echo "=== Recent Attachments ===\n\n";

$attachments = $wpdb->get_results("
    SELECT p.ID, p.post_title, pm.meta_value as filename
    FROM $wpdb->posts p
    LEFT JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file'
    WHERE p.post_type = 'attachment'
    ORDER BY p.ID DESC
    LIMIT 10
");

foreach ($attachments as $att) {
    echo "ID: {$att->ID}\n";
    echo "Title: {$att->post_title}\n";
    echo "File: {$att->filename}\n\n";
}
