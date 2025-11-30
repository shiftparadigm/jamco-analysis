<?php
/**
 * Hero Block Template
 */

// Get data from attributes
$heading = $attributes['heading'] ?? '';
$subheading = $attributes['subheading'] ?? '';
$primary_cta = $attributes['primaryCta'] ?? [];
$secondary_cta = $attributes['secondaryCta'] ?? [];
$feature_callout = $attributes['featureCallout'] ?? [];
$carousel_indicator = $attributes['carouselIndicator'] ?? '';
$floating_image_id = $attributes['floatingImage'] ?? 0;

// Get image data
$floating_image_url = $floating_image_id ? wp_get_attachment_image_url($floating_image_id, 'large') : '';
$floating_image_alt = $floating_image_id ? get_post_meta($floating_image_id, '_wp_attachment_image_alt', true) : '';
?>

<section class="hero">
	<div class="hero-container">
		<div class="hero-content">
			<?php if ($heading) : ?>
				<h1 class="hero-heading"><?php echo esc_html($heading); ?></h1>
			<?php endif; ?>

			<?php if ($subheading) : ?>
				<p class="hero-subheading"><?php echo esc_html($subheading); ?></p>
			<?php endif; ?>

			<div class="hero-ctas">
				<?php if (!empty($primary_cta['text'])) : ?>
					<a href="<?php echo esc_url($primary_cta['url'] ?? '#'); ?>" class="btn btn-primary">
						<?php echo esc_html($primary_cta['text']); ?>
					</a>
				<?php endif; ?>

				<?php if (!empty($secondary_cta['text'])) : ?>
					<a href="<?php echo esc_url($secondary_cta['url'] ?? '#'); ?>" class="btn btn-outline">
						<?php echo esc_html($secondary_cta['text']); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<?php if ($floating_image_url) : ?>
			<div class="hero-image">
				<img src="<?php echo esc_url($floating_image_url); ?>"
					 alt="<?php echo esc_attr($floating_image_alt); ?>" />

				<?php if (!empty($feature_callout['label']) || !empty($feature_callout['description'])) : ?>
					<div class="feature-callout">
						<?php if (!empty($feature_callout['label'])) : ?>
							<strong><?php echo esc_html($feature_callout['label']); ?></strong>
						<?php endif; ?>
						<?php if (!empty($feature_callout['description'])) : ?>
							<p><?php echo esc_html($feature_callout['description']); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ($carousel_indicator) : ?>
					<span class="carousel-indicator"><?php echo esc_html($carousel_indicator); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
