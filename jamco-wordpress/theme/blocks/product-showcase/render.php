<?php
/**
 * Product Showcase Block Template
 */

$product_id = $attributes['productId'] ?? 0;
$heading = $attributes['heading'] ?? '';
$subheading = $attributes['subheading'] ?? '';
$brand_name = $attributes['brandName'] ?? '';
$brand_description = $attributes['brandDescription'] ?? '';
$description = $attributes['description'] ?? $brand_description;
$cta_button = $attributes['ctaButton'] ?? [];
$secondary_cta_button = $attributes['secondaryCtaButton'] ?? [];
$showcase_image_id = $attributes['showcaseImage'] ?? 0;

$product = $product_id ? get_post($product_id) : null;
$thumbnail_id = $showcase_image_id ?: ($product_id ? get_post_thumbnail_id($product_id) : 0);
$thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'large') : '';
$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';
$background_color = $attributes['backgroundColor'] ?? 'light-blue';
$bg_class = 'bg-' . $background_color;
?>

<section class="product-showcase <?php echo esc_attr($bg_class); ?>">
	<div class="product-showcase-container">
		<div class="showcase-content">
			<?php if ($heading) : ?>
				<h2 class="showcase-heading"><?php echo esc_html($heading); ?></h2>
			<?php elseif ($product) : ?>
				<h2 class="showcase-heading"><?php echo esc_html($product->post_title); ?></h2>
			<?php endif; ?>

			<?php if ($subheading) : ?>
				<p class="showcase-subheading"><?php echo esc_html($subheading); ?></p>
			<?php endif; ?>

			<?php if ($brand_name) : ?>
				<p class="brand-name"><strong><?php echo esc_html($brand_name); ?></strong></p>
			<?php endif; ?>

			<?php if ($description) : ?>
				<p class="showcase-description"><?php echo esc_html($description); ?></p>
			<?php elseif ($product) : ?>
				<p class="showcase-description"><?php echo esc_html(get_the_excerpt($product_id)); ?></p>
			<?php endif; ?>

			<?php if (!empty($cta_button['text']) || !empty($secondary_cta_button['text'])) : ?>
				<div class="showcase-ctas">
					<?php if (!empty($cta_button['text'])) : ?>
						<a href="<?php echo esc_url($cta_button['url'] ?? '#'); ?>"
						   class="btn btn-<?php echo esc_attr($cta_button['style'] ?? 'primary'); ?>">
							<?php echo esc_html($cta_button['text']); ?>
						</a>
					<?php endif; ?>

					<?php if (!empty($secondary_cta_button['text'])) : ?>
						<a href="<?php echo esc_url($secondary_cta_button['url'] ?? '#'); ?>"
						   class="btn btn-<?php echo esc_attr($secondary_cta_button['style'] ?? 'outline'); ?>">
							<?php echo esc_html($secondary_cta_button['text']); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($thumbnail_url) : ?>
			<div class="showcase-image">
				<img src="<?php echo esc_url($thumbnail_url); ?>"
					 alt="<?php echo esc_attr($thumbnail_alt ?: ($product ? $product->post_title : '')); ?>" />
			</div>
		<?php endif; ?>
	</div>
</section>
