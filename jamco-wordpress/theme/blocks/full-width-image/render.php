<?php
/**
 * Full Width Image Block Template
 */

$image_id = $attributes['image'] ?? 0;
$caption = $attributes['caption'] ?? '';
$height = $attributes['height'] ?? 'auto';
$watermark = $attributes['watermark'] ?? '';
$show_nav_arrows = $attributes['showNavArrows'] ?? false;

$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
$image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';

$heights = [
	'auto' => 'auto',
	'tall' => '800px',
	'medium' => '600px',
	'short' => '400px'
];
$container_height = $heights[$height] ?? $height;
?>

<?php if ($image_url) : ?>
	<section class="full-width-image">
		<div class="image-container" style="height: <?php echo esc_attr($container_height); ?>">
			<img src="<?php echo esc_url($image_url); ?>"
				 alt="<?php echo esc_attr($image_alt); ?>"
				 loading="lazy" />

			<?php if ($watermark) : ?>
				<div class="watermark">
					<span class="watermark-text"><?php echo esc_html($watermark); ?></span>
				</div>
			<?php endif; ?>

			<?php if ($show_nav_arrows) : ?>
				<button class="nav-arrow next" aria-label="Next">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M9 18l6-6-6-6"/>
					</svg>
				</button>
			<?php endif; ?>
		</div>

		<?php if ($caption) : ?>
			<p class="caption"><?php echo esc_html($caption); ?></p>
		<?php endif; ?>
	</section>
<?php endif; ?>
