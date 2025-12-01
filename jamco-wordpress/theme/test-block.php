<?php
/**
 * Simple test block to verify block registration works
 */

function jamco_register_test_block() {
	wp_register_script(
		'jamco-test-block',
		false,
		array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
		'1.0.0'
	);

	wp_add_inline_script(
		'jamco-test-block',
		"
		(function(blocks, element) {
			var el = element.createElement;
			blocks.registerBlockType('jamco/test', {
				title: 'Test Block',
				icon: 'smiley',
				category: 'common',
				edit: function() {
					return el('p', {}, 'Hello from Test Block - IT WORKS!');
				},
				save: function() {
					return el('p', {}, 'Test block content');
				}
			});
		})(window.wp.blocks, window.wp.element);
		"
	);

	register_block_type('jamco/test', array(
		'editor_script' => 'jamco-test-block',
	));
}
add_action('init', 'jamco_register_test_block');
