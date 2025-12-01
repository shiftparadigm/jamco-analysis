<?php
/**
 * Seating Diagram Block Template
 */

$diagram_image_id = $attributes['diagramImage'] ?? 0;
$hotspots = $attributes['hotspots'] ?? [];
$brand_logos = $attributes['brandLogos'] ?? [];

$diagram_image_url = $diagram_image_id ? wp_get_attachment_image_url($diagram_image_id, 'full') : '';
?>

<?php if ($diagram_image_url) : ?>
	<section class="seating-diagram">
		<div class="diagram-container">
			<img src="<?php echo esc_url($diagram_image_url); ?>" alt="Seating Diagram" class="diagram-image" />

			<?php if (!empty($brand_logos)) : ?>
				<div class="brand-logos">
					<?php foreach ($brand_logos as $logo) : ?>
						<div class="brand-logo">
							<div class="logo-name"><?php echo esc_html($logo['name'] ?? ''); ?></div>
							<?php if (!empty($logo['tagline'])) : ?>
								<div class="logo-tagline"><?php echo esc_html($logo['tagline']); ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($hotspots)) : ?>
				<div class="diagram-hotspots">
					<?php foreach ($hotspots as $hotspot) : ?>
						<?php if (isset($hotspot['x']) && isset($hotspot['y'])) : ?>
							<div class="hotspot"
								 style="left: <?php echo esc_attr($hotspot['x']); ?>%; top: <?php echo esc_attr($hotspot['y']); ?>%;"
								 data-label="<?php echo esc_attr($hotspot['label'] ?? ''); ?>">
								<span class="hotspot-marker"></span>
								<?php if (!empty($hotspot['label'])) : ?>
									<span class="hotspot-label"><?php echo esc_html($hotspot['label']); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
