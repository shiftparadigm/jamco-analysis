<?php
/**
 * Split Feature Block Template
 */

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$bullet_points = $attributes['bulletPoints'] ?? [];
$image_position = $attributes['imagePosition'] ?? 'right';
$background_color = $attributes['backgroundColor'] ?? 'white';
$cta_button = $attributes['ctaButton'] ?? [];
$feature_image_id = $attributes['featureImage'] ?? 0;

$feature_image_url = $feature_image_id ? wp_get_attachment_image_url($feature_image_id, 'large') : '';
$feature_image_alt = $feature_image_id ? get_post_meta($feature_image_id, '_wp_attachment_image_alt', true) : '';

$bg_class = 'bg-' . $background_color;
$layout_class = 'image-' . $image_position;
?>

<section class="split-feature <?php echo esc_attr($bg_class); ?> <?php echo esc_attr($layout_class); ?>">
	<div class="split-feature-container">
		<div class="content-side">
			<?php if ($heading) : ?>
				<h2><?php echo esc_html($heading); ?></h2>
			<?php endif; ?>

			<?php if ($description) : ?>
				<p class="description"><?php echo esc_html($description); ?></p>
			<?php endif; ?>

			<?php if (!empty($bullet_points)) : ?>
				<ul class="bullet-points">
					<?php foreach ($bullet_points as $bullet) : ?>
						<li><?php echo esc_html($bullet); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if (!empty($cta_button['text'])) : ?>
				<?php
				$cta_href = '#';
				if (!empty($cta_button['externalUrl'])) {
					$cta_href = $cta_button['externalUrl'];
				} elseif (!empty($cta_button['url'])) {
					$cta_href = $cta_button['url'];
				}
				?>
				<a href="<?php echo esc_url($cta_href); ?>"
				   class="btn btn-<?php echo esc_attr($cta_button['style'] ?? 'primary'); ?>">
					<?php echo esc_html($cta_button['text']); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php if ($feature_image_url) : ?>
			<div class="image-side">
				<img src="<?php echo esc_url($feature_image_url); ?>"
					 alt="<?php echo esc_attr($feature_image_alt ?: $heading); ?>"
					 loading="lazy" />
			</div>
		<?php endif; ?>
	</div>
</section>
