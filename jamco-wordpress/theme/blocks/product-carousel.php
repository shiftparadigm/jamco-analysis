<?php
/**
 * Product Carousel Block Template
 */

$heading = get_field('heading');
$description = get_field('description');
$label = get_field('label');
$product_ids = get_field('products') ?: array();
$show_pagination = get_field('show_pagination');

// Get product objects from IDs
$products = array();
if ($product_ids) {
    foreach ($product_ids as $product_id) {
        $product = get_post($product_id);
        if ($product) {
            $products[] = $product;
        }
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

    <div class="carousel-wrapper">
        <div class="carousel">
            <div class="carousel-track">
                <?php if ($products) : foreach ($products as $product) :
                    $thumbnail = get_the_post_thumbnail_url($product->ID, 'medium');
                    ?>
                    <div class="product-card">
                        <?php if ($thumbnail) : ?>
                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($product->post_title); ?>" />
                        <?php endif; ?>
                        <div class="product-label">
                            <h5><?php echo esc_html($product->post_title); ?></h5>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <?php if ($show_pagination && $products && count($products) > 1) : ?>
            <div class="carousel-controls">
                <button class="carousel-nav prev" aria-label="Previous">←</button>
                <span class="pagination">
                    <span class="current">01</span> / <span class="total"><?php echo str_pad(count($products), 2, '0', STR_PAD_LEFT); ?></span>
                </span>
                <button class="carousel-nav next" aria-label="Next">→</button>
            </div>
        <?php endif; ?>
    </div>
</section>
