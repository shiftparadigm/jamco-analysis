<?php
/**
 * Product Showcase Block Template
 */

$data = $block_attributes['data'] ?? array();

$heading = $data['heading'] ?? '';
$subheading = $data['subheading'] ?? '';
$brand_name = $data['brand_name'] ?? '';
$brand_description = $data['brand_description'] ?? '';

// Handle image
$product_image_id = $data['product_image'] ?? 0;
$product_image = null;
if ($product_image_id) {
    $image_url = wp_get_attachment_image_url($product_image_id, 'full');
    $image_alt = get_post_meta($product_image_id, '_wp_attachment_image_alt', true);
    if ($image_url) {
        $product_image = array(
            'url' => $image_url,
            'alt' => $image_alt
        );
    }
}
?>

<section class="product-showcase">
    <div class="showcase-container">
        <div class="showcase-content">
            <?php if ($brand_name) : ?>
                <div class="brand-name"><?php echo esc_html($brand_name); ?></div>
            <?php endif; ?>

            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($subheading) : ?>
                <p class="subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($brand_description) : ?>
                <p class="brand-description"><?php echo esc_html($brand_description); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($product_image) : ?>
            <div class="showcase-image">
                <img src="<?php echo esc_url($product_image['url']); ?>" alt="<?php echo esc_attr($product_image['alt'] ?: ''); ?>" />
            </div>
        <?php endif; ?>
    </div>
</section>
