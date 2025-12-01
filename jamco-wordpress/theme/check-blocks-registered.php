<?php
/**
 * Quick script to check if blocks are registered
 */

require_once '../../../wp-load.php';

$registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

echo "=== JAMCO BLOCKS ===\n\n";

foreach ($registered_blocks as $block_name => $block_type) {
	if (strpos($block_name, 'jamco/') === 0) {
		echo "Block: $block_name\n";
		echo "  Editor Script: " . ($block_type->editor_script ?? 'none') . "\n";
		echo "  Script Handles: " . print_r($block_type->editor_script_handles, true);
		echo "\n";
	}
}
