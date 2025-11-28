<?php
/**
 * Product Showcase Block Template
 */

$heading = get_field('heading');
$subheading = get_field('subheading');
$brand_name = get_field('brand_name');
$brand_description = get_field('brand_description');
$product_image = get_field('product_image');
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
