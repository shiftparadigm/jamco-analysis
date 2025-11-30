<?php
/**
 * CTA Block Template
 */

$heading = $attributes['heading'] ?? '';
$subheading = $attributes['subheading'] ?? '';
$cta_button = $attributes['ctaButton'] ?? [];
$background_image_id = $attributes['backgroundImage'] ?? 0;

$background_image_url = ''; // Background image disabled
$style = '';
?>

<section class="cta-section">
	<div class="cta-overlay">
		<div class="cta-container">
			<?php if ($heading) : ?>
				<h2 class="cta-heading"><?php echo esc_html($heading); ?></h2>
			<?php endif; ?>

			<?php if ($subheading) : ?>
				<p class="cta-subheading"><?php echo esc_html($subheading); ?></p>
			<?php endif; ?>

			<?php if (!empty($cta_button['text'])) : ?>
				<a href="<?php echo esc_url($cta_button['url'] ?? '#'); ?>"
				   class="btn btn-<?php echo esc_attr($cta_button['style'] ?? 'primary'); ?>">
					<?php echo esc_html($cta_button['text']); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
