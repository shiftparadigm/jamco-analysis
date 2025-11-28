<?php
/**
 * Hero Block Template
 */

// Get data from block attributes
$data = $block_attributes['data'] ?? array();

$heading = $data['heading'] ?? '';
$subheading = $data['subheading'] ?? '';
$primary_cta = $data['primary_cta'] ?? null;
$secondary_cta = $data['secondary_cta'] ?? null;
$feature_callout = $data['feature_callout'] ?? null;
$carousel_indicator = $data['carousel_indicator'] ?? '';

// Handle image - if it's an ID, get the URL
$floating_image_id = $data['floating_image'] ?? 0;
$floating_image = null;
if ($floating_image_id) {
    $image_url = wp_get_attachment_image_url($floating_image_id, 'full');
    $image_alt = get_post_meta($floating_image_id, '_wp_attachment_image_alt', true);
    if ($image_url) {
        $floating_image = array(
            'url' => $image_url,
            'alt' => $image_alt
        );
    }
}
?>

<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <?php if ($heading) : ?>
                <h1><?php echo esc_html($heading); ?></h1>
            <?php endif; ?>

            <?php if ($subheading) : ?>
                <p class="subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($primary_cta || $secondary_cta) : ?>
                <div class="hero-ctas">
                    <?php if ($primary_cta) : ?>
                        <a href="<?php echo esc_url($primary_cta['url']); ?>" class="btn btn-<?php echo esc_attr($primary_cta['style'] ?: 'primary'); ?>">
                            <?php echo esc_html($primary_cta['text']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_cta) : ?>
                        <a href="<?php echo esc_url($secondary_cta['url']); ?>" class="btn btn-<?php echo esc_attr($secondary_cta['style'] ?: 'outline'); ?>">
                            <?php echo esc_html($secondary_cta['text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($floating_image) : ?>
            <div class="hero-image">
                <img src="<?php echo esc_url($floating_image['url']); ?>" alt="<?php echo esc_attr($floating_image['alt'] ?: ''); ?>" />

                <?php if ($feature_callout) : ?>
                    <div class="feature-callout">
                        <strong><?php echo esc_html($feature_callout['label']); ?></strong>
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
