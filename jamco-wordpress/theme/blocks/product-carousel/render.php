<?php
/**
 * Product Carousel Block Template
 */

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$label = $attributes['label'] ?? '';
$product_refs = $attributes['productRefs'] ?? [];

// Convert product refs to actual product data
$products = [];
$product_map = [
	'product-flight-deck-doors' => 'flight-deck-doors-linings',
	'product-dividers-partitions' => 'dividers-partitions',
	'product-closets-stowage' => 'closets-stowage',
	'product-lavatories' => 'lavatories'
];

foreach ($product_refs as $ref) {
	// Use mapped slug if available, otherwise strip product- prefix
	$slug = isset($product_map[$ref]) ? $product_map[$ref] : str_replace('product-', '', $ref);

	$product_query = new WP_Query([
		'post_type' => 'product',
		'name' => $slug,
		'posts_per_page' => 1
	]);

	if ($product_query->have_posts()) {
		$product_query->the_post();
		$image_id = get_post_thumbnail_id();
		$products[] = [
			'name' => get_the_title(),
			'image' => $image_id,
			'link' => get_permalink()
		];
		wp_reset_postdata();
	}
}
?>

<section class="product-carousel">
	<div class="carousel-header">
		<div class="header-content">
			<?php if ($heading) : ?>
				<h3><?php echo esc_html($heading); ?></h3>
			<?php endif; ?>
			<?php if ($description) : ?>
				<p class="description"><?php echo esc_html($description); ?></p>
			<?php endif; ?>
		</div>
		<?php if ($label) : ?>
			<span class="label"><?php echo esc_html($label); ?></span>
		<?php endif; ?>
	</div>

	<?php if (!empty($products)) : ?>
		<div class="carousel-wrapper">
			<div class="carousel">
				<div class="carousel-track">
					<?php foreach ($products as $product) : ?>
						<?php
						$name = $product['name'] ?? '';
						$image_id = $product['image'] ?? null;
						$link = $product['link'] ?? '#';
						$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
						?>
						<div class="product-card">
							<?php if ($image_url) : ?>
								<img src="<?php echo esc_url($image_url); ?>"
									 alt="<?php echo esc_attr($name); ?>"
									 loading="lazy" />
							<?php endif; ?>
							<div class="product-label">
								<h5><?php echo esc_html($name); ?></h5>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="carousel-controls">
				<button class="carousel-nav prev" aria-label="Previous">←</button>
				<span class="pagination">
					<span class="current">01</span> / <span class="total"><?php echo str_pad(count($products), 2, '0', STR_PAD_LEFT); ?></span>
				</span>
				<button class="carousel-nav next" aria-label="Next">→</button>
			</div>
		</div>
	<?php endif; ?>
</section>
