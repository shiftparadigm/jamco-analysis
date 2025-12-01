<?php
/**
 * Feature Grid Block Template
 */

$features = $attributes['features'] ?? [];
?>

<?php if (!empty($features)) : ?>
	<section class="feature-grid">
		<div class="container">
			<div class="feature-grid-container">
				<?php foreach ($features as $feature) : ?>
				<div class="feature-card">
					<?php if (!empty($feature['image'])) : ?>
						<?php
						$image_id = is_numeric($feature['image']) ? $feature['image'] : null;
						if ($image_id) :
							$image_url = wp_get_attachment_image_url($image_id, 'medium_large');
							if ($image_url) :
						?>
							<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($feature['heading'] ?? ''); ?>" loading="lazy" />
						<?php
							endif;
						endif;
						?>
					<?php endif; ?>

					<?php if (!empty($feature['heading'])) : ?>
						<h6><?php echo esc_html($feature['heading']); ?></h6>
					<?php endif; ?>

					<?php if (!empty($feature['description'])) : ?>
						<p><?php echo esc_html($feature['description']); ?></p>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
